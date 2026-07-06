<?php
header('Content-Type: application/json');
require_once 'db_config.php';

if (isset($db_connection_error) && $db_connection_error !== null) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $db_connection_error]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $sql = "SELECT id, title_en, title_si, title_ta, description_en, description_si, description_ta, icon_class FROM achievements ORDER BY id DESC";
        $result = $conn->query($sql);
        $achievements = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $achievements[] = $row;
            }
        }
        echo json_encode(["status" => "success", "achievements" => $achievements]);
        break;

    case 'POST':
        if (!isset($_POST['title_en']) || !isset($_POST['description_en'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields (title_en, description_en)"]);
            exit;
        }

        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $title_en = $conn->real_escape_string($_POST['title_en']);
        $title_si = isset($_POST['title_si']) ? $conn->real_escape_string($_POST['title_si']) : '';
        $title_ta = isset($_POST['title_ta']) ? $conn->real_escape_string($_POST['title_ta']) : '';
        $description_en = $conn->real_escape_string($_POST['description_en']);
        $description_si = isset($_POST['description_si']) ? $conn->real_escape_string($_POST['description_si']) : '';
        $description_ta = isset($_POST['description_ta']) ? $conn->real_escape_string($_POST['description_ta']) : '';
        $icon_class = isset($_POST['icon_class']) && !empty($_POST['icon_class']) ? $conn->real_escape_string($_POST['icon_class']) : 'fa-trophy';

        if ($id > 0) {
            // Update existing achievement
            $sql = "UPDATE achievements SET 
                    title_en = '$title_en', 
                    title_si = '$title_si', 
                    title_ta = '$title_ta', 
                    description_en = '$description_en', 
                    description_si = '$description_si', 
                    description_ta = '$description_ta', 
                    icon_class = '$icon_class' 
                    WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Achievement updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating achievement: " . $conn->error]);
            }
        } else {
            // Insert new achievement
            $sql = "INSERT INTO achievements (title_en, title_si, title_ta, description_en, description_si, description_ta, icon_class) 
                    VALUES ('$title_en', '$title_si', '$title_ta', '$description_en', '$description_si', '$description_ta', '$icon_class')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Achievement added successfully", "id" => $conn->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding achievement: " . $conn->error]);
            }
        }
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
             echo json_encode(["status" => "error", "message" => "Missing ID"]);
             exit;
        }
        $id = intval($_GET['id']);
        $sql = "DELETE FROM achievements WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Achievement deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting achievement: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
