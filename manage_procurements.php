<?php
header('Content-Type: application/json');
require_once 'db_config.php';

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
        $old_res = $conn->query("SELECT $column_name FROM news WHERE id = $id");
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
        $sql = "SELECT id, category, title, news_date, content, image_url, image_before, image_after, url, gallery_type FROM news ORDER BY news_date DESC, id DESC";
        $result = $conn->query($sql);
        $news = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $news[] = $row;
            }
        }
        echo json_encode(["status" => "success", "news" => $news]);
        break;

    case 'POST':
        if (!isset($_POST['category']) || !isset($_POST['title']) || !isset($_POST['content'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields (category, title, content)"]);
            exit;
        }

        $category = $conn->real_escape_string($_POST['category']);
        $title = $conn->real_escape_string($_POST['title']);
        $content = $conn->real_escape_string($_POST['content']);
        $news_date = isset($_POST['news_date']) && !empty($_POST['news_date']) ? $conn->real_escape_string($_POST['news_date']) : date('Y-m-d');
        $url = isset($_POST['url']) && !empty($_POST['url']) ? $conn->real_escape_string($_POST['url']) : '#';
        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $gallery_type = isset($_POST['gallery_type']) && !empty($_POST['gallery_type']) ? $conn->real_escape_string($_POST['gallery_type']) : 'none';
        
        $image_url = null;
        $image_before = null;
        $image_after = null;

        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Image upload: Main
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $unique_name = 'news_' . time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;
            if (is_uploaded_file($file_tmp) ? move_uploaded_file($file_tmp, $dest_path) : copy($file_tmp, $dest_path)) {
                $image_url = $dest_path;
                if ($id > 0) {
                    $old_res = $conn->query("SELECT image_url FROM news WHERE id = $id");
                    if ($old_res && $old_row = $old_res->fetch_assoc()) {
                        $old_img = $old_row['image_url'];
                        if ($old_img && file_exists($old_img) && strpos($old_img, 'uploads/') === 0) {
                            @unlink($old_img);
                        }
                    }
                }
            }
        }

        // Image upload: Before (used for both Renovation Before and Event photos)
        $image_before = uploadMultipleFiles('image_before', 'news_before', $upload_dir, $id, $conn, 'image_before');

        // Image upload: After
        $image_after = uploadMultipleFiles('image_after', 'news_after', $upload_dir, $id, $conn, 'image_after');

        if ($id > 0) {
            // Update existing news article
            $sql = "UPDATE news SET 
                        category = '$category', 
                        title = '$title', 
                        news_date = '$news_date', 
                        content = '$content', 
                        url = '$url',
                        gallery_type = '$gallery_type'";
            if ($image_url !== null) {
                $sql .= ", image_url = '$image_url'";
            }
            if ($image_before !== null) {
                $sql .= ", image_before = '$image_before'";
            }
            if ($image_after !== null) {
                $sql .= ", image_after = '$image_after'";
            }
            
            // Clean up files based on gallery_type constraints
            if ($gallery_type === 'event') {
                $old_res = $conn->query("SELECT image_after FROM news WHERE id = $id");
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
                $old_res = $conn->query("SELECT image_before, image_after FROM news WHERE id = $id");
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
                echo json_encode(["status" => "success", "message" => "News article updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating news article: " . $conn->error]);
            }
        } else {
            // Insert new news article
            $sql = "INSERT INTO news (category, title, news_date, content, image_url, image_before, image_after, url, gallery_type) 
                    VALUES ('$category', '$title', '$news_date', '$content', 
                            " . ($image_url ? "'$image_url'" : "NULL") . ", 
                            " . (($gallery_type !== 'none' && $image_before) ? "'$image_before'" : "NULL") . ", 
                            " . (($gallery_type === 'renovation' && $image_after) ? "'$image_after'" : "NULL") . ", 
                            '$url', '$gallery_type')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "News article added successfully", "id" => $conn->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding news article: " . $conn->error]);
            }
        }
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
             echo json_encode(["status" => "error", "message" => "Missing ID"]);
             exit;
        }
        $id = intval($_GET['id']);

        // Find cover image, before image, and after image to delete from disk
        $sql = "SELECT image_url, image_before, image_after FROM news WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            foreach (['image_url', 'image_before', 'image_after'] as $col) {
                $file_val = $row[$col];
                if ($file_val) {
                    $paths = json_decode($file_val, true);
                    if (is_array($paths)) {
                        foreach ($paths as $file_path) {
                            if ($file_path && file_exists($file_path) && strpos($file_path, 'uploads/') === 0) {
                                @unlink($file_path);
                            }
                        }
                    } else {
                        if (file_exists($file_val) && strpos($file_val, 'uploads/') === 0) {
                            @unlink($file_val);
                        }
                    }
                }
            }
        }

        $sql = "DELETE FROM news WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "News article deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting news article: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
