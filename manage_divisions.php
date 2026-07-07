<?php
header('Content-Type: application/json');

// JSON කැඩෙන නිසා error screen එකට පෙන්වීම නවත්වන්න (Production Safe)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require_once 'db_config.php';

try {
    // Auto-migrate block
    try {
        $res = $conn->query("SHOW COLUMNS FROM division_info LIKE 'banner_url'");
        if ($res && $res->num_rows == 0) {
            $conn->query("ALTER TABLE division_info ADD COLUMN banner_url VARCHAR(255) DEFAULT NULL");
        }
    } catch (Exception $e) {
        // Permission නැත්නම් නිහඬව මඟහරින්න
    }
} catch (mysqli_sql_exception $e) {
    echo json_encode([
        "status" => "error", 
        "message" => "Database Query/Connection Error: " . $e->getMessage()
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Prepared Statement එකක් මඟින් ආරක්ෂිතව තේරීම
            $slug = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM division_info WHERE slug = ?");
            $stmt->bind_param("s", $slug);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $division = $result->fetch_assoc();
                $stmt->close();
                
                $div_name = $division['name_en'];
                $div_slug = $division['slug'];
                
                // Officers ලා තේරීම සඳහාත් Prepared Statement එකක්
                $staff_stmt = $conn->prepare("SELECT id, name, title, phone, email, photo_url FROM officers 
                                             WHERE division = ? OR division = ? OR (division = 'Head Office' AND ? = 'head-office')
                                             ORDER BY id ASC");
                $staff_stmt->bind_param("sss", $div_name, $div_slug, $div_slug);
                $staff_stmt->execute();
                $staff_res = $staff_stmt->get_result();
                
                $staff = [];
                if ($staff_res) {
                    while ($s_row = $staff_res->fetch_assoc()) {
                        $s_row['title'] = [
                            'en' => $s_row['title'],
                            'si' => $s_row['title'], 
                            'ta' => $s_row['title']  
                        ];
                        $staff[] = $s_row;
                    }
                }
                $staff_stmt->close();
                
                $response = [
                    "name" => ["en" => $division['name_en'], "si" => $division['name_si'], "ta" => $division['name_ta']],
                    "location" => ["en" => $division['location_en'], "si" => $division['location_si'], "ta" => $division['location_ta']],
                    "address" => ["en" => $division['address_en'], "si" => $division['address_si'], "ta" => $division['address_ta']],
                    "phone" => $division['phone'],
                    "fax" => $division['fax'],
                    "email" => $division['email'],
                    "banner_url" => $division['banner_url'],
                    "logo_url" => $division['logo_url'],
                    "staff" => $staff
                ];
                
                echo json_encode(["status" => "success", "division" => $response]);
            } else {
                if(isset($stmt)) $stmt->close();
                echo json_encode(["status" => "error", "message" => "Division not found"]);
            }
        } else {
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
        if (!isset($_POST['slug'])) {
            echo json_encode(["status" => "error", "message" => "Missing division slug"]);
            exit;
        }

        $slug = $_POST['slug'];
        $name_en = $_POST['name_en'];
        $name_si = $_POST['name_si'];
        $name_ta = $_POST['name_ta'];
        $location_en = $_POST['location_en'];
        $location_si = $_POST['location_si'];
        $location_ta = $_POST['location_ta'];
        $address_en = $_POST['address_en'];
        $address_si = $_POST['address_si'];
        $address_ta = $_POST['address_ta'];
        $phone = $_POST['phone'];
        $fax = $_POST['fax'];
        $email = $_POST['email'];

        // ඩේටාබේස් එකේ තියෙන දැනට පවතින පින්තූර වල URLs ලබාගැනීම
        $current_banner = null;
        $current_logo = null;
        $old_stmt = $conn->prepare("SELECT banner_url, logo_url FROM division_info WHERE slug = ?");
        $old_stmt->bind_param("s", $slug);
        $old_stmt->execute();
        $old_res = $old_stmt->get_result();
        if ($old_res && $old_row = $old_res->fetch_assoc()) {
            $current_banner = $old_row['banner_url'];
            $current_logo = $old_row['logo_url'];
        }
        $old_stmt->close();

        $upload_dir = 'uploads/';
        // OpenShift/Linux වලදී crash වීම වැළැක්වීමට safe directory check එකක්
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0775, true);
        }

        // --- BANNER UPLOAD LOGIC ---
        $banner_url = $current_banner;
        $remove_banner = isset($_POST['remove_banner']) && $_POST['remove_banner'] === '1';

        if ($remove_banner) {
            if ($current_banner && file_exists($current_banner) && strpos($current_banner, 'uploads/') === 0) {
                @unlink($current_banner);
            }
            $banner_url = null;
        } elseif (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['banner']['name']));
            $unique_name = 'banner_' . $slug . '_' . time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;
            
            if (move_uploaded_file($_FILES['banner']['tmp_name'], $dest_path)) {
                if ($current_banner && file_exists($current_banner) && strpos($current_banner, 'uploads/') === 0) {
                    @unlink($current_banner);
                }
                $banner_url = $dest_path;
            }
        }

        // --- LOGO UPLOAD LOGIC ---
        $logo_url = $current_logo;
        $remove_logo = isset($_POST['remove_logo']) && $_POST['remove_logo'] === '1';

        if ($remove_logo) {
            if ($current_logo && file_exists($current_logo) && strpos($current_logo, 'uploads/') === 0) {
                @unlink($current_logo);
            }
            $logo_url = null;
        } elseif (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['logo']['name']));
            $unique_name = 'logo_' . $slug . '_' . time() . '_' . $file_name;
            $dest_path = $upload_dir . $unique_name;
            
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $dest_path)) {
                if ($current_logo && file_exists($current_logo) && strpos($current_logo, 'uploads/') === 0) {
                    @unlink($current_logo);
                }
                $logo_url = $dest_path;
            }
        }

        // Prepared Statement එකක් මඟින් සියලුම විස්තර ආරක්ෂිතව Update කිරීම
        $update_query = "UPDATE division_info SET 
                        name_en = ?, name_si = ?, name_ta = ?,
                        location_en = ?, location_si = ?, location_ta = ?,
                        address_en = ?, address_si = ?, address_ta = ?,
                        phone = ?, fax = ?, email = ?, banner_url = ?, logo_url = ?
                        WHERE slug = ?";
                        
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param(
            "sssssssssssssss", 
            $name_en, $name_si, $name_ta,
            $location_en, $location_si, $location_ta,
            $address_en, $address_si, $address_ta,
            $phone, $fax, $email, $banner_url, $logo_url, $slug
        );
                
        if ($update_stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Division details updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating division: " . $update_stmt->error]);
        }
        $update_stmt->close();
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
