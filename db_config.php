<?php
// Database Configuration
ini_set('display_errors', 0); 
error_reporting(E_ALL);

// OpenShift එකේ තියෙන සැබෑ Credentials ටික මුලින්ම ගමු
define('DB_SERVER', 'engdept-db');
define('DB_USERNAME', 'eng_user');
define('DB_PASSWORD', 'eng_pass_2026');
define('DB_NAME', 'nwp_engineering_portal');

$db_connection_error = null;
$conn = null;

// PHP 8+ වලදී කනෙක්ෂන් Error හරියටම අල්ලන්න Exception Enable කරමු
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

try {
    // 1. ප්‍රධාන OpenShift MySQL සර්වර් එකට කනෙක්ට් වෙන්න උත්සාහ කරමු
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
} catch (Exception $e) {
    try {
        // 2. ඒක Fail වුණොත් විතරක් Local XAMPP එකට ට්‍රයි කරමු
        $conn = new mysqli('localhost', 'root', '', DB_NAME);
    } catch (Exception $local_e) {
        // 3. දෙකම Fail නම්, සැබෑ Error එක variable එකට දාමු
        $db_connection_error = $local_e->getMessage();
    }
}

// කනෙක්ෂන් එක සාර්ථක නම් පමණක් Charset එක හදන්න
if ($db_connection_error === null && $conn) {
    $conn->set_charset("utf8mb4");
} else if ($conn === null && $db_connection_error === null) {
    $db_connection_error = "Unknown database connection failure.";
}

// Prevent browser and proxy caching
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
?>
