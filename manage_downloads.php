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
        // List downloads
        $sql = "SELECT id, title, description, category, file_url, icon_class FROM downloads ORDER BY id DESC";
        $result = $conn->query($sql);
        $downloads = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Return 'desc' as a key too to remain compatible with legacy js properties
                $row['desc'] = $row['description'];
                $row['icon'] = $row['icon_class'];
                $downloads[] = $row;
            }
        }
        echo json_encode(["status" => "success", "downloads" => $downloads]);
        break;

    case 'POST':
        // Add or Update download (with file upload support)
        if (!isset($_POST['title']) || !isset($_POST['description']) || !isset($_POST['category'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields (title, description, category)"]);
            exit;
        }

        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $title = $conn->real_escape_string($_POST['title']);
        $description = $conn->real_escape_string($_POST['description']);
        $category = $conn->real_escape_string($_POST['category']);
        
        $file_url = null;
        $icon_class = null;

        // Check if file was uploaded
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_name = basename($_FILES['file']['name']);
            // Sanitize file name
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
            
            // Create uploads directory if not exists
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Generate unique filename to prevent overwriting
            $unique_name = time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;

            if (move_uploaded_path($file_tmp, $dest_path)) {
                // File successfully uploaded
                $file_url = $dest_path;

                // Auto-detect icon class
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $icon_class = 'fa-file-alt';
                if ($ext === 'pdf') {
                    $icon_class = 'fa-file-pdf';
                } elseif (in_array($ext, ['doc', 'docx'])) {
                    $icon_class = 'fa-file-word';
                } elseif (in_array($ext, ['xls', 'xlsx'])) {
                    $icon_class = 'fa-file-excel';
                } elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) {
                    $icon_class = 'fa-file-image';
                }

                // Delete old file from disk if we are updating
                if ($id > 0) {
                    $old_res = $conn->query("SELECT file_url FROM downloads WHERE id = $id");
                    if ($old_res && $old_row = $old_res->fetch_assoc()) {
                        $old_file = $old_row['file_url'];
                        if ($old_file && $old_file !== '#' && file_exists($old_file) && strpos($old_file, 'uploads/') === 0) {
                            @unlink($old_file);
                        }
                    }
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to save uploaded file."]);
                exit;
            }
        } else {
            // Check if base64 file data was sent (fallback for backwards compatibility)
            if (isset($_POST['fileData']) && !empty($_POST['fileData'])) {
                $base64_data = $_POST['fileData'];
                $file_name = isset($_POST['fileName']) ? $_POST['fileName'] : 'document.bin';
                // Sanitize file name
                $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
                
                // Create uploads directory if not exists
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $unique_name = time() . '_' . $file_name;
                $dest_path = $upload_dir . $unique_name;

                // Strip data uri prefix if present
                if (preg_match('/^data:([^;]+);base64,(.*)$/', $base64_data, $matches)) {
                    $base64_data = $matches[2];
                }
                
                $decoded = base64_decode($base64_data);
                if (file_put_contents($dest_path, $decoded) !== false) {
                    $file_url = $dest_path;
                    // Auto-detect icon
                    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $icon_class = 'fa-file-alt';
                    if ($ext === 'pdf') $icon_class = 'fa-file-pdf';
                    elseif (in_array($ext, ['doc', 'docx'])) $icon_class = 'fa-file-word';
                    elseif (in_array($ext, ['xls', 'xlsx'])) $icon_class = 'fa-file-excel';
                    elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) $icon_class = 'fa-file-image';

                    // Delete old file from disk if we are updating
                    if ($id > 0) {
                        $old_res = $conn->query("SELECT file_url FROM downloads WHERE id = $id");
                        if ($old_res && $old_row = $old_res->fetch_assoc()) {
                            $old_file = $old_row['file_url'];
                            if ($old_file && $old_file !== '#' && file_exists($old_file) && strpos($old_file, 'uploads/') === 0) {
                                @unlink($old_file);
                            }
                        }
                    }
                }
            }
        }

        if ($id > 0) {
            // Update existing record
            $sql = "UPDATE downloads SET title = '$title', description = '$description', category = '$category'";
            if ($file_url !== null) {
                $sql .= ", file_url = '$file_url', icon_class = '$icon_class'";
            }
            $sql .= " WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Document updated successfully",
                    "id" => $id,
                    "file_url" => ($file_url !== null) ? $file_url : ''
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating document: " . $conn->error]);
            }
        } else {
            // Insert new record
            $final_file_url = ($file_url !== null) ? $file_url : '#';
            $final_icon_class = ($icon_class !== null) ? $icon_class : 'fa-file-alt';
            $sql = "INSERT INTO downloads (title, description, category, file_url, icon_class) VALUES ('$title', '$description', '$category', '$final_file_url', '$final_icon_class')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Document uploaded successfully",
                    "id" => $conn->insert_id,
                    "file_url" => $final_file_url
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error saving download: " . $conn->error]);
            }
        }
        break;

    case 'DELETE':
        // Delete download (using query param ?id=X)
        if (!isset($_GET['id'])) {
             echo json_encode(["status" => "error", "message" => "Missing download ID"]);
             exit;
        }
        $id = intval($_GET['id']);
        
        // Find file path to delete from disk
        $sql = "SELECT file_url FROM downloads WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $file_url = $row['file_url'];
            
            // Delete physical file if it exists and is in the uploads directory
            if ($file_url !== '#' && file_exists($file_url) && strpos($file_url, 'uploads/') === 0) {
                @unlink($file_url);
            }
        }

        $sql = "DELETE FROM downloads WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Document deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting document: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

// Helper function to safely move uploaded files
function move_uploaded_path($tmp, $dest) {
    // Under regular server context, use move_uploaded_file
    if (is_uploaded_file($tmp)) {
        return move_uploaded_file($tmp, $dest);
    }
    // Under CLI/Testing context, copy is acceptable
    return copy($tmp, $dest);
}

if ($conn) $conn->close();
?>
