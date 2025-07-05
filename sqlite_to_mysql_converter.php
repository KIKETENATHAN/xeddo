<?php
/**
 * SQLite to MySQL Converter for Laravel
 * Run this script locally to convert your SQLite database to MySQL format
 */

$sqlite_file = 'database/database.sqlite';
$mysql_file = 'mysql_export.sql';

if (!file_exists($sqlite_file)) {
    die("SQLite database file not found: $sqlite_file\n");
}

try {
    $pdo = new PDO('sqlite:' . $sqlite_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔄 Converting SQLite to MySQL...\n";
    
    // Get all tables
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'")->fetchAll(PDO::FETCH_COLUMN);
    
    $mysql_content = "-- MySQL Export from SQLite Database\n";
    $mysql_content .= "-- Generated on " . date('Y-m-d H:i:s') . "\n";
    $mysql_content .= "-- Source: $sqlite_file\n\n";
    $mysql_content .= "SET FOREIGN_KEY_CHECKS = 0;\n";
    $mysql_content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
    $mysql_content .= "SET time_zone = \"+00:00\";\n\n";
    
    foreach ($tables as $table) {
        echo "📋 Processing table: $table\n";
        
        // Get table structure
        $columns = $pdo->query("PRAGMA table_info($table)")->fetchAll(PDO::FETCH_ASSOC);
        
        $mysql_content .= "-- --------------------------------------------------------\n";
        $mysql_content .= "-- Table structure for table `$table`\n";
        $mysql_content .= "-- --------------------------------------------------------\n\n";
        
        $mysql_content .= "DROP TABLE IF EXISTS `$table`;\n";
        $mysql_content .= "CREATE TABLE `$table` (\n";
        
        $column_defs = [];
        $primary_keys = [];
        
        foreach ($columns as $col) {
            $name = $col['name'];
            $type = strtoupper($col['type']);
            $not_null = $col['notnull'] ? 'NOT NULL' : 'NULL';
            $default = '';
            
            // Convert SQLite types to MySQL types
            switch ($type) {
                case 'INTEGER':
                    if ($col['pk']) {
                        $type = 'BIGINT UNSIGNED';
                        $not_null = 'NOT NULL AUTO_INCREMENT';
                    } else {
                        $type = 'INT';
                    }
                    break;
                case 'REAL':
                case 'NUMERIC':
                    $type = 'DECIMAL(10,2)';
                    break;
                case 'TEXT':
                    $type = 'TEXT';
                    break;
                case 'BLOB':
                    $type = 'LONGBLOB';
                    break;
                case 'BOOLEAN':
                    $type = 'TINYINT(1)';
                    break;
                default:
                    if (strpos($type, 'VARCHAR') !== false) {
                        $type = preg_replace('/VARCHAR\((\d+)\)/', 'VARCHAR($1)', $type);
                    } else {
                        $type = 'VARCHAR(255)';
                    }
                    break;
            }
            
            // Handle default values
            if ($col['dflt_value'] !== null) {
                if ($col['dflt_value'] === 'CURRENT_TIMESTAMP') {
                    $default = 'DEFAULT CURRENT_TIMESTAMP';
                } elseif (is_numeric($col['dflt_value'])) {
                    $default = 'DEFAULT ' . $col['dflt_value'];
                } else {
                    $default = "DEFAULT '" . addslashes($col['dflt_value']) . "'";
                }
            }
            
            $column_defs[] = "  `$name` $type $not_null $default";
            
            if ($col['pk']) {
                $primary_keys[] = "`$name`";
            }
        }
        
        $mysql_content .= implode(",\n", $column_defs);
        
        // Add primary key constraint
        if (!empty($primary_keys)) {
            $mysql_content .= ",\n  PRIMARY KEY (" . implode(', ', $primary_keys) . ")";
        }
        
        $mysql_content .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";
        
        // Get and insert data
        $data = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($data)) {
            $mysql_content .= "-- --------------------------------------------------------\n";
            $mysql_content .= "-- Dumping data for table `$table`\n";
            $mysql_content .= "-- --------------------------------------------------------\n\n";
            
            foreach ($data as $row) {
                $values = [];
                foreach ($row as $key => $value) {
                    if ($value === null) {
                        $values[] = 'NULL';
                    } elseif (is_numeric($value)) {
                        $values[] = $value;
                    } else {
                        $values[] = "'" . addslashes($value) . "'";
                    }
                }
                
                $columns_list = '`' . implode('`, `', array_keys($row)) . '`';
                $values_list = implode(', ', $values);
                
                $mysql_content .= "INSERT INTO `$table` ($columns_list) VALUES ($values_list);\n";
            }
            $mysql_content .= "\n";
        }
    }
    
    $mysql_content .= "SET FOREIGN_KEY_CHECKS = 1;\n";
    
    // Write to file
    file_put_contents($mysql_file, $mysql_content);
    
    echo "✅ Conversion completed successfully!\n";
    echo "📁 MySQL export saved to: $mysql_file\n";
    echo "📊 Tables exported: " . count($tables) . "\n";
    echo "\n🚀 Next steps:\n";
    echo "1. Upload '$mysql_file' to your cPanel hosting\n";
    echo "2. Import via phpMyAdmin in cPanel\n";
    echo "3. Update your .env file with MySQL credentials\n";
    
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
