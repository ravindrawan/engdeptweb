<?php
// Database Configuration
$db_host = 'localhost';
$db_user = 'root'; 
$db_name = 'nwp_engineering_portal';

// Try multiple password options to make it work in different local/developer environments
$passwords_to_try = ['Ravi@2025', '', 'root'];
$conn = null;
$db_connection_error = null;

foreach ($passwords_to_try as $test_pass) {
    $conn = @new mysqli($db_host, $db_user, $test_pass, $db_name);
    if (!$conn->connect_error) {
        $db_pass = $test_pass;
        $db_connection_error = null;
        break;
    } else {
        $db_connection_error = $conn->connect_error;
    }
}

if ($conn && !$conn->connect_error) {
    $conn->set_charset("utf8mb4");
}

// Prevent browser and proxy caching for all API endpoints
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
?>
