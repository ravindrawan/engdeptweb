<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'db_config.php';

// Check if database connected successfully
if (isset($db_connection_error) && $db_connection_error !== null) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $db_connection_error]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['increment']) && $_GET['increment'] === '1') {
            // First check if the row exists, if not insert it
            $conn->query("INSERT IGNORE INTO site_sections (section_key, content_en, content_si, content_ta) VALUES ('visitor_count', '1458', '1458', '1458')");
            // Increment the counter
            $conn->query("UPDATE site_sections SET content_en = content_en + 1, content_si = content_si + 1, content_ta = content_ta + 1 WHERE section_key = 'visitor_count'");
        }
        // Retrieve all site settings / sections
        $sql = "SELECT section_key, content_en, content_si, content_ta FROM site_sections";
        $result = $conn->query($sql);
        $settings = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $settings[$row['section_key']] = [
                    'en' => $row['content_en'],
                    'si' => $row['content_si'],
                    'ta' => $row['content_ta']
                ];
            }
        }
        echo json_encode(["status" => "success", "settings" => $settings], JSON_UNESCAPED_UNICODE);
        break;

    case 'POST':
        // Add or update a setting
        if (!isset($_POST['section_key'])) {
            echo json_encode(["status" => "error", "message" => "Missing section_key"]);
            exit;
        }

        $section_key = $conn->real_escape_string($_POST['section_key']);

        if ($section_key === 'rti_application_form') {
            // Retrieve current values to retain old values if no file is uploaded
            $res = $conn->query("SELECT content_en, content_si, content_ta FROM site_sections WHERE section_key = 'rti_application_form'");
            $current = $res ? $res->fetch_assoc() : null;
            
            $file_en = $current ? $current['content_en'] : '#';
            $file_si = $current ? $current['content_si'] : '#';
            $file_ta = $current ? $current['content_ta'] : '#';

            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                if (!@mkdir($upload_dir, 0775, true)) {
                    echo json_encode(["status" => "error", "message" => "Uploads directory cannot be created."]);
                    exit;
                }
            }

            // Function to handle single file upload
            $upload_file = function($file_key, $prefix) use ($upload_dir) {
                if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
                    $file_tmp = $_FILES[$file_key]['tmp_name'];
                    $file_name = basename($_FILES[$file_key]['name']);
                    $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
                    
                    $unique_name = $prefix . '_' . time() . '_' . $file_name;
                    $dest_path = $upload_dir . $unique_name;
                    
                    if (move_uploaded_file($file_tmp, $dest_path)) {
                        return $dest_path;
                    }
                }
                return null;
            };

            // Process uploads and delete old files if updated
            $new_en = $upload_file('rti_file_en', 'rti_en');
            if ($new_en !== null) {
                if ($file_en && $file_en !== '#' && file_exists($file_en) && strpos($file_en, 'uploads/') === 0) {
                    @unlink($file_en);
                }
                $file_en = $new_en;
            }

            $new_si = $upload_file('rti_file_si', 'rti_si');
            if ($new_si !== null) {
                if ($file_si && $file_si !== '#' && file_exists($file_si) && strpos($file_si, 'uploads/') === 0) {
                    @unlink($file_si);
                }
                $file_si = $new_si;
            }

            $new_ta = $upload_file('rti_file_ta', 'rti_ta');
            if ($new_ta !== null) {
                if ($file_ta && $file_ta !== '#' && file_exists($file_ta) && strpos($file_ta, 'uploads/') === 0) {
                    @unlink($file_ta);
                }
                $file_ta = $new_ta;
            }

            // Also check if any form requests removal
            if (isset($_POST['remove_rti_en']) && $_POST['remove_rti_en'] === '1') {
                if ($file_en && $file_en !== '#' && file_exists($file_en) && strpos($file_en, 'uploads/') === 0) {
                    @unlink($file_en);
                }
                $file_en = '#';
            }
            if (isset($_POST['remove_rti_si']) && $_POST['remove_rti_si'] === '1') {
                if ($file_si && $file_si !== '#' && file_exists($file_si) && strpos($file_si, 'uploads/') === 0) {
                    @unlink($file_si);
                }
                $file_si = '#';
            }
            if (isset($_POST['remove_rti_ta']) && $_POST['remove_rti_ta'] === '1') {
                if ($file_ta && $file_ta !== '#' && file_exists($file_ta) && strpos($file_ta, 'uploads/') === 0) {
                    @unlink($file_ta);
                }
                $file_ta = '#';
            }

            $sql = "INSERT INTO site_sections (section_key, content_en, content_si, content_ta) 
                    VALUES ('rti_application_form', '$file_en', '$file_si', '$file_ta') 
                    ON DUPLICATE KEY UPDATE content_en = '$file_en', content_si = '$file_si', content_ta = '$file_ta'";
            
            if ($conn->query($sql) === TRUE) {
                echo json_encode([
                    "status" => "success", 
                    "message" => "RTI application files updated successfully",
                    "rti_application_form" => [
                        "en" => $file_en,
                        "si" => $file_si,
                        "ta" => $file_ta
                    ]
                ]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error saving RTI files: " . $conn->error]);
            }
            exit;
        }

        if ($section_key === 'home_banner_url') {
            $banner_url = '';
            
            // If they want to remove banner
            if (isset($_POST['remove_banner']) && $_POST['remove_banner'] === '1') {
                // Delete old banner file
                $old_res = $conn->query("SELECT content_en FROM site_sections WHERE section_key = 'home_banner_url'");
                if ($old_res && $old_row = $old_res->fetch_assoc()) {
                    $old_banner = $old_row['content_en'];
                    if ($old_banner && file_exists($old_banner) && strpos($old_banner, 'uploads/') === 0) {
                        @unlink($old_banner);
                    }
                }
                $banner_url = '';
            } elseif (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['banner']['tmp_name'];
                $file_name = basename($_FILES['banner']['name']);
                $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
                
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
                
                $unique_name = 'home_banner_' . time() . '_' . $file_name;
                $dest_path = $upload_dir . $unique_name;
                
                if (move_uploaded_file($file_tmp, $dest_path)) {
                    // Delete old banner if exists
                    $old_res = $conn->query("SELECT content_en FROM site_sections WHERE section_key = 'home_banner_url'");
                    if ($old_res && $old_row = $old_res->fetch_assoc()) {
                        $old_banner = $old_row['content_en'];
                        if ($old_banner && file_exists($old_banner) && strpos($old_banner, 'uploads/') === 0) {
                            @unlink($old_banner);
                        }
                    }
                    $banner_url = $dest_path;
                } else {
                    $error = error_get_last();
                    $msg = "Failed to save home banner file.";
                    if ($error && isset($error['message'])) {
                        $msg .= " Details: " . $error['message'];
                    }
                    echo json_encode(["status" => "error", "message" => $msg]);
                    exit;
                }
            } else {
                // Keep old banner if no file uploaded and not removing
                $old_res = $conn->query("SELECT content_en FROM site_sections WHERE section_key = 'home_banner_url'");
                if ($old_res && $old_row = $old_res->fetch_assoc()) {
                    $banner_url = $old_row['content_en'];
                }
            }
            
            $sql = "INSERT INTO site_sections (section_key, content_en, content_si, content_ta) 
                    VALUES ('home_banner_url', '$banner_url', '$banner_url', '$banner_url') 
                    ON DUPLICATE KEY UPDATE content_en = '$banner_url', content_si = '$banner_url', content_ta = '$banner_url'";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Home banner updated successfully", "banner_url" => $banner_url]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error saving home banner: " . $conn->error]);
            }
            break;
        }

        $content_en = isset($_POST['content_en']) ? $conn->real_escape_string($_POST['content_en']) : '';
        $content_si = isset($_POST['content_si']) ? $conn->real_escape_string($_POST['content_si']) : '';
        $content_ta = isset($_POST['content_ta']) ? $conn->real_escape_string($_POST['content_ta']) : '';

        $sql = "INSERT INTO site_sections (section_key, content_en, content_si, content_ta) 
                VALUES ('$section_key', '$content_en', '$content_si', '$content_ta') 
                ON DUPLICATE KEY UPDATE content_en = '$content_en', content_si = '$content_si', content_ta = '$content_ta'";
                
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Setting updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating setting: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
