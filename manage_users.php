<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Check if database connected successfully
if (isset($db_connection_error) && $db_connection_error !== null) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $db_connection_error]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // List users
        $sql = "SELECT id, username, role FROM users";
        $result = $conn->query($sql);
        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        echo json_encode(["status" => "success", "users" => $users]);
        break;

    case 'POST':
        // Add user
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
             echo json_encode(["status" => "error", "message" => "Missing username or password"]);
             exit;
        }
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);
        $role = isset($_POST['role']) ? $conn->real_escape_string($_POST['role']) : 'user';
        
        $sql = "INSERT INTO users (username, password, role, full_name) VALUES ('$username', '$password', '$role', '$username')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "User added successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error adding user: " . $conn->error]);
        }
        break;

    case 'DELETE':
        // Delete user (using query param)
        if (!isset($_GET['username'])) {
             echo json_encode(["status" => "error", "message" => "Missing username"]);
             exit;
        }
        $username = $conn->real_escape_string($_GET['username']);
        if ($username === 'admin') {
            echo json_encode(["status" => "error", "message" => "Cannot delete primary admin"]);
            exit;
        }
        $sql = "DELETE FROM users WHERE username = '$username'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting user: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
