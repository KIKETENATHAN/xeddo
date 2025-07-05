# SQLite to MySQL Export Guide for cPanel Deployment

## Method 1: Using Laravel Artisan Commands (Recommended)

### Step 1: Create Database Export Command

First, let's create a custom Laravel command to export your SQLite data:

```bash
php artisan make:command ExportSQLiteToMySQL
```

### Step 2: Export Current Data

Run this command to export your SQLite data to SQL format:

```bash
# Export data to SQL file
php artisan db:export --format=sql --file=database_export.sql
```

### Step 3: Manual Export Using SQLite3 Command

If the above doesn't work, use SQLite3 directly:

```bash
# Export schema and data to SQL file
sqlite3 database/database.sqlite .dump > database_export.sql
```

## Method 2: Using phpMyAdmin Import (Easiest for cPanel)

### Step 1: Convert SQLite to MySQL Format

Create a PHP script to convert SQLite to MySQL compatible format:

```php
<?php
// Run this script locally to convert SQLite to MySQL
$sqlite_db = 'database/database.sqlite';
$mysql_file = 'mysql_export.sql';

$pdo = new PDO('sqlite:' . $sqlite_db);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get all tables
$tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);

$mysql_content = "-- MySQL Export from SQLite\n";
$mysql_content .= "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";

foreach ($tables as $table) {
    if ($table == 'sqlite_sequence') continue;
    
    // Get table structure
    $columns = $pdo->query("PRAGMA table_info($table)")->fetchAll(PDO::FETCH_ASSOC);
    
    $mysql_content .= "-- Table: $table\n";
    $mysql_content .= "CREATE TABLE IF NOT EXISTS `$table` (\n";
    
    $column_defs = [];
    foreach ($columns as $col) {
        $type = strtoupper($col['type']);
        $type = str_replace('INTEGER', 'INT', $type);
        $type = str_replace('REAL', 'DECIMAL(10,2)', $type);
        
        $null = $col['notnull'] ? 'NOT NULL' : 'NULL';
        $default = $col['dflt_value'] ? "DEFAULT " . $col['dflt_value'] : '';
        
        if ($col['pk']) {
            $column_defs[] = "  `{$col['name']}` $type NOT NULL AUTO_INCREMENT";
        } else {
            $column_defs[] = "  `{$col['name']}` $type $null $default";
        }
    }
    
    $mysql_content .= implode(",\n", $column_defs);
    
    // Add primary key
    $pk_columns = array_filter($columns, function($col) { return $col['pk']; });
    if (!empty($pk_columns)) {
        $pk_names = array_map(function($col) { return "`{$col['name']}`"; }, $pk_columns);
        $mysql_content .= ",\n  PRIMARY KEY (" . implode(', ', $pk_names) . ")";
    }
    
    $mysql_content .= "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";
    
    // Get data
    $data = $pdo->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($data)) {
        $mysql_content .= "-- Data for table: $table\n";
        
        foreach ($data as $row) {
            $values = array_map(function($val) {
                return $val === null ? 'NULL' : "'" . addslashes($val) . "'";
            }, $row);
            
            $columns_list = '`' . implode('`, `', array_keys($row)) . '`';
            $values_list = implode(', ', $values);
            
            $mysql_content .= "INSERT INTO `$table` ($columns_list) VALUES ($values_list);\n";
        }
        $mysql_content .= "\n";
    }
}

file_put_contents($mysql_file, $mysql_content);
echo "Export completed: $mysql_file\n";
?>
```

## Method 3: Using Online Converter Tools

### Step 1: Download SQLite File
Download your `database.sqlite` file from your local project.

### Step 2: Use Online Converter
- Visit: https://sqliteonline.com/
- Upload your SQLite file
- Export as MySQL format
- Download the SQL file

## Method 4: Direct Laravel Migration (Best Practice)

Instead of migrating data, use Laravel's migration system:

### Step 1: Set up MySQL in cPanel
1. Create MySQL database in cPanel
2. Note credentials (host, database, user, password)

### Step 2: Update .env for MySQL
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourdomain_xeddolink
DB_USERNAME=yourdomain_dbuser
DB_PASSWORD=your_password
```

### Step 3: Run Fresh Migration
```bash
# This will create fresh tables and seed data
php artisan migrate:fresh --seed
```

## Implementation Steps for cPanel

### Option A: Import SQL File via phpMyAdmin

1. **Create the export file locally:**
   ```bash
   sqlite3 database/database.sqlite .dump > sqlite_export.sql
   ```

2. **Clean up the SQL file** (remove SQLite specific commands):
   - Remove `PRAGMA` statements
   - Replace `INTEGER PRIMARY KEY` with `INT AUTO_INCREMENT PRIMARY KEY`
   - Replace `REAL` with `DECIMAL` or `FLOAT`
   - Add `ENGINE=InnoDB` to CREATE TABLE statements

3. **Upload via phpMyAdmin:**
   - Login to cPanel → phpMyAdmin
   - Select your database
   - Go to Import tab
   - Upload the cleaned SQL file

### Option B: Use Laravel Seeders (Recommended)

1. **Export data to seeders:**
   ```bash
   php artisan make:seeder ProductionDataSeeder
   ```

2. **Create seeder with your current data**

3. **Run on production:**
   ```bash
   php artisan db:seed --class=ProductionDataSeeder
   ```

## Complete Export Script

Here's a complete PHP script you can run locally:
