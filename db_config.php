<?php
// Database Configuration
ini_set('display_errors', 0); // JSON කැඩෙන නිසා error එළියට පෙන්වීම නවත්වන්න
error_reporting(E_ALL);

define('DB_SERVER', 'engdept-db');
define('DB_USERNAME', 'eng_user');
define('DB_PASSWORD', 'eng_pass_2026');
define('DB_NAME', 'nwp_engineering_portal');

$db_host = DB_SERVER;
$db_user = DB_USERNAME;
$db_name = DB_NAME;

// auth.php එකේ බලාපොරොත්තු වන variable එක මුලින්ම null කරමු
$db_connection_error = null;

mysqli_report(MYSQLI_REPORT_OFF); // Try-catch නැතිව connect_error එක අල්ලන්න

// ඩේටාබේස් කනෙක්ෂන් එක සෑදීම
$conn = @new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// OpenShift Database එකට කනෙක්ෂන් එක Fail වුණොත් (උදා: local XAMPP එකේදී ටෙස්ට් කරද්දී)
if ($conn->connect_error) {
    // 1. Local XAMPP එකේ default settings වලින් කනෙක්ට් වෙන්න ට්‍රයි එකක් දෙමු
    $conn = @new mysqli('localhost', 'root', '', DB_NAME);
    
    if ($conn->connect_error) {
        // 2. ඒකත් Fail නම්, die කරන්නේ නැතිව error එක variable එකකට දාමු
        $db_connection_error = $conn->connect_error;
    }
}

// කනෙක්ෂන් එක සාර්ථක නම් පමණක් Charset එක හදන්න
if ($db_connection_error === null && $conn) {
    $conn->set_charset("utf8mb4");
}

// Prevent browser and proxy caching
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
?>
