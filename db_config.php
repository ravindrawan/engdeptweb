<?php
// Database Configuration
$db_host = 'engdept-db';
$db_user = 'eng_user'; 
$db_name = 'nwp_engineering_portal';


//define('DB_SERVER', 'engdept-db');           // අලුත් ඩේටාබේස් සර්විස් එකේ නම
//define('DB_USERNAME', 'eng_user');           // අපි සෙට් කරපු යූසර්
//define('DB_PASSWORD', 'eng_pass_2026');      // අපි සෙට් කරපු පාස්වර්ඩ් එක
//define('DB_NAME', 'nwp_engineering_portal');  // අලුත් ඩේටාබේස් එකේ නම




// Try multiple password options to make it work in different local/developer environments
$passwords_to_try = ['eng_pass_2026', '', 'eng_user'];
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
