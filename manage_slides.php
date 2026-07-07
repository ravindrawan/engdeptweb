<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'db_config.php';

// Check if database connected successfully
if (isset($db_connection_error) && $db_connection_error !== null) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $db_connection_error]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// PHP 8+ වලදී SQL වැරදි නිහඬව තියෙන්නේ නැතිව Exception එකක් විදිහට අල්ලන්න මෙය දාමු
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

try {
    switch ($method) {
        case 'GET':
            // Retrieve all slideshow photos sorted by display_order
            $sql = "SELECT id, image_url, display_order FROM slider_photos ORDER BY display_order ASC, id ASC";
            $result = $conn->query($sql);
            $slides = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $slides[] = $row;
                }
            }
            echo json_encode(["status" => "success", "slides" => $slides], JSON_UNESCAPED_UNICODE);
            break;

        case 'POST':
            // Enforce maximum of 6 slides
            $count_res = $conn->query("SELECT COUNT(*) as count FROM slider_photos");
            if ($count_res) {
                $count_row = $count_res->fetch_assoc();
                if (intval($count_row['count']) >= 6) {
                    echo json_encode(["status" => "error", "message" => "Maximum of 6 slideshow photos allowed. Please delete an existing photo first."]);
                    exit;
                }
            }

            // Upload and save slide
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(["status" => "error", "message" => "Please select a valid image file to upload."]);
                exit;
            }

            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = basename($_FILES['image']['name']);
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
            
            // Validate it is an image
            $image_info = @getimagesize($file_tmp);
            if ($image_info === false) {
                echo json_encode(["status" => "error", "message" => "Uploaded file is not a valid image."]);
                exit;
            }

            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                if (!@mkdir($upload_dir, 0775, true)) {
                    echo json_encode(["status" => "error", "message" => "Uploads directory 'uploads/' does not exist and cannot be created. Check permissions."]);
                    exit;
                }
            }

            if (!is_writable($upload_dir)) {
                echo json_encode(["status" => "error", "message" => "Uploads directory 'uploads/' is not writable. Please change folder permissions to chmod 775 or 777 on the server."]);
                exit;
            }

            $unique_name = 'slide_' . time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;

            if (move_uploaded_file($file_tmp, $dest_path)) {
                // Find max display_order to append
                $order_res = $conn->query("SELECT MAX(display_order) as max_order FROM slider_photos");
                $max_order = 0;
                if ($order_res && $row = $order_res->fetch_assoc()) {
                    $max_order = intval($row['max_order']);
                }
                $display_order = $max_order + 1;

                $sql = "INSERT INTO slider_photos (image_url, display_order) VALUES ('$dest_path', $display_order)";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode([
                        "status" => "success",
                        "message" => "Slide uploaded successfully.",
                        "slide" => [
                            "id" => $conn->insert_id,
                            "image_url" => $dest_path,
                            "display_order" => $display_order
                        ]
                    ]);
                } else {
                    // Remove file if database insert failed
                    @unlink($dest_path);
                    echo json_encode(["status" => "error", "message" => "Database save failed: " . $conn->error]);
                }
            } else {
                $error = error_get_last();
                $msg = "Failed to save the uploaded slide file.";
                if ($error && isset($error['message'])) {
                    $msg .= " Details: " . $error['message'];
                }
                echo json_encode(["status" => "error", "message" => $msg]);
            }
            break;

        case 'DELETE':
            // Delete slide
            if (!isset($_GET['id'])) {
                 echo json_encode(["status" => "error", "message" => "Missing slide ID."]);
                 exit;
            }
            $id = intval($_GET['id']);

            // Fetch slide details to find image path
            $sql = "SELECT image_url FROM slider_photos WHERE id = $id";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $image_url = $row['image_url'];
                
                // Delete file from disk if it is in uploads directory
                if ($image_url && file_exists($image_url) && strpos($image_url, 'uploads/') === 0) {
                    @unlink($image_url);
                }
            }

            $sql = "DELETE FROM slider_photos WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Slide deleted successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error deleting slide: " . $conn->error]);
            }
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Method not allowed."]);
            break;
    }
} catch (Exception $e) {
    // SQL හෝ වෙනත් ඕනෑම සර්වර් ක්‍රියාවලියකදී एरර් එකක් ආවොත් එය JSON එකක් ලෙස එළියට දෙමු
    echo json_encode(["status" => "error", "message" => "Server Exec Error: " . $e->getMessage()]);
}

if ($conn) $conn->close();
?>
