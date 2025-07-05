<?php
// Test PHP functionality
echo "<h2>PHP Test</h2>";
echo "<p>PHP is working! Current time: " . date('Y-m-d H:i:s') . "</p>";

// Test database connection
echo "<h2>Database Connection Test</h2>";
include_once 'includes/db_connection.php';

$connection = getConnection();
if ($connection) {
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Test query
    $result = mysqli_query($connection, "SELECT COUNT(*) as count FROM admintb");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "<p>✓ Database query successful! Admin count: " . $row['count'] . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Database query failed: " . mysqli_error($connection) . "</p>";
    }
} else {
    echo "<p style='color: red;'>✗ Database connection failed!</p>";
}

// Test file permissions
echo "<h2>File System Test</h2>";
if (is_readable('index.php')) {
    echo "<p style='color: green;'>✓ index.php is readable</p>";
} else {
    echo "<p style='color: red;'>✗ index.php is not readable</p>";
}

if (is_writable('.')) {
    echo "<p style='color: green;'>✓ Current directory is writable</p>";
} else {
    echo "<p style='color: red;'>✗ Current directory is not writable</p>";
}

// Show PHP info
echo "<h2>PHP Information</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";
?> 