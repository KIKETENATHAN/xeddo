<?php
/**
 * Enhanced SQLite to MySQL Database Migrator
 * This script provides comprehensive database migration with multiple export options
 * and enhanced error handling for Laravel applications.
 */

class SQLiteToMySQLMigrator
{
    private $sqliteFile;
    private $outputDir;
    private $pdo;
    private $tables = [];
    private $foreignKeys = [];
    
    public function __construct($sqliteFile = 'database/database.sqlite', $outputDir = 'exports')
    {
        $this->sqliteFile = $sqliteFile;
        $this->outputDir = $outputDir;
        
        // Create output directory if it doesn't exist
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0755, true);
        }
    }
    
    public function migrate()
    {
        try {
            $this->connect();
            $this->analyzeTables();
            $this->generateMySQLExport();
            $this->generateMigrationQueries();
            $this->generateEnvTemplate();
            $this->showInstructions();
            
        } catch (Exception $e) {
            $this->error("Migration failed: " . $e->getMessage());
            return false;
        }
        
        return true;
    }
    
    private function connect()
    {
        if (!file_exists($this->sqliteFile)) {
            throw new Exception("SQLite database file not found: {$this->sqliteFile}");
        }
        
        $this->info("🔗 Connecting to SQLite database...");
        $this->pdo = new PDO('sqlite:' . $this->sqliteFile);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->success("✅ Connected successfully");
    }
    
    private function analyzeTables()
    {
        $this->info("🔍 Analyzing database structure...");
        
        // Get all tables
        $stmt = $this->pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        $this->tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $this->info("📊 Found " . count($this->tables) . " tables: " . implode(', ', $this->tables));
        
        // Analyze foreign keys
        foreach ($this->tables as $table) {
            $fks = $this->pdo->query("PRAGMA foreign_key_list($table)")->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($fks)) {
                $this->foreignKeys[$table] = $fks;
            }
        }
    }
    
    private function generateMySQLExport()
    {
        $this->info("🔄 Generating MySQL export...");
        
        $filename = $this->outputDir . '/mysql_complete_export.sql';
        $content = $this->generateHeader();
        
        // First pass: Create tables without foreign keys
        foreach ($this->tables as $table) {
            $content .= $this->generateTableStructure($table, false);
        }
        
        // Second pass: Add data
        foreach ($this->tables as $table) {
            $content .= $this->generateTableData($table);
        }
        
        // Third pass: Add foreign key constraints
        foreach ($this->tables as $table) {
            if (isset($this->foreignKeys[$table])) {
                $content .= $this->generateForeignKeyConstraints($table);
            }
        }
        
        $content .= $this->generateFooter();
        
        file_put_contents($filename, $content);
        $this->success("✅ MySQL export saved to: $filename");
        
        return $filename;
    }
    
    private function generateHeader()
    {
        return "-- MySQL Export from SQLite Database
-- Generated on " . date('Y-m-d H:i:s') . "
-- Source: {$this->sqliteFile}
-- Laravel Application Database Migration

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = \"+00:00\";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `your_database_name`

";
    }
    
    private function generateTableStructure($table, $includeForeignKeys = true)
    {
        $columns = $this->pdo->query("PRAGMA table_info($table)")->fetchAll(PDO::FETCH_ASSOC);
        $indexes = $this->pdo->query("PRAGMA index_list($table)")->fetchAll(PDO::FETCH_ASSOC);
        
        $content = "-- --------------------------------------------------------
-- Table structure for table `$table`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `$table`;
CREATE TABLE `$table` (
";
        
        $columnDefs = [];
        $primaryKeys = [];
        
        foreach ($columns as $col) {
            $name = $col['name'];
            $type = $this->convertType($col['type'], $col['pk']);
            $notNull = $col['notnull'] ? 'NOT NULL' : 'NULL';
            $default = $this->convertDefault($col['dflt_value'], $col['type']);
            $autoIncrement = ($col['pk'] && strtoupper($col['type']) === 'INTEGER') ? 'AUTO_INCREMENT' : '';
            
            $columnDef = "  `$name` $type $notNull $default $autoIncrement";
            $columnDefs[] = trim($columnDef);
            
            if ($col['pk']) {
                $primaryKeys[] = "`$name`";
            }
        }
        
        $content .= implode(",\n", $columnDefs);
        
        // Add primary key
        if (!empty($primaryKeys)) {
            $content .= ",\n  PRIMARY KEY (" . implode(', ', $primaryKeys) . ")";
        }
        
        // Add indexes (except primary key)
        foreach ($indexes as $index) {
            if (!$index['unique'] || $index['name'] === 'sqlite_autoindex_' . $table . '_1') {
                continue;
            }
            
            $indexInfo = $this->pdo->query("PRAGMA index_info({$index['name']})")->fetchAll(PDO::FETCH_ASSOC);
            $indexColumns = array_map(function($col) { return "`{$col['name']}`"; }, $indexInfo);
            
            if ($index['unique']) {
                $content .= ",\n  UNIQUE KEY `{$index['name']}` (" . implode(', ', $indexColumns) . ")";
            } else {
                $content .= ",\n  KEY `{$index['name']}` (" . implode(', ', $indexColumns) . ")";
            }
        }
        
        $content .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";
        
        return $content;
    }
    
    private function generateTableData($table)
    {
        $data = $this->pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($data)) {
            return "-- No data for table `$table`\n\n";
        }
        
        $content = "-- --------------------------------------------------------
-- Dumping data for table `$table`
-- --------------------------------------------------------

";
        
        $columns = array_keys($data[0]);
        $columnsList = '`' . implode('`, `', $columns) . '`';
        
        // Process data in batches for better performance
        $batchSize = 100;
        $batches = array_chunk($data, $batchSize);
        
        foreach ($batches as $batch) {
            $values = [];
            foreach ($batch as $row) {
                $rowValues = [];
                foreach ($row as $value) {
                    $rowValues[] = $this->escapeValue($value);
                }
                $values[] = '(' . implode(', ', $rowValues) . ')';
            }
            
            $content .= "INSERT INTO `$table` ($columnsList) VALUES\n";
            $content .= implode(",\n", $values) . ";\n\n";
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
            $constraintName = "fk_{$table}_{$fk['from']}_{$fk['table']}_{$fk['to']}";
            $content .= "ALTER TABLE `$table` ADD CONSTRAINT `$constraintName` ";
            $content .= "FOREIGN KEY (`{$fk['from']}`) REFERENCES `{$fk['table']}` (`{$fk['to']}`)";
            
            if ($fk['on_delete'] !== 'NO ACTION') {
                $content .= " ON DELETE {$fk['on_delete']}";
            }
            if ($fk['on_update'] !== 'NO ACTION') {
                $content .= " ON UPDATE {$fk['on_update']}";
            }
            
            $content .= ";\n";
        }
        
        return $content . "\n";
    }
    
    private function generateFooter()
    {
        return "
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Migration completed successfully
-- Don't forget to update your .env file with MySQL credentials
";
    }
    
    private function generateMigrationQueries()
    {
        $filename = $this->outputDir . '/migration_queries.sql';
        $content = "-- Laravel Migration Helper Queries\n";
        $content .= "-- Use these queries if you need to make adjustments\n\n";
        
        // Generate queries to check table status
        $content .= "-- Check all tables\n";
        $content .= "SHOW TABLES;\n\n";
        
        foreach ($this->tables as $table) {
            $content .= "-- Check table structure: $table\n";
            $content .= "DESCRIBE `$table`;\n\n";
            
            $content .= "-- Check row count: $table\n";
            $content .= "SELECT COUNT(*) as total_rows FROM `$table`;\n\n";
        }
        
        file_put_contents($filename, $content);
        $this->success("✅ Migration queries saved to: $filename");
    }
    
    private function generateEnvTemplate()
    {
        $filename = $this->outputDir . '/.env.mysql.template';
        $content = "# MySQL Database Configuration
# Copy these settings to your .env file and update with your MySQL credentials

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Optional MySQL settings
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
DB_STRICT=true
DB_ENGINE=InnoDB

# For cPanel hosting, typically use:
# DB_HOST=localhost
# DB_DATABASE=cpanel_username_database_name
# DB_USERNAME=cpanel_username_database_user
# DB_PASSWORD=your_mysql_password
";
        
        file_put_contents($filename, $content);
        $this->success("✅ Environment template saved to: $filename");
    }
    
    private function convertType($sqliteType, $isPrimaryKey = false)
    {
        $type = strtoupper(trim($sqliteType));
        
        switch ($type) {
            case 'INTEGER':
                return $isPrimaryKey ? 'BIGINT UNSIGNED' : 'INT';
            case 'REAL':
            case 'DOUBLE':
            case 'FLOAT':
                return 'DOUBLE';
            case 'NUMERIC':
            case 'DECIMAL':
                return 'DECIMAL(10,2)';
            case 'TEXT':
            case 'CLOB':
                return 'TEXT';
            case 'BLOB':
                return 'LONGBLOB';
            case 'BOOLEAN':
                return 'TINYINT(1)';
            case 'DATE':
                return 'DATE';
            case 'DATETIME':
            case 'TIMESTAMP':
                return 'TIMESTAMP';
            default:
                // Handle VARCHAR with length
                if (preg_match('/VARCHAR\((\d+)\)/i', $type, $matches)) {
                    return "VARCHAR({$matches[1]})";
                }
                // Default fallback
                return 'VARCHAR(255)';
        }
    }
    
    private function convertDefault($defaultValue, $type)
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
    
    private function showInstructions()
    {
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "🚀 MIGRATION COMPLETED SUCCESSFULLY!\n";
        echo str_repeat("=", 60) . "\n\n";
        
        echo "📁 Generated files in '{$this->outputDir}' directory:\n";
        echo "   ├── mysql_complete_export.sql    (Main export file)\n";
        echo "   ├── migration_queries.sql        (Helper queries)\n";
        echo "   └── .env.mysql.template          (Environment template)\n\n";
        
        echo "🔧 NEXT STEPS:\n";
        echo "1. 📤 Upload 'mysql_complete_export.sql' to your hosting\n";
        echo "2. 🗄️  Create a MySQL database in your hosting control panel\n";
        echo "3. 📥 Import the SQL file using phpMyAdmin or similar tool\n";
        echo "4. ⚙️  Update your .env file with MySQL credentials\n";
        echo "5. 🧪 Test your application with the new MySQL database\n\n";
        
        echo "📊 MIGRATION STATISTICS:\n";
        echo "   • Tables migrated: " . count($this->tables) . "\n";
        echo "   • Foreign keys: " . count($this->foreignKeys) . "\n";
        echo "   • Export file size: " . $this->formatFileSize($this->outputDir . '/mysql_complete_export.sql') . "\n\n";
        
        echo "⚠️  IMPORTANT NOTES:\n";
        echo "   • Backup your SQLite database before switching\n";
        echo "   • Test thoroughly in a staging environment first\n";
        echo "   • Update DB_CONNECTION=mysql in your .env file\n";
        echo "   • Run 'php artisan migrate:status' after switching\n\n";
    }
    
    private function formatFileSize($filename)
    {
        if (!file_exists($filename)) {
            return 'Unknown';
        }
        
        $size = filesize($filename);
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
}

// Usage
if (php_sapi_name() === 'cli' || !isset($_SERVER['HTTP_HOST'])) {
    echo "🔄 Starting SQLite to MySQL Migration...\n\n";
    
    $migrator = new SQLiteToMySQLMigrator();
    
    if ($migrator->migrate()) {
        echo "✅ Migration process completed successfully!\n";
        exit(0);
    } else {
        echo "❌ Migration process failed!\n";
        exit(1);
    }
} else {
    echo "This script must be run from the command line.";
}
?>
