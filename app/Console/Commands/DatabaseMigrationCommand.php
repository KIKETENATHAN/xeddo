<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class DatabaseMigrationCommand extends Command
{
    protected $signature = 'db:migrate-to-mysql 
                           {--output=exports : Output directory for export files}
                           {--file=mysql_export.sql : Name of the export file}
                           {--compress : Compress the export file}
                           {--data-only : Export data only, skip table structure}
                           {--structure-only : Export structure only, skip data}';

    protected $description = 'Migrate SQLite database to MySQL format with comprehensive export options';

    private $outputDir;
    private $tables = [];
    private $foreignKeys = [];
    private $totalRecords = 0;

    public function handle()
    {
        $this->outputDir = $this->option('output');
        
        // Create output directory
        if (!File::exists($this->outputDir)) {
            File::makeDirectory($this->outputDir, 0755, true);
        }

        $this->info('🚀 Starting SQLite to MySQL migration...');
        $this->newLine();

        try {
            $this->analyzeDatabaseStructure();
            $this->generateMySQLExport();
            $this->generateHelperFiles();
            $this->showMigrationSummary();
            
        } catch (\Exception $e) {
            $this->error('❌ Migration failed: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function analyzeDatabaseStructure()
    {
        $this->info('🔍 Analyzing database structure...');

        // Get all tables
        $this->tables = collect(DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'"))
            ->pluck('name')
            ->toArray();

        $this->line("📊 Found " . count($this->tables) . " tables: " . implode(', ', $this->tables));

        // Analyze foreign keys and record counts
        foreach ($this->tables as $table) {
            // Get foreign keys
            $fks = DB::select("PRAGMA foreign_key_list($table)");
            if (!empty($fks)) {
                $this->foreignKeys[$table] = $fks;
            }

            // Count records
            $count = DB::table($table)->count();
            $this->totalRecords += $count;
            
            if ($this->output->isVerbose()) {
                $this->line("   └── $table: $count records");
            }
        }

        $this->info("✅ Analysis complete. Total records: {$this->totalRecords}");
    }

    private function generateMySQLExport()
    {
        $filename = $this->outputDir . '/' . $this->option('file');
        $this->info("🔄 Generating MySQL export: $filename");

        $content = $this->generateExportHeader();
        
        $progressBar = $this->output->createProgressBar(count($this->tables) * 2);
        $progressBar->setFormat('detailed');

        // Generate table structures
        if (!$this->option('data-only')) {
            foreach ($this->tables as $table) {
                $content .= $this->generateTableStructure($table);
                $progressBar->advance();
            }
        }

        // Generate table data
        if (!$this->option('structure-only')) {
            foreach ($this->tables as $table) {
                $content .= $this->generateTableData($table);
                $progressBar->advance();
            }
        }

        // Add foreign key constraints
        if (!$this->option('data-only')) {
            foreach ($this->tables as $table) {
                if (isset($this->foreignKeys[$table])) {
                    $content .= $this->generateForeignKeyConstraints($table);
                }
            }
        }

        $content .= $this->generateExportFooter();

        $progressBar->finish();
        $this->newLine(2);

        // Write file
        File::put($filename, $content);

        // Optionally compress
        if ($this->option('compress')) {
            $this->compressExportFile($filename);
        }

        $fileSize = $this->formatBytes(File::size($filename));
        $this->info("✅ Export completed: $filename ($fileSize)");
    }

    private function generateExportHeader()
    {
        $appName = config('app.name', 'Laravel Application');
        $timestamp = now()->format('Y-m-d H:i:s');
        
        return "-- MySQL Export for $appName
-- Generated on $timestamp
-- Laravel Database Migration from SQLite to MySQL
-- 
-- IMPORTANT: Review and test this export before using in production
-- 

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = \"+00:00\";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

";
    }

    private function generateTableStructure($table)
    {
        $columns = collect(DB::select("PRAGMA table_info($table)"));
        $indexes = collect(DB::select("PRAGMA index_list($table)"));

        $content = "-- --------------------------------------------------------\n";
        $content .= "-- Table structure for table `$table`\n";
        $content .= "-- --------------------------------------------------------\n\n";
        
        $content .= "DROP TABLE IF EXISTS `$table`;\n";
        $content .= "CREATE TABLE `$table` (\n";

        $columnDefinitions = [];
        $primaryKeys = [];

        foreach ($columns as $column) {
            $name = $column->name;
            $type = $this->convertSQLiteTypeToMySQL($column->type, $column->pk);
            $nullable = $column->notnull ? 'NOT NULL' : 'NULL';
            $default = $this->convertDefaultValue($column->dflt_value);
            $autoIncrement = ($column->pk && strtoupper($column->type) === 'INTEGER') ? 'AUTO_INCREMENT' : '';

            $definition = "  `$name` $type $nullable $default $autoIncrement";
            $columnDefinitions[] = trim($definition);

            if ($column->pk) {
                $primaryKeys[] = "`$name`";
            }
        }

        $content .= implode(",\n", $columnDefinitions);

        // Add primary key
        if (!empty($primaryKeys)) {
            $content .= ",\n  PRIMARY KEY (" . implode(', ', $primaryKeys) . ")";
        }

        // Add unique indexes
        foreach ($indexes as $index) {
            if ($index->unique && $index->name !== "sqlite_autoindex_{$table}_1") {
                $indexColumns = collect(DB::select("PRAGMA index_info({$index->name})"))
                    ->map(fn($col) => "`{$col->name}`")
                    ->implode(', ');
                
                $content .= ",\n  UNIQUE KEY `{$index->name}` ($indexColumns)";
            }
        }

        $content .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        return $content;
    }

    private function generateTableData($table)
    {
        $recordCount = DB::table($table)->count();
        
        if ($recordCount === 0) {
            return "-- No data for table `$table`\n\n";
        }

        $content = "-- --------------------------------------------------------\n";
        $content .= "-- Dumping data for table `$table` ($recordCount records)\n";
        $content .= "-- --------------------------------------------------------\n\n";

        // Process in chunks for memory efficiency
        $chunkSize = 1000;
        $isFirstChunk = true;

        DB::table($table)->orderBy(DB::raw('1'))->chunk($chunkSize, function ($records) use (&$content, $table, &$isFirstChunk) {
            if ($records->isEmpty()) {
                return;
            }

            $firstRecord = $records->first();
            $columns = array_keys((array) $firstRecord);
            $columnsList = '`' . implode('`, `', $columns) . '`';

            $values = [];
            foreach ($records as $record) {
                $recordArray = (array) $record;
                $rowValues = [];
                
                foreach ($recordArray as $value) {
                    $rowValues[] = $this->escapeValue($value);
                }
                
                $values[] = '(' . implode(', ', $rowValues) . ')';
            }

            if ($isFirstChunk) {
                $content .= "INSERT INTO `$table` ($columnsList) VALUES\n";
                $isFirstChunk = false;
            } else {
                $content .= ",\n";
            }
            
            $content .= implode(",\n", $values);
        });

        if ($recordCount > 0) {
            $content .= ";\n\n";
        }

        return $content;
    }

    private function generateForeignKeyConstraints($table)
    {
        if (!isset($this->foreignKeys[$table])) {
            return '';
        }

        $content = "-- Foreign key constraints for table `$table`\n";

        foreach ($this->foreignKeys[$table] as $fk) {
            $constraintName = "fk_{$table}_{$fk->from}_{$fk->table}_{$fk->to}";
            $content .= "ALTER TABLE `$table` ADD CONSTRAINT `$constraintName` ";
            $content .= "FOREIGN KEY (`{$fk->from}`) REFERENCES `{$fk->table}` (`{$fk->to}`)";

            if ($fk->on_delete !== 'NO ACTION') {
                $content .= " ON DELETE {$fk->on_delete}";
            }
            if ($fk->on_update !== 'NO ACTION') {
                $content .= " ON UPDATE {$fk->on_update}";
            }

            $content .= ";\n";
        }

        return $content . "\n";
    }

    private function generateExportFooter()
    {
        return "\nSET FOREIGN_KEY_CHECKS = 1;\nCOMMIT;\n\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;\n\n-- Migration completed at " . now()->format('Y-m-d H:i:s') . "\n";
    }

    private function generateHelperFiles()
    {
        $this->info('📋 Generating helper files...');

        // Generate verification queries
        $this->generateVerificationQueries();
        
        // Generate environment template
        $this->generateEnvironmentTemplate();
        
        // Generate migration checklist
        $this->generateMigrationChecklist();
    }

    private function generateVerificationQueries()
    {
        $content = "-- Database Verification Queries\n";
        $content .= "-- Run these queries to verify your migration\n\n";

        $content .= "-- 1. Check all tables exist\n";
        $content .= "SHOW TABLES;\n\n";

        $content .= "-- 2. Verify record counts\n";
        foreach ($this->tables as $table) {
            $sqliteCount = DB::table($table)->count();
            $content .= "SELECT COUNT(*) as count_$table FROM `$table`; -- Expected: $sqliteCount\n";
        }

        $content .= "\n-- 3. Check table structures\n";
        foreach ($this->tables as $table) {
            $content .= "DESCRIBE `$table`;\n";
        }

        File::put($this->outputDir . '/verification_queries.sql', $content);
    }

    private function generateEnvironmentTemplate()
    {
        $content = "# MySQL Environment Configuration\n";
        $content .= "# Copy these settings to your .env file\n\n";
        $content .= "DB_CONNECTION=mysql\n";
        $content .= "DB_HOST=localhost\n";
        $content .= "DB_PORT=3306\n";
        $content .= "DB_DATABASE=your_database_name\n";
        $content .= "DB_USERNAME=your_username\n";
        $content .= "DB_PASSWORD=your_password\n\n";
        $content .= "# For cPanel hosting:\n";
        $content .= "# DB_HOST=localhost\n";
        $content .= "# DB_DATABASE=cpanel_user_dbname\n";
        $content .= "# DB_USERNAME=cpanel_user_dbuser\n";

        File::put($this->outputDir . '/.env.mysql', $content);
    }

    private function generateMigrationChecklist()
    {
        $content = "# MySQL Migration Checklist\n\n";
        $content .= "## Pre-Migration\n";
        $content .= "- [ ] Backup SQLite database\n";
        $content .= "- [ ] Test migration in development environment\n";
        $content .= "- [ ] Review generated SQL file\n\n";
        $content .= "## Migration Steps\n";
        $content .= "- [ ] Create MySQL database\n";
        $content .= "- [ ] Create database user with privileges\n";
        $content .= "- [ ] Import SQL file\n";
        $content .= "- [ ] Update .env file\n";
        $content .= "- [ ] Test database connection\n\n";
        $content .= "## Post-Migration\n";
        $content .= "- [ ] Run verification queries\n";
        $content .= "- [ ] Test application functionality\n";
        $content .= "- [ ] Monitor for errors\n";
        $content .= "- [ ] Update deployment scripts\n";

        File::put($this->outputDir . '/migration_checklist.md', $content);
    }

    private function convertSQLiteTypeToMySQL($type, $isPrimaryKey = false)
    {
        $type = strtoupper(trim($type));

        $typeMap = [
            'INTEGER' => $isPrimaryKey ? 'BIGINT UNSIGNED' : 'INT',
            'REAL' => 'DOUBLE',
            'NUMERIC' => 'DECIMAL(10,2)',
            'TEXT' => 'TEXT',
            'BLOB' => 'LONGBLOB',
            'BOOLEAN' => 'TINYINT(1)',
            'DATE' => 'DATE',
            'DATETIME' => 'DATETIME',
            'TIMESTAMP' => 'TIMESTAMP',
        ];

        if (isset($typeMap[$type])) {
            return $typeMap[$type];
        }

        // Handle VARCHAR with length
        if (preg_match('/VARCHAR\((\d+)\)/i', $type, $matches)) {
            return "VARCHAR({$matches[1]})";
        }

        return 'VARCHAR(255)'; // Default fallback
    }

    private function convertDefaultValue($defaultValue)
    {
        if ($defaultValue === null) {
            return '';
        }

        if ($defaultValue === 'CURRENT_TIMESTAMP') {
            return 'DEFAULT CURRENT_TIMESTAMP';
        }

        if (is_numeric($defaultValue)) {
            return "DEFAULT $defaultValue";
        }

        return "DEFAULT '" . addslashes($defaultValue) . "'";
    }

    private function escapeValue($value)
    {
        if ($value === null) {
            return 'NULL';
        }

        if (is_numeric($value)) {
            return $value;
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        return "'" . addslashes($value) . "'";
    }

    private function compressExportFile($filename)
    {
        $this->info('🗜️  Compressing export file...');
        
        $compressedFile = $filename . '.gz';
        
        if (function_exists('gzencode')) {
            $data = File::get($filename);
            $compressed = gzencode($data, 9);
            File::put($compressedFile, $compressed);
            
            $originalSize = File::size($filename);
            $compressedSize = File::size($compressedFile);
            $ratio = round((1 - $compressedSize / $originalSize) * 100, 1);
            
            $this->info("✅ Compressed: {$this->formatBytes($compressedSize)} (saved {$ratio}%)");
        } else {
            $this->warn('⚠️  Compression not available (gzencode function missing)');
        }
    }

    private function showMigrationSummary()
    {
        $this->newLine();
        $this->info('📊 Migration Summary:');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Tables migrated', count($this->tables)],
                ['Total records', number_format($this->totalRecords)],
                ['Foreign keys', count($this->foreignKeys)],
                ['Output directory', $this->outputDir],
                ['Export file', $this->option('file')],
            ]
        );

        $this->newLine();
        $this->info('🚀 Next Steps:');
        $this->line('1. Upload the export file to your hosting');
        $this->line('2. Create MySQL database and user');
        $this->line('3. Import the SQL file');
        $this->line('4. Update your .env file');
        $this->line('5. Test your application');

        $this->newLine();
        $this->info("✅ Migration export completed successfully!");
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }
}
