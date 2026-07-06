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
        // List procurements
        $sql = "SELECT id, title, publish_date, file_url, status FROM procurements ORDER BY publish_date DESC, id DESC";
        $result = $conn->query($sql);
        $procurements = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $procurements[] = $row;
            }
        }
        echo json_encode(["status" => "success", "procurements" => $procurements]);
        break;

    case 'POST':
        // Add or Update procurement notice
        if (!isset($_POST['title'])) {
            echo json_encode(["status" => "error", "message" => "Missing title"]);
            exit;
        }

        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $title = $conn->real_escape_string($_POST['title']);
        $status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : 'active';
        $file_url = null;

        // Check file upload
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_name = basename($_FILES['file']['name']);
            // Sanitize file name
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
            
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $unique_name = 'tender_' . time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;

            // Use copy/move_uploaded_file helper logic
            if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                $file_url = $dest_path;

                // Delete old file from disk if we are updating
                if ($id > 0) {
                    $old_res = $conn->query("SELECT file_url FROM procurements WHERE id = $id");
                    if ($old_res && $old_row = $old_res->fetch_assoc()) {
                        $old_file = $old_row['file_url'];
                        if ($old_file && $old_file !== '#' && file_exists($old_file) && strpos($old_file, 'uploads/') === 0) {
                            @unlink($old_file);
                        }
                    }
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to save tender file."]);
                exit;
            }
        }

        if ($id > 0) {
            // Update existing notice
            $sql = "UPDATE procurements SET title = '$title', status = '$status'";
            if ($file_url !== null) {
                $sql .= ", file_url = '$file_url'";
            }
            $sql .= " WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Procurement notice updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating notice: " . $conn->error]);
            }
        } else {
            // Insert new notice
            $publish_date = date('Y-m-d');
            $final_file_url = ($file_url !== null) ? $file_url : '#';
            $sql = "INSERT INTO procurements (title, publish_date, file_url, status) VALUES ('$title', '$publish_date', '$final_file_url', '$status')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Procurement notice added successfully", "id" => $conn->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding notice: " . $conn->error]);
            }
        }
        break;

    case 'DELETE':
        // Delete procurement notice
        if (!isset($_GET['id'])) {
             echo json_encode(["status" => "error", "message" => "Missing notice ID"]);
             exit;
        }
        $id = intval($_GET['id']);

        // Remove file from disk
        $sql = "SELECT file_url FROM procurements WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $file_url = $row['file_url'];
            if ($file_url !== '#' && file_exists($file_url) && strpos($file_url, 'uploads/') === 0) {
                @unlink($file_url);
            }
        }

        $sql = "DELETE FROM procurements WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Procurement notice deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting notice: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
