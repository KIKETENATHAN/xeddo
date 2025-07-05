<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExportDatabaseToMySQL extends Command
{
    protected $signature = 'db:export-mysql {--file=mysql_export.sql}';
    protected $description = 'Export SQLite database to MySQL format';

    public function handle()
    {
        $filename = $this->option('file');
        
        $this->info('🔄 Exporting SQLite database to MySQL format...');
        
        try {
            // Get all tables
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            
            $mysql_content = "-- MySQL Export from Laravel SQLite Database\n";
            $mysql_content .= "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
            $mysql_content .= "SET FOREIGN_KEY_CHECKS = 0;\n";
            $mysql_content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
            $mysql_content .= "SET time_zone = \"+00:00\";\n\n";
            
            foreach ($tables as $table) {
                $tableName = $table->name;
                $this->line("📋 Processing table: $tableName");
                
                // Get table structure
                $columns = DB::select("PRAGMA table_info($tableName)");
                
                $mysql_content .= "-- Table structure for table `$tableName`\n";
                $mysql_content .= "DROP TABLE IF EXISTS `$tableName`;\n";
                $mysql_content .= "CREATE TABLE `$tableName` (\n";
                
                $column_defs = [];
                $primary_keys = [];
                
                foreach ($columns as $col) {
                    $name = $col->name;
                    $type = strtoupper($col->type);
                    $not_null = $col->notnull ? 'NOT NULL' : 'NULL';
                    
                    // Convert SQLite types to MySQL types
                    switch ($type) {
                        case 'INTEGER':
                            if ($col->pk) {
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
                        default:
                            if (strpos($type, 'VARCHAR') !== false) {
                                $type = preg_replace('/VARCHAR\((\d+)\)/', 'VARCHAR($1)', $type);
                            } else {
                                $type = 'VARCHAR(255)';
                            }
                            break;
                    }
                    
                    $column_defs[] = "  `$name` $type $not_null";
                    
                    if ($col->pk) {
                        $primary_keys[] = "`$name`";
                    }
                }
                
                $mysql_content .= implode(",\n", $column_defs);
                
                if (!empty($primary_keys)) {
                    $mysql_content .= ",\n  PRIMARY KEY (" . implode(', ', $primary_keys) . ")";
                }
                
                $mysql_content .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";
                
                // Export data
                $data = DB::table($tableName)->get();
                
                if ($data->isNotEmpty()) {
                    $mysql_content .= "-- Data for table `$tableName`\n";
                    
                    foreach ($data as $row) {
                        $row_array = (array) $row;
                        $values = [];
                        
                        foreach ($row_array as $value) {
                            if ($value === null) {
                                $values[] = 'NULL';
                            } elseif (is_numeric($value)) {
                                $values[] = $value;
                            } else {
                                $values[] = "'" . addslashes($value) . "'";
                            }
                        }
                        
                        $columns_list = '`' . implode('`, `', array_keys($row_array)) . '`';
                        $values_list = implode(', ', $values);
                        
                        $mysql_content .= "INSERT INTO `$tableName` ($columns_list) VALUES ($values_list);\n";
                    }
                    $mysql_content .= "\n";
                }
            }
            
            $mysql_content .= "SET FOREIGN_KEY_CHECKS = 1;\n";
            
            // Write to file
            file_put_contents($filename, $mysql_content);
            
            $this->info("✅ Database exported successfully!");
            $this->line("📁 File saved as: $filename");
            $this->line("📊 Tables exported: " . count($tables));
            
        } catch (\Exception $e) {
            $this->error("❌ Export failed: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
