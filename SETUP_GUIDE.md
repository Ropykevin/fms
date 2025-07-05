# UYOMA FARM MANAGEMENT SYSTEM - SETUP GUIDE

## Prerequisites
- XAMPP (Apache + MySQL + PHP) installed and running
- Web browser (Chrome, Firefox, Safari, etc.)

## Step 1: Start XAMPP Services
1. Open XAMPP Control Panel
2. Start Apache and MySQL services
3. Make sure both services show green status

## Step 2: Import Database
1. Open your web browser
2. Go to: `http://localhost/phpmyadmin`
3. Click on "New" to create a new database
4. Enter database name: `fms`
5. Click "Create"
6. Select the `fms` database
7. Click on "Import" tab
8. Choose the `fms.sql` file from your project directory
9. Click "Go" to import the database

## Step 3: Test the Application
1. Open your web browser
2. Navigate to: `http://localhost/Farm-Management-System/`
3. You should see the login page

## Step 4: Test Database Connection
1. Navigate to: `http://localhost/Farm-Management-System/test_connection.php`
2. This will show you if PHP and database connection are working

## Default Login Credentials

### Admin Login:
- Username: `admin`
- Password: `admin123`

### Employee Login:
- Username: `employee1`
- Password: `emp123`

## Troubleshooting

### If you get "Not Found" error:
1. Make sure XAMPP is running
2. Check that your project is in the correct directory: `C:\xampp\htdocs\Farm-Management-System\`
3. Verify Apache is running on port 80
4. Try accessing: `http://localhost/Farm-Management-System/test_connection.php`

### If database connection fails:
1. Make sure MySQL is running in XAMPP
2. Verify the database `fms` exists
3. Check that the database was imported correctly
4. Verify the database credentials in `include/config.php`

### If PHP errors occur:
1. Check XAMPP error logs
2. Make sure PHP is enabled in Apache
3. Verify file permissions

## File Structure
```
Farm-Management-System/
├── index.php (main login page)
├── admin-panel.php (admin dashboard)
├── emp-panel.php (employee dashboard)
├── includes/db_connection.php (database connection)
├── include/config.php (database configuration)
├── fms.sql (database structure)
└── test_connection.php (connection test)
```

## Support
If you continue to have issues, check the error logs in the `logs/` directory or contact support. 