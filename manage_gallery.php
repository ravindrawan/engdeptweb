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
        // List gallery items
        $sql = "SELECT id, title, image_url, description FROM gallery ORDER BY id DESC";
        $result = $conn->query($sql);
        $gallery = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $gallery[] = $row;
            }
        }
        echo json_encode(["status" => "success", "gallery" => $gallery]);
        break;

    case 'POST':
        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;

        // Add or Update gallery item (Supports single or multiple images on addition)
        if (!isset($_POST['title']) || ($id === 0 && !isset($_FILES['image']))) {
            echo json_encode(["status" => "error", "message" => "Missing title or image file"]);
            exit;
        }

        $title = $conn->real_escape_string($_POST['title']);
        $description = isset($_POST['description']) ? $conn->real_escape_string($_POST['description']) : '';
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if ($id > 0) {
            // Update existing gallery item
            $image_url = null;
            if (isset($_FILES['image'])) {
                $error = is_array($_FILES['image']['error']) ? $_FILES['image']['error'][0] : $_FILES['image']['error'];
                if ($error === UPLOAD_ERR_OK) {
                    $file_tmp = is_array($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'][0] : $_FILES['image']['tmp_name'];
                    $file_name = basename(is_array($_FILES['image']['name']) ? $_FILES['image']['name'][0] : $_FILES['image']['name']);
                    $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
                    
                    $unique_name = 'gallery_' . time() . '_' . $file_name;
                    $dest_path = $upload_dir . $unique_name;
                    
                    if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                        $image_url = $dest_path;
                        
                        // Delete old image file
                        $old_res = $conn->query("SELECT image_url FROM gallery WHERE id = $id");
                        if ($old_res && $old_row = $old_res->fetch_assoc()) {
                            $old_img = $old_row['image_url'];
                            if ($old_img && file_exists($old_img) && strpos($old_img, 'uploads/') === 0) {
                                @unlink($old_img);
                            }
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "Failed to save gallery image."]);
                        exit;
                    }
                }
            }

            $sql = "UPDATE gallery SET title = '$title', description = '$description'";
            if ($image_url !== null) {
                $sql .= ", image_url = '$image_url'";
            }
            $sql .= " WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Gallery item updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating gallery item: " . $conn->error]);
            }
        } else {
            // Add new gallery items (Supports single or multiple images)
            $errors = $_FILES['image']['error'];
            $uploaded_count = 0;
            $inserted_ids = [];
            $failed_uploads = 0;

            if (is_array($errors)) {
                // Multiple images uploaded
                $total_images = count($errors);
                // Limit to maximum 10 images to prevent server timeouts and resource exhaustion
                if ($total_images > 10) {
                    $total_images = 10;
                }
                for ($index = 0; $index < $total_images; $index++) {
                    $error = $errors[$index];
                    if ($error === UPLOAD_ERR_OK) {
                        $file_tmp = $_FILES['image']['tmp_name'][$index];
                        $file_name = basename($_FILES['image']['name'][$index]);
                        $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
                        
                        // Suffix the title with the index if there are multiple images
                        $item_title = $title;
                        if ($total_images > 1) {
                            $item_title = $title . " (" . ($index + 1) . ")";
                        }
                        
                        $unique_name = 'gallery_' . time() . '_' . $index . '_' . $file_name;
                        $dest_path = $upload_dir . $unique_name;

                        if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                            $image_url = $dest_path;
                            $sql = "INSERT INTO gallery (title, image_url, description) VALUES ('$item_title', '$image_url', '$description')";
                            if ($conn->query($sql) === TRUE) {
                                $inserted_ids[] = $conn->insert_id;
                                $uploaded_count++;
                            } else {
                                $failed_uploads++;
                            }
                        } else {
                            $failed_uploads++;
                        }
                    } else {
                        $failed_uploads++;
                    }
                }
                if ($uploaded_count > 0) {
                    echo json_encode(["status" => "success", "message" => "$uploaded_count photo(s) uploaded successfully", "ids" => $inserted_ids]);
                } else {
                    echo json_encode(["status" => "error", "message" => "All image uploads failed."]);
                }
            } else {
                // Single image uploaded
                if ($errors === UPLOAD_ERR_OK) {
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_name = basename($_FILES['image']['name']);
                    $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
                    
                    $unique_name = 'gallery_' . time() . '_' . $file_name;
                    $dest_path = $upload_dir . $unique_name;

                    if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                        $image_url = $dest_path;
                        $sql = "INSERT INTO gallery (title, image_url, description) VALUES ('$title', '$image_url', '$description')";
                        if ($conn->query($sql) === TRUE) {
                            echo json_encode(["status" => "success", "message" => "Gallery item added successfully", "id" => $conn->insert_id]);
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error adding gallery item: " . $conn->error]);
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "Failed to save gallery image."]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Image upload failed."]);
                }
            }
        }
        break;

    case 'DELETE':
        // Delete gallery item
        if (!isset($_GET['id'])) {
             echo json_encode(["status" => "error", "message" => "Missing item ID"]);
             exit;
        }
        $id = intval($_GET['id']);

        // Remove image file from disk
        $sql = "SELECT image_url FROM gallery WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image_url = $row['image_url'];
            if ($image_url && file_exists($image_url) && strpos($image_url, 'uploads/') === 0) {
                @unlink($image_url);
            }
        }

        $sql = "DELETE FROM gallery WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Gallery item deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting item: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
