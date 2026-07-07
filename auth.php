<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Check if database connected successfully
if (isset($db_connection_error) && $db_connection_error !== null) {
    echo json_encode([
        "status" => "error", 
        "message" => "Database Error: " . $db_connection_error . ". Please ensure MySQL is running."
    ]);
    exit;
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        echo json_encode(["status" => "error", "message" => "Missing username or password fields."]);
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $md5_password = md5($password); // Legacy MD5 fallback එකක් සඳහා

    // Prepared Statement භාවිතයෙන් පරිශීලකයා සෙවීම (SQL Injection Safe)
    $stmt = $conn->prepare("SELECT id, username, password, full_name, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // ඩේටාබේස් එකේ ඇති පාස්වර්ඩ් එක Plain text එකක්ද, MD5 ද නැතහොත් Bcrypt ද කියා සසඳමු
        if ($password === $user['password'] || $md5_password === $user['password'] || password_verify($password, $user['password'])) {
            echo json_encode([
                "status" => "success",
                "user" => [
                    "username" => $user['username'],
                    "name" => $user['full_name'],
                    "role" => $user['role']
                ]
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Access Failed: Incorrect password."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Access Failed: User not found."]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

if ($conn) $conn->close();
?>
