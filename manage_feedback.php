<?php
header('Content-Type: application/json');
require_once 'db_config.php';

// Check if database connected successfully
if (isset($db_connection_error) && $db_connection_error !== null) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $db_connection_error]);
    exit;
}

// Auto-migrate database table for banner_url column
$res = $conn->query("SHOW COLUMNS FROM division_info LIKE 'banner_url'");
if ($res && $res->num_rows == 0) {
    $conn->query("ALTER TABLE division_info ADD COLUMN banner_url VARCHAR(255) DEFAULT NULL");
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Get single division and its staff
            $slug = $conn->real_escape_string($_GET['id']);
            $sql = "SELECT * FROM division_info WHERE slug = '$slug'";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $division = $result->fetch_assoc();
                
                // Fetch staff/officers for this division
                // Match either the division name or slug
                $div_name = $conn->real_escape_string($division['name_en']);
                $div_slug = $conn->real_escape_string($division['slug']);
                
                $staff_sql = "SELECT id, name, title, phone, email, photo_url FROM officers 
                             WHERE division = '$div_name' OR division = '$div_slug' OR (division = 'Head Office' AND '$div_slug' = 'head-office')
                             ORDER BY id ASC";
                $staff_res = $conn->query($staff_sql);
                $staff = [];
                if ($staff_res) {
                    while ($s_row = $staff_res->fetch_assoc()) {
                        // In the legacy division.html structure, title can have translations.
                        // We will format title into an array for compatibility.
                        $s_row['title'] = [
                            'en' => $s_row['title'],
                            'si' => $s_row['title'], // Fallback
                            'ta' => $s_row['title']  // Fallback
                        ];
                        $staff[] = $s_row;
                    }
                }
                
                // Format response to match legacy client-side object
                $response = [
                    "name" => [
                        "en" => $division['name_en'],
                        "si" => $division['name_si'],
                        "ta" => $division['name_ta']
                    ],
                    "location" => [
                        "en" => $division['location_en'],
                        "si" => $division['location_si'],
                        "ta" => $division['location_ta']
                    ],
                    "address" => [
                        "en" => $division['address_en'],
                        "si" => $division['address_si'],
                        "ta" => $division['address_ta']
                    ],
                    "phone" => $division['phone'],
                    "fax" => $division['fax'],
                    "email" => $division['email'],
                    "banner_url" => $division['banner_url'],
                    "logo_url" => $division['logo_url'],
                    "staff" => $staff
                ];
                
                echo json_encode(["status" => "success", "division" => $response]);
            } else {
                echo json_encode(["status" => "error", "message" => "Division not found"]);
            }
        } else {
            // Get list of all divisions
            $sql = "SELECT * FROM division_info ORDER BY id ASC";
            $result = $conn->query($sql);
            $divisions = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $divisions[] = $row;
                }
            }
            echo json_encode(["status" => "success", "divisions" => $divisions]);
        }
        break;

    case 'POST':
        // Update division details
        if (!isset($_POST['slug'])) {
            echo json_encode(["status" => "error", "message" => "Missing division slug"]);
            exit;
        }

        $slug = $conn->real_escape_string($_POST['slug']);
        $name_en = $conn->real_escape_string($_POST['name_en']);
        $name_si = $conn->real_escape_string($_POST['name_si']);
        $name_ta = $conn->real_escape_string($_POST['name_ta']);
        $location_en = $conn->real_escape_string($_POST['location_en']);
        $location_si = $conn->real_escape_string($_POST['location_si']);
        $location_ta = $conn->real_escape_string($_POST['location_ta']);
        $address_en = $conn->real_escape_string($_POST['address_en']);
        $address_si = $conn->real_escape_string($_POST['address_si']);
        $address_ta = $conn->real_escape_string($_POST['address_ta']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $fax = $conn->real_escape_string($_POST['fax']);
        $email = $conn->real_escape_string($_POST['email']);

        $banner_url = null;
        $remove_banner = isset($_POST['remove_banner']) && $_POST['remove_banner'] === '1';

        if ($remove_banner) {
            // Delete old banner image file
            $old_res = $conn->query("SELECT banner_url FROM division_info WHERE slug = '$slug'");
            if ($old_res && $old_row = $old_res->fetch_assoc()) {
                $old_banner = $old_row['banner_url'];
                if ($old_banner && file_exists($old_banner) && strpos($old_banner, 'uploads/') === 0) {
                    @unlink($old_banner);
                }
            }
        } elseif (isset($_FILES['banner'])) {
            $error = $_FILES['banner']['error'];
            if ($error === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['banner']['tmp_name'];
                $file_name = basename($_FILES['banner']['name']);
                $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
                
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $unique_name = 'banner_' . $slug . '_' . time() . '_' . $file_name;
                $dest_path = $upload_dir . $unique_name;
                
                if (move_uploaded_file($file_tmp, $dest_path)) {
                    $banner_url = $dest_path;
                    
                    // Delete the old banner image file if one exists
                    $old_res = $conn->query("SELECT banner_url FROM division_info WHERE slug = '$slug'");
                    if ($old_res && $old_row = $old_res->fetch_assoc()) {
                        $old_banner = $old_row['banner_url'];
                        if ($old_banner && file_exists($old_banner) && strpos($old_banner, 'uploads/') === 0) {
                            @unlink($old_banner);
                        }
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to save division banner."]);
                    exit;
                }
            }
        }

        $logo_url = null;
        $remove_logo = isset($_POST['remove_logo']) && $_POST['remove_logo'] === '1';

        if ($remove_logo) {
            // Delete old logo image file
            $old_res = $conn->query("SELECT logo_url FROM division_info WHERE slug = '$slug'");
            if ($old_res && $old_row = $old_res->fetch_assoc()) {
                $old_logo = $old_row['logo_url'];
                if ($old_logo && file_exists($old_logo) && strpos($old_logo, 'uploads/') === 0) {
                    @unlink($old_logo);
                }
            }
        } elseif (isset($_FILES['logo'])) {
            $error = $_FILES['logo']['error'];
            if ($error === UPLOAD_ERR_OK) {
                $file_tmp = $_FILES['logo']['tmp_name'];
                $file_name = basename($_FILES['logo']['name']);
                $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_name);
                
                $upload_dir = 'uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $unique_name = 'logo_' . $slug . '_' . time() . '_' . $file_name;
                $dest_path = $upload_dir . $unique_name;
                
                if (move_uploaded_file($file_tmp, $dest_path)) {
                    $logo_url = $dest_path;
                    
                    // Delete the old logo image file if one exists
                    $old_res = $conn->query("SELECT logo_url FROM division_info WHERE slug = '$slug'");
                    if ($old_res && $old_row = $old_res->fetch_assoc()) {
                        $old_logo = $old_row['logo_url'];
                        if ($old_logo && file_exists($old_logo) && strpos($old_logo, 'uploads/') === 0) {
                            @unlink($old_logo);
                        }
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to save division logo."]);
                    exit;
                }
            }
        }

        $sql = "UPDATE division_info SET 
                name_en = '$name_en', name_si = '$name_si', name_ta = '$name_ta',
                location_en = '$location_en', location_si = '$location_si', location_ta = '$location_ta',
                address_en = '$address_en', address_si = '$address_si', address_ta = '$address_ta',
                phone = '$phone', fax = '$fax', email = '$email'";
        
        if ($remove_banner) {
            $sql .= ", banner_url = NULL";
        } elseif ($banner_url !== null) {
            $sql .= ", banner_url = '$banner_url'";
        }

        if ($remove_logo) {
            $sql .= ", logo_url = NULL";
        } elseif ($logo_url !== null) {
            $sql .= ", logo_url = '$logo_url'";
        }
        
        $sql .= " WHERE slug = '$slug'";
                
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Division details updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating division: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
