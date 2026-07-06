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
        // List officers
        $sql = "SELECT id, name, title, phone, category, division, email, photo_url FROM officers ORDER BY id DESC";
        $result = $conn->query($sql);
        $officers = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $officers[] = $row;
            }
            echo json_encode(["status" => "success", "officers" => $officers]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database Query Error: " . $conn->error]);
        }
        break;

    case 'POST':
        // Add or Update officer
        if (!isset($_POST['name']) || !isset($_POST['title']) || !isset($_POST['phone']) || !isset($_POST['category'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields (name, title, phone, category)"]);
            exit;
        }
        
        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $name = $conn->real_escape_string($_POST['name']);
        $title = $conn->real_escape_string($_POST['title']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $category = $conn->real_escape_string($_POST['category']);
        $division = isset($_POST['division']) ? $conn->real_escape_string($_POST['division']) : ($category === 'div' ? 'Division Office' : 'Head Office');
        $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : null;
        $photo_url = null;

        // Handle photo upload
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_name = basename($_FILES['photo']['name']);
            // Sanitize file name
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
            
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $unique_name = 'officer_' . time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;

            if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                $photo_url = $dest_path;

                // Delete old photo from disk if we are updating
                if ($id > 0) {
                    $old_res = $conn->query("SELECT photo_url FROM officers WHERE id = $id");
                    if ($old_res && $old_row = $old_res->fetch_assoc()) {
                        $old_photo = $old_row['photo_url'];
                        if ($old_photo && file_exists($old_photo) && strpos($old_photo, 'uploads/') === 0) {
                            @unlink($old_photo);
                        }
                    }
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to save officer photo."]);
                exit;
            }
        }

        if ($id > 0) {
            // Update existing officer
            $sql = "UPDATE officers SET 
                        name = '$name', 
                        title = '$title', 
                        phone = '$phone', 
                        category = '$category', 
                        division = '$division', 
                        email = " . ($email ? "'$email'" : "NULL");
            if ($photo_url !== null) {
                $sql .= ", photo_url = '$photo_url'";
            }
            $sql .= " WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Officer updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating officer: " . $conn->error]);
            }
        } else {
            // Insert new officer
            $sql = "INSERT INTO officers (name, title, phone, category, division, email, photo_url) VALUES ('$name', '$title', '$phone', '$category', '$division', " . ($email ? "'$email'" : "NULL") . ", " . ($photo_url ? "'$photo_url'" : "NULL") . ")";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Officer added successfully", "id" => $conn->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding officer: " . $conn->error]);
            }
        }
        break;

    case 'DELETE':
        // Delete officer (using query param ?id=X)
        if (!isset($_GET['id'])) {
             echo json_encode(["status" => "error", "message" => "Missing officer ID"]);
             exit;
        }
        $id = intval($_GET['id']);

        // Remove photo file from disk if it exists
        $sql = "SELECT photo_url FROM officers WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $photo_url = $row['photo_url'];
            if ($photo_url && file_exists($photo_url) && strpos($photo_url, 'uploads/') === 0) {
                @unlink($photo_url);
            }
        }

        $sql = "DELETE FROM officers WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Officer deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting officer: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
