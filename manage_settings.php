<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Check if database connected successfully
if (isset($db_connection_error) && $db_connection_error !== null) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $db_connection_error]);
    exit;
}

// Helper to handle multiple uploads
function uploadMultipleFiles($file_input, $prefix, $upload_dir, $id, $conn, $column_name) {
    if (!isset($_FILES[$file_input])) {
        return null;
    }
    
    $paths = [];
    $errors = $_FILES[$file_input]['error'];
    
    if (is_array($errors)) {
        // Multiple files uploaded
        foreach ($errors as $index => $error) {
            if ($error === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES[$file_input]['tmp_name'][$index];
                $file_name = basename($_FILES[$file_input]['name'][$index]);
                $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
                $unique_name = $prefix . '_' . time() . '_' . $index . '_' . $file_name;
                $dest_path = $upload_dir . $unique_name;
                if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                    $paths[] = $dest_path;
                }
            }
        }
    } else {
        // Single file uploaded
        if ($errors === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES[$file_input]['tmp_name'];
            $file_name = basename($_FILES[$file_input]['name']);
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
            $unique_name = $prefix . '_' . time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;
            if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                $paths[] = $dest_path;
            }
        }
    }
    
    if (empty($paths)) {
        return null;
    }
    
    // Clean up old files on update
    if ($id > 0 && $conn) {
        $old_res = $conn->query("SELECT $column_name FROM projects WHERE id = $id");
        if ($old_res && $old_row = $old_res->fetch_assoc()) {
            $old_val = $old_row[$column_name];
            if ($old_val) {
                $old_paths = json_decode($old_val, true);
                if (is_array($old_paths)) {
                    foreach ($old_paths as $old_path) {
                        if ($old_path && file_exists($old_path) && strpos($old_path, 'uploads/') === 0) {
                            @unlink($old_path);
                        }
                    }
                } else {
                    if (file_exists($old_val) && strpos($old_val, 'uploads/') === 0) {
                        @unlink($old_val);
                    }
                }
            }
        }
    }
    
    return json_encode($paths);
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // List projects
        $sql = "SELECT id, category, title_en, title_si, title_ta, description_en, description_si, description_ta, image_url, image_before, image_after, financial_details, gallery_type FROM projects ORDER BY id DESC";
        $result = $conn->query($sql);
        $projects = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $projects[] = $row;
            }
        }
        echo json_encode(["status" => "success", "projects" => $projects]);
        break;

    case 'POST':
        // Add or Update project
        if (!isset($_POST['category']) || !isset($_POST['title_en']) || !isset($_POST['description_en'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields (category, title_en, description_en)"]);
            exit;
        }

        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $category = $conn->real_escape_string($_POST['category']);
        $title_en = $conn->real_escape_string($_POST['title_en']);
        $title_si = isset($_POST['title_si']) ? $conn->real_escape_string($_POST['title_si']) : '';
        $title_ta = isset($_POST['title_ta']) ? $conn->real_escape_string($_POST['title_ta']) : '';
        $description_en = $conn->real_escape_string($_POST['description_en']);
        $description_si = isset($_POST['description_si']) ? $conn->real_escape_string($_POST['description_si']) : '';
        $description_ta = isset($_POST['description_ta']) ? $conn->real_escape_string($_POST['description_ta']) : '';
        $financial_details = isset($_POST['financial_details']) ? $conn->real_escape_string($_POST['financial_details']) : '';
        $gallery_type = isset($_POST['gallery_type']) && !empty($_POST['gallery_type']) ? $conn->real_escape_string($_POST['gallery_type']) : 'none';
        
        $existing_images = [];
        if ($id > 0) {
            $old_res = $conn->query("SELECT image_url FROM projects WHERE id = $id");
            if ($old_res && $old_row = $old_res->fetch_assoc()) {
                $old_img_url = $old_row['image_url'];
                if ($old_img_url) {
                    if (strpos($old_img_url, '[') === 0) {
                        $existing_images = json_decode($old_img_url, true) ?: [];
                    } else {
                        $existing_images = array_filter(explode(',', $old_img_url));
                    }
                }
            }
        }

        $files_changed = false;

        // Support multiple image files (up to 4) - Main Cover images
        if (isset($_FILES['images']) && is_array($_FILES['images']['error'])) {
            $file_count = count($_FILES['images']['error']);
            $new_images = [];
            
            for ($i = 0; $i < $file_count; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $file_tmp = $_FILES['images']['tmp_name'][$i];
                    $file_name = basename($_FILES['images']['name'][$i]);
                    // Sanitize file name
                    $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);

                    $upload_dir = 'uploads/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    $unique_name = 'project_' . time() . '_' . $i . '_' . $file_name;
                    $dest_path = $upload_dir . $unique_name;

                    if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                        $new_images[] = $dest_path;
                    }
                }
            }
            
            if (!empty($new_images)) {
                $files_changed = true;
                // Delete old files from disk
                foreach ($existing_images as $old_img) {
                    if ($old_img && $old_img !== '#' && file_exists($old_img) && strpos($old_img, 'uploads/') === 0) {
                        @unlink($old_img);
                    }
                }
                $existing_images = $new_images;
            }
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Legacy single file support
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);

            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $unique_name = 'project_' . time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;

            if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                $files_changed = true;
                // Delete old files from disk
                foreach ($existing_images as $old_img) {
                    if ($old_img && $old_img !== '#' && file_exists($old_img) && strpos($old_img, 'uploads/') === 0) {
                        @unlink($old_img);
                    }
                }
                $existing_images = [$dest_path];
            }
        }

        $image_url_str = !empty($existing_images) ? json_encode($existing_images) : null;

        $upload_dir = 'uploads/';
        // Image upload: Before (used for both Renovation Before and Event photos)
        $image_before = uploadMultipleFiles('image_before', 'proj_before', $upload_dir, $id, $conn, 'image_before');

        // Image upload: After
        $image_after = uploadMultipleFiles('image_after', 'proj_after', $upload_dir, $id, $conn, 'image_after');

        if ($id > 0) {
            // Update existing project
            $sql = "UPDATE projects SET 
                        category = '$category', 
                        title_en = '$title_en', 
                        title_si = '$title_si', 
                        title_ta = '$title_ta', 
                        description_en = '$description_en', 
                        description_si = '$description_si', 
                        description_ta = '$description_ta', 
                        financial_details = '$financial_details',
                        gallery_type = '$gallery_type'";
            
            if ($files_changed || !empty($existing_images)) {
                $sql .= ", image_url = " . ($image_url_str ? "'$image_url_str'" : "NULL");
            }
            if ($image_before !== null) {
                $sql .= ", image_before = '$image_before'";
            }
            if ($image_after !== null) {
                $sql .= ", image_after = '$image_after'";
            }
            
            // Clean up files based on gallery_type constraints
            if ($gallery_type === 'event') {
                $old_res = $conn->query("SELECT image_after FROM projects WHERE id = $id");
                if ($old_res && $old_row = $old_res->fetch_assoc()) {
                    $old_after = $old_row['image_after'];
                    if ($old_after) {
                        $old_paths = json_decode($old_after, true);
                        if (is_array($old_paths)) {
                            foreach ($old_paths as $old_path) {
                                if ($old_path && file_exists($old_path) && strpos($old_path, 'uploads/') === 0) {
                                    @unlink($old_path);
                                }
                            }
                        }
                    }
                }
                $sql .= ", image_after = NULL";
            } elseif ($gallery_type === 'none') {
                $old_res = $conn->query("SELECT image_before, image_after FROM projects WHERE id = $id");
                if ($old_res && $old_row = $old_res->fetch_assoc()) {
                    foreach (['image_before', 'image_after'] as $col) {
                        $old_val = $old_row[$col];
                        if ($old_val) {
                            $old_paths = json_decode($old_val, true);
                            if (is_array($old_paths)) {
                                foreach ($old_paths as $old_path) {
                                    if ($old_path && file_exists($old_path) && strpos($old_path, 'uploads/') === 0) {
                                        @unlink($old_path);
                                    }
                                }
                            }
                        }
                    }
                }
                $sql .= ", image_before = NULL, image_after = NULL";
            }
            
            $sql .= " WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Project updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating project: " . $conn->error]);
            }
        } else {
            // Insert new project
            $sql = "INSERT INTO projects (category, title_en, title_si, title_ta, description_en, description_si, description_ta, image_url, financial_details, image_before, image_after, gallery_type) 
                    VALUES ('$category', '$title_en', '$title_si', '$title_ta', '$description_en', '$description_si', '$description_ta', 
                            " . ($image_url_str ? "'$image_url_str'" : "NULL") . ", 
                            '$financial_details',
                            " . (($gallery_type !== 'none' && $image_before) ? "'$image_before'" : "NULL") . ", 
                            " . (($gallery_type === 'renovation' && $image_after) ? "'$image_after'" : "NULL") . ", 
                            '$gallery_type')";
                    
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Project added successfully", "id" => $conn->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding project: " . $conn->error]);
            }
        }
        break;

    case 'DELETE':
        // Delete project
        if (!isset($_GET['id'])) {
             echo json_encode(["status" => "error", "message" => "Missing project ID"]);
             exit;
        }
        $id = intval($_GET['id']);

        // Remove all image files associated with the project from disk
        $sql = "SELECT image_url, image_before, image_after FROM projects WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            foreach (['image_url', 'image_before', 'image_after'] as $col) {
                $file_val = $row[$col];
                if ($file_val) {
                    $images = [];
                    if (strpos($file_val, '[') === 0) {
                        $images = json_decode($file_val, true) ?: [];
                    } else {
                        $images = array_filter(explode(',', $file_val));
                    }
                    foreach ($images as $img) {
                        if ($img && file_exists($img) && strpos($img, 'uploads/') === 0) {
                            @unlink($img);
                        }
                    }
                }
            }
        }

        $sql = "DELETE FROM projects WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Project deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting project: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
