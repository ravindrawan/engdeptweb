<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Check if database connected successfully
if (isset($db_connection_error) && $db_connection_error !== null) {
    echo json_encode([
        "status" => "error", 
        "message" => "Database Error: " . $db_connection_error . ". Please ensure MySQL is running and the 'nwp_engineering_portal' database exists."
    ]);
    exit;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, username, full_name, role FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode([
            "status" => "success",
            "user" => [
                "username" => $user['username'],
                "name" => $user['full_name'],
                "role" => $user['role']
            ]
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid username or password. If you haven't set up the SQL database, please use the default local login."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

if ($conn) $conn->close();
?>

