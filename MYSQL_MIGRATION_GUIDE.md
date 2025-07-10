# SQLite to MySQL Migration Guide

This guide provides comprehensive tools and instructions for migrating your Laravel application from SQLite to MySQL database.

## 🚀 Quick Start

### Option 1: PowerShell Script (Recommended for Windows)
```powershell
.\migrate-to-mysql.ps1
```

### Option 2: PHP Script
```bash
php sqlite-to-mysql-migrator.php
```

### Option 3: Laravel Artisan Command
```bash
php artisan db:migrate-to-mysql
```

## 📋 Prerequisites

- PHP 7.4 or higher
- Laravel application with SQLite database
- Access to MySQL hosting (cPanel, shared hosting, VPS, etc.)
- SQLite database file at `database/database.sqlite`

## 🛠️ Available Migration Tools

### 1. Enhanced PowerShell Script (`migrate-to-mysql.ps1`)
**Best for: Windows users who want a guided experience**

Features:
- ✅ Comprehensive requirement checking
- ✅ Step-by-step instructions
- ✅ Automatic phpMyAdmin opening
- ✅ Detailed troubleshooting tips
- ✅ Progress indicators and colored output

Usage:
```powershell
# Basic migration
.\migrate-to-mysql.ps1

# With custom output directory
.\migrate-to-mysql.ps1 -OutputDir "my_exports"

# Verbose output
.\migrate-to-mysql.ps1 -Verbose

# Show help
.\migrate-to-mysql.ps1 -ShowHelp
```

### 2. Enhanced PHP Script (`sqlite-to-mysql-migrator.php`)
**Best for: Cross-platform usage and automated deployments**

Features:
- ✅ Comprehensive database analysis
- ✅ Foreign key constraint handling
- ✅ Batch data processing for large databases
- ✅ Multiple output files (SQL, queries, templates)
- ✅ Detailed migration statistics

Usage:
```bash
php sqlite-to-mysql-migrator.php
```

### 3. Laravel Artisan Command (`DatabaseMigrationCommand`)
**Best for: Laravel developers who prefer Artisan commands**

Features:
- ✅ Native Laravel integration
- ✅ Progress bars and detailed output
- ✅ Multiple export options
- ✅ Compression support
- ✅ Verification query generation

Usage:
```bash
# Basic export
php artisan db:migrate-to-mysql

# Custom output directory
php artisan db:migrate-to-mysql --output=my_exports

# Structure only
php artisan db:migrate-to-mysql --structure-only

# Data only
php artisan db:migrate-to-mysql --data-only

# Compressed export
php artisan db:migrate-to-mysql --compress
```

## 📁 Generated Files

After running any migration tool, you'll find these files in the `exports/` directory:

### Primary Export Files
- `mysql_complete_export.sql` - Main SQL export file for importing
- `mysql_export.sql` - Alternative export file (Artisan command)

### Helper Files
- `migration_queries.sql` - Verification and helper queries
- `verification_queries.sql` - Database verification queries
- `.env.mysql.template` - Environment configuration template
- `migration_checklist.md` - Step-by-step migration checklist

## 🔧 Migration Process

### Step 1: Generate Export Files
Run one of the migration tools listed above.

### Step 2: Prepare MySQL Database
1. **Create Database:**
   - Log into cPanel or hosting control panel
   - Navigate to "MySQL Databases"
   - Create a new database (e.g., `yoursite_main`)

2. **Create Database User:**
   - Create a new MySQL user
   - Set a strong password
   - Assign user to database with ALL PRIVILEGES

### Step 3: Import SQL File
1. **Upload SQL File:**
   - Use cPanel File Manager or FTP
   - Upload `mysql_complete_export.sql` to your hosting

2. **Import via phpMyAdmin:**
   - Open phpMyAdmin in cPanel
   - Select your database
   - Click "Import" tab
   - Choose your SQL file
   - Click "Go" to import

### Step 4: Update Application Configuration
1. **Update .env file:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

2. **For cPanel hosting:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_DATABASE=cpanel_user_dbname
   DB_USERNAME=cpanel_user_dbuser
   DB_PASSWORD=your_mysql_password
   ```

### Step 5: Test Migration
1. **Clear application cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   ```

2. **Test database connection:**
   ```bash
   php artisan tinker
   >>> DB::connection()->getPdo();
   ```

3. **Verify data integrity:**
   - Run queries from `verification_queries.sql`
   - Compare record counts between SQLite and MySQL
   - Test key application functionality

## 🔍 Verification Queries

Use these queries to verify your migration:

```sql
-- Check all tables
SHOW TABLES;

-- Verify record counts (replace with your table names)
SELECT 'users' as table_name, COUNT(*) as count FROM users
UNION ALL
SELECT 'posts' as table_name, COUNT(*) as count FROM posts;

-- Check table structures
DESCRIBE users;
DESCRIBE posts;

-- Test foreign key constraints
SELECT 
    TABLE_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE REFERENCED_TABLE_SCHEMA = 'your_database_name';
```

## 🚨 Troubleshooting

### Common Issues and Solutions

#### Import Fails in phpMyAdmin
**Problem:** File too large or timeout errors
**Solutions:**
- Split the SQL file into smaller chunks
- Use MySQL command line if available
- Increase PHP limits in hosting
- Contact hosting support for assistance

#### Connection Errors After Migration
**Problem:** Application can't connect to MySQL
**Solutions:**
- Verify .env credentials are correct
- Check database user permissions
- Ensure database name matches exactly
- Test connection outside Laravel

#### Missing Data After Migration
**Problem:** Some records missing in MySQL
**Solutions:**
- Compare record counts using verification queries
- Check for special characters that might cause issues
- Review foreign key constraints
- Re-run migration with verbose output

#### Performance Issues
**Problem:** Slow queries after migration
**Solutions:**
- Add appropriate database indexes
- Optimize queries for MySQL syntax differences
- Monitor slow query log
- Consider database connection pooling

### Data Type Conversion Issues

The migration automatically converts SQLite types to MySQL equivalents:

| SQLite Type | MySQL Type | Notes |
|-------------|------------|-------|
| INTEGER (PK) | BIGINT UNSIGNED AUTO_INCREMENT | Primary keys |
| INTEGER | INT | Regular integers |
| REAL/NUMERIC | DECIMAL(10,2) | Decimal numbers |
| TEXT | TEXT | Text data |
| BLOB | LONGBLOB | Binary data |
| BOOLEAN | TINYINT(1) | Boolean values |
| VARCHAR(n) | VARCHAR(n) | Variable length strings |

## 📞 Support

If you encounter issues:

1. **Check the troubleshooting section above**
2. **Review generated verification queries**
3. **Test with a small subset of data first**
4. **Contact your hosting provider for server-specific issues**
5. **Consider hiring a database administrator for complex migrations**

## 🔒 Security Notes

- **Always backup your SQLite database before migration**
- **Test thoroughly in a staging environment first**
- **Use strong passwords for MySQL users**
- **Limit database user permissions to what's needed**
- **Keep your export files secure and delete them after use**

## 📈 Performance Tips

- **Add indexes after import for better performance**
- **Use prepared statements in your application**
- **Consider database connection pooling for high traffic**
- **Monitor database performance after migration**
- **Optimize queries that were designed for SQLite**

---

*This migration tool was designed to make SQLite to MySQL migration as smooth as possible. Follow the instructions carefully and test thoroughly before deploying to production.*
