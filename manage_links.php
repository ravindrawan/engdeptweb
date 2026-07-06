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
        $sql = "SELECT id, category, title, url, image_url FROM important_links ORDER BY id DESC";
        $result = $conn->query($sql);
        $links = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $links[] = $row;
            }
        }
        echo json_encode(["status" => "success", "links" => $links]);
        break;

    case 'POST':
        if (!isset($_POST['category']) || !isset($_POST['title']) || !isset($_POST['url'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields (category, title, url)"]);
            exit;
        }

        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $category = $conn->real_escape_string($_POST['category']);
        $title = $conn->real_escape_string($_POST['title']);
        $url = $conn->real_escape_string($_POST['url']);
        $image_url = null;

        // Image upload for thumbnail/logo/flag
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            // Sanitize file name
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
            
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $unique_name = 'link_' . time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;

            if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                $image_url = $dest_path;

                // Delete old image file if updating
                if ($id > 0) {
                    $old_res = $conn->query("SELECT image_url FROM important_links WHERE id = $id");
                    if ($old_res && $old_row = $old_res->fetch_assoc()) {
                        $old_img = $old_row['image_url'];
                        if ($old_img && file_exists($old_img) && strpos($old_img, 'uploads/') === 0) {
                            @unlink($old_img);
                        }
                    }
                }
            }
        }

        if ($id > 0) {
            // Update existing link
            $sql = "UPDATE important_links SET 
                        category = '$category', 
                        title = '$title', 
                        url = '$url'";
            if ($image_url !== null) {
                $sql .= ", image_url = '$image_url'";
            }
            $sql .= " WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Link updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating link: " . $conn->error]);
            }
        } else {
            // Insert new link
            $sql = "INSERT INTO important_links (category, title, url, image_url) 
                    VALUES ('$category', '$title', '$url', " . ($image_url ? "'$image_url'" : "NULL") . ")";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Link added successfully", "id" => $conn->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding link: " . $conn->error]);
            }
        }
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
             echo json_encode(["status" => "error", "message" => "Missing ID"]);
             exit;
        }
        $id = intval($_GET['id']);

        // Find thumbnail to delete
        $sql = "SELECT image_url FROM important_links WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image_url = $row['image_url'];
            if ($image_url && file_exists($image_url) && strpos($image_url, 'uploads/') === 0) {
                @unlink($image_url);
            }
        }

        $sql = "DELETE FROM important_links WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Link deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting link: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
