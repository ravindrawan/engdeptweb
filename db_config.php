<?php
// Database Configuration
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('DB_SERVER', 'engdept-db');
define('DB_USERNAME', 'eng_user');
define('DB_PASSWORD', 'eng_pass_2026');
define('DB_NAME', 'nwp_engineering_portal');

// පැරණි කෝඩ් සමඟ ගැළපීම සඳහා variables ද සකසමු
$db_host = DB_SERVER;
$db_user = DB_USERNAME;
$db_name = DB_NAME;
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// ඩේටාබේස් කනෙක්ෂන් එක සෑදීම
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// කනෙක්ෂන් එකේ අවුලක් ආවොත් ලෝකල් එන්වයිරන්මන්ට් එක සඳහා fallback එකක්
if ($conn->connect_error) {
    // ලෝකල් එකේදී පාස්වර්ඩ් එක හිස්ව තිබුනොත් ට්‍රයි කිරීමට
    $conn = @new mysqli(DB_SERVER, DB_USERNAME, '', DB_NAME);
    
    if ($conn->connect_error) {
        // කිසිවක් කරකියාගත නොහැකි නම් error එක පෙන්වන්න
        die("Database Connection Failed: " . $conn->connect_error);
    }
}

// UTF-8 සෙටින්ග්ස්
$conn->set_charset("utf8mb4");

// Prevent browser and proxy caching
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
?>
