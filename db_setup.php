<?php
header('Content-Type: application/json');
require_once 'db_config.php';

if (isset($db_connection_error) && $db_connection_error !== null) {
    echo json_encode(["error" => "Connection Error: " . $db_connection_error]);
    exit;
}

$tables = [];
$result = $conn->query("SHOW TABLES");
if ($result) {
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
}

$officers_columns = [];
$officers_count = 0;
$officers_sample = [];
$query_error = null;

if (in_array('officers', $tables)) {
    $result = $conn->query("SHOW COLUMNS FROM officers");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $officers_columns[] = $row;
        }
    }
    
    $result = $conn->query("SELECT COUNT(*) as count FROM officers");
    if ($result) {
        $row = $result->fetch_assoc();
        $officers_count = intval($row['count']);
    }
    
    $result = $conn->query("SELECT * FROM officers LIMIT 5");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $officers_sample[] = $row;
        }
    } else {
        $query_error = $conn->error;
    }
}

echo json_encode([
    "tables" => $tables,
    "officers_exists" => in_array('officers', $tables),
    "officers_columns" => $officers_columns,
    "officers_count" => $officers_count,
    "officers_sample" => $officers_sample,
    "query_error" => $query_error
], JSON_PRETTY_PRINT);
?>
