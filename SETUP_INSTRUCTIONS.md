# Fashion & Lifestyle Blog Setup Instructions

## 1. Database Setup
1. Open your MySQL client (e.g., phpMyAdmin, MySQL Workbench, or CLI).
2. Create a new database:
   ```sql
   CREATE DATABASE fashion_blog;
   ```
3. Select the new database:
   ```sql
   USE fashion_blog;
   ```
4. Import the schema:
   - Run the contents of `database_schema.sql` against your `fashion_blog` database to create all required tables.

## 2. Configuration
1. Open `config/db_config.php`.
2. Update the credentials if needed (defaults to `root` with no password for localhost).
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'fashion_blog');
   ```

## 3. Web Server Environment
- If using **XAMPP/LAMP**, ensure Apache is pointing to the `fashion-blog` folder or the root is mapped properly.
- The `.htaccess` file will route all requests to `public/index.php`. Make sure `mod_rewrite` is enabled in your Apache config.

## 4. Run the App
- Navigate to `http://localhost/fashion/` (or your mapped directory) in your browser.
