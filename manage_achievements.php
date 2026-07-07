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
        $title_en = $_POST['title_en'];
        $title_si = isset($_POST['title_si']) ? $_POST['title_si'] : '';
        $title_ta = isset($_POST['title_ta']) ? $_POST['title_ta'] : '';
        $description_en = $_POST['description_en'];
        $description_si = isset($_POST['description_si']) ? $_POST['description_si'] : '';
        $description_ta = isset($_POST['description_ta']) ? $_POST['description_ta'] : '';
        $icon_class = isset($_POST['icon_class']) && !empty($_POST['icon_class']) ? $_POST['icon_class'] : 'fa-trophy';

        if ($id > 0) {
            // Prepared Statement එකක් මඟින් Update කිරීම (SQL Injection Safe)
            $stmt = $conn->prepare("UPDATE achievements SET title_en=?, title_si=?, title_ta=?, description_en=?, description_si=?, description_ta=?, icon_class=? WHERE id=?");
            $stmt->bind_param("sssssssi", $title_en, $title_si, $title_ta, $description_en, $description_si, $description_ta, $icon_class, $id);
            
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Achievement updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating achievement: " . $stmt->error]);
            }
            $stmt->close();
        } else {
            // Prepared Statement එකක් මඟින් Insert කිරීම (සිංහල/දෙමළ යුනිකෝඩ් අකුරු සඳහා වඩාත් සුදුසුයි)
            $stmt = $conn->prepare("INSERT INTO achievements (title_en, title_si, title_ta, description_en, description_si, description_ta, icon_class) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $title_en, $title_si, $title_ta, $description_en, $description_si, $description_ta, $icon_class);
            
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Achievement added successfully", "id" => $conn->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding achievement: " . $stmt->error]);
            }
            $stmt->close();
        }
        break;

    case 'DELETE':
        // 🛟 Safe Check: URL එකෙන් හෝ Request Body එකෙන් ID එක ලබාගැනීම
        $id = 0;
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
        } else {
            // JSON body එකක් එවුවොත් එය කියවීම සඳහා fallback එකක්
            $input = json_decode(file_get_contents('php://input'), true);
            if (isset($input['id'])) {
                $id = intval($input['id']);
            }
        }

        if ($id <= 0) {
             echo json_encode(["status" => "error", "message" => "Missing or invalid ID"]);
             exit;
        }

        // Prepared Statement මඟින් ආරක්ෂිතව Delete කිරීම
        $stmt = $conn->prepare("DELETE FROM achievements WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Achievement deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting achievement: " . $stmt->error]);
        }
        $stmt->close();
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
