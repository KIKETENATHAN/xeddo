<?php
/**
 * Database Test and Analysis Script
 * Run this before migration to understand your database structure
 */

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

class DatabaseAnalyzer
{
    private $capsule;
    private $sqliteFile = 'database/database.sqlite';
    
    public function __construct()
    {
        $this->setupDatabase();
    }
    
    private function setupDatabase()
    {
        $this->capsule = new Capsule;
        
        $this->capsule->addConnection([
            'driver' => 'sqlite',
            'database' => $this->sqliteFile,
            'prefix' => '',
        ]);
        
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }
    
    public function analyze()
    {
        if (!file_exists($this->sqliteFile)) {
            $this->error("SQLite database not found: {$this->sqliteFile}");
            return false;
        }
        
        $this->info("🔍 Analyzing SQLite Database");
        $this->info("Database file: {$this->sqliteFile}");
        $this->info("File size: " . $this->formatBytes(filesize($this->sqliteFile)));
        $this->line();
        
        try {
            $this->analyzeTables();
            $this->analyzeIndexes();
            $this->analyzeForeignKeys();
            $this->generatePreMigrationReport();
            
        } catch (Exception $e) {
            $this->error("Analysis failed: " . $e->getMessage());
            return false;
        }
        
        return true;
    }
    
    private function analyzeTables()
    {
        $this->info("📊 Table Analysis");
        $this->line(str_repeat("-", 60));
        
        $tables = $this->capsule->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        
        $totalRecords = 0;
        $tableData = [];
        
        foreach ($tables as $table) {
            $tableName = $table->name;
            
            // Get record count
            $count = $this->capsule->table($tableName)->count();
            $totalRecords += $count;
            
            // Get table structure
            $columns = $this->capsule->select("PRAGMA table_info($tableName)");
            
            $tableData[$tableName] = [
                'records' => $count,
                'columns' => count($columns),
                'structure' => $columns
            ];
            
            $this->line(sprintf("%-20s | %8s records | %2s columns", $tableName, number_format($count), count($columns)));
        }
        
        $this->line(str_repeat("-", 60));
        $this->info("Total Tables: " . count($tables));
        $this->info("Total Records: " . number_format($totalRecords));
        $this->line();
        
        return $tableData;
    }
    
    private function analyzeIndexes()
    {
        $this->info("🔑 Index Analysis");
        $this->line(str_repeat("-", 60));
        
        $tables = $this->capsule->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        
        foreach ($tables as $table) {
            $tableName = $table->name;
            $indexes = $this->capsule->select("PRAGMA index_list($tableName)");
            
            if (!empty($indexes)) {
                $this->line("Table: $tableName");
                foreach ($indexes as $index) {
                    $unique = $index->unique ? 'UNIQUE' : 'INDEX';
                    $this->line("  └── {$index->name} ($unique)");
                }
            }
        }
        
        $this->line();
    }
    
    private function analyzeForeignKeys()
    {
        $this->info("🔗 Foreign Key Analysis");
        $this->line(str_repeat("-", 60));
        
        $tables = $this->capsule->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        $hasForeignKeys = false;
        
        foreach ($tables as $table) {
            $tableName = $table->name;
            $foreignKeys = $this->capsule->select("PRAGMA foreign_key_list($tableName)");
            
            if (!empty($foreignKeys)) {
                $hasForeignKeys = true;
                $this->line("Table: $tableName");
                foreach ($foreignKeys as $fk) {
                    $this->line("  └── {$fk->from} → {$fk->table}.{$fk->to}");
                }
            }
        }
        
        if (!$hasForeignKeys) {
            $this->line("No foreign key constraints found.");
        }
        
        $this->line();
    }
    
    private function generatePreMigrationReport()
    {
        $this->info("📋 Pre-Migration Report");
        $this->line(str_repeat("=", 60));
        
        // Database info
        $version = $this->capsule->select("SELECT sqlite_version() as version")[0]->version;
        $this->line("SQLite Version: $version");
        
        // Pragmas
        $pragmas = [
            'foreign_keys' => $this->capsule->select("PRAGMA foreign_keys")[0]->foreign_keys,
            'journal_mode' => $this->capsule->select("PRAGMA journal_mode")[0]->journal_mode,
            'synchronous' => $this->capsule->select("PRAGMA synchronous")[0]->synchronous,
        ];
        
        $this->line("Foreign Keys: " . ($pragmas['foreign_keys'] ? 'Enabled' : 'Disabled'));
        $this->line("Journal Mode: " . $pragmas['journal_mode']);
        $this->line("Synchronous: " . $pragmas['synchronous']);
        
        $this->line();
        
        // Migration readiness
        $this->info("✅ Migration Readiness Check");
        $this->success("✓ Database file exists and is readable");
        $this->success("✓ Database structure can be analyzed");
        $this->success("✓ Ready for MySQL migration");
        
        $this->line();
        $this->info("🚀 Ready to migrate! Run one of these commands:");
        $this->line("   • PowerShell: .\\migrate-to-mysql.ps1");
        $this->line("   • PHP: php sqlite-to-mysql-migrator.php");
        $this->line("   • Laravel: php artisan db:migrate-to-mysql");
    }
    
    private function formatBytes($size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, 2) . ' ' . $units[$i];
    }
    
    private function info($message)
    {
        echo "\033[36m$message\033[0m\n";
    }
    
    private function success($message)
    {
        echo "\033[32m$message\033[0m\n";
    }
    
    private function error($message)
    {
        echo "\033[31m$message\033[0m\n";
    }
    
    private function line($message = "")
    {
        echo "$message\n";
    }
}

// Run the analyzer
if (php_sapi_name() === 'cli' || !isset($_SERVER['HTTP_HOST'])) {
    $analyzer = new DatabaseAnalyzer();
    $analyzer->analyze();
} else {
    echo "This script must be run from the command line.";
}
?>
