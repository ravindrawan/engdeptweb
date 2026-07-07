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
        $sql = "SELECT id, category, title, url, badge FROM announcements ORDER BY id DESC";
        $result = $conn->query($sql);
        $announcements = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $announcements[] = $row;
            }
        }
        echo json_encode(["status" => "success", "announcements" => $announcements]);
        break;

    case 'POST':
        if (!isset($_POST['category']) || !isset($_POST['title'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields (category, title)"]);
            exit;
        }

        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $category = $_POST['category'];
        $title = $_POST['title'];
        $url = isset($_POST['url']) && !empty($_POST['url']) ? $_POST['url'] : '#';
        
        // Badge එක හිස් නම් variable එක null කරන්න (bind_param වලදී null විදිහට යැවීමට)
        $badge = isset($_POST['badge']) && !empty($_POST['badge']) ? $_POST['badge'] : null;

        if ($id > 0) {
            // Update existing announcement (Prepared Statement)
            $stmt = $conn->prepare("UPDATE announcements SET category = ?, title = ?, url = ?, badge = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $category, $title, $url, $badge, $id);
            
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Announcement updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating announcement: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            // Insert new announcement (Prepared Statement)
            $stmt = $conn->prepare("INSERT INTO announcements (category, title, url, badge) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $category, $title, $url, $badge);
            
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Announcement added successfully", "id" => $conn->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding announcement: " . $stmt->error]);
            }
            $stmt->close();
        }
        break;

    case 'DELETE':
        $id = 0;
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
        } else {
            // JavaScript body fallback එකක් ලෙස JSON කියවීම
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['id'])) {
                $id = intval($input['id']);
            }
        }

        if ($id <= 0) {
             echo json_encode(["status" => "error", "message" => "Missing or invalid ID"]);
             exit;
        }

        // Safe Delete
        $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Announcement deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting announcement: " . $stmt->error]);
        }
        $stmt->close();
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
