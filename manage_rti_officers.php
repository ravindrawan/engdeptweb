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
        // List RTI officers
        $sql = "SELECT id, role_type, name_en, name_si, name_ta, designation_en, designation_si, designation_ta, phone, email, address_en, address_si, address_ta FROM rti_officers ORDER BY role_type ASC, id ASC";
        $result = $conn->query($sql);
        $officers = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $officers[] = $row;
            }
            echo json_encode(["status" => "success", "officers" => $officers]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database Query Error: " . $conn->error]);
        }
        break;

    case 'POST':
        // Add or Update RTI officer
        if (!isset($_POST['role_type']) || !isset($_POST['name_en']) || !isset($_POST['designation_en']) || !isset($_POST['phone']) || !isset($_POST['email'])) {
            echo json_encode(["status" => "error", "message" => "Missing required fields (role_type, name_en, designation_en, phone, email)"]);
            exit;
        }
        
        $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : 0;
        $role_type = $conn->real_escape_string($_POST['role_type']);
        $name_en = $conn->real_escape_string($_POST['name_en']);
        $name_si = isset($_POST['name_si']) && !empty($_POST['name_si']) ? $conn->real_escape_string($_POST['name_si']) : null;
        $name_ta = isset($_POST['name_ta']) && !empty($_POST['name_ta']) ? $conn->real_escape_string($_POST['name_ta']) : null;
        
        $designation_en = $conn->real_escape_string($_POST['designation_en']);
        $designation_si = isset($_POST['designation_si']) && !empty($_POST['designation_si']) ? $conn->real_escape_string($_POST['designation_si']) : null;
        $designation_ta = isset($_POST['designation_ta']) && !empty($_POST['designation_ta']) ? $conn->real_escape_string($_POST['designation_ta']) : null;
        
        $phone = $conn->real_escape_string($_POST['phone']);
        $email = $conn->real_escape_string($_POST['email']);
        
        $address_en = isset($_POST['address_en']) && !empty($_POST['address_en']) ? $conn->real_escape_string($_POST['address_en']) : null;
        $address_si = isset($_POST['address_si']) && !empty($_POST['address_si']) ? $conn->real_escape_string($_POST['address_si']) : null;
        $address_ta = isset($_POST['address_ta']) && !empty($_POST['address_ta']) ? $conn->real_escape_string($_POST['address_ta']) : null;

        if ($id > 0) {
            // Update existing RTI officer
            $sql = "UPDATE rti_officers SET 
                        role_type = '$role_type', 
                        name_en = '$name_en', 
                        name_si = " . ($name_si ? "'$name_si'" : "NULL") . ", 
                        name_ta = " . ($name_ta ? "'$name_ta'" : "NULL") . ", 
                        designation_en = '$designation_en', 
                        designation_si = " . ($designation_si ? "'$designation_si'" : "NULL") . ", 
                        designation_ta = " . ($designation_ta ? "'$designation_ta'" : "NULL") . ", 
                        phone = '$phone', 
                        email = '$email', 
                        address_en = " . ($address_en ? "'$address_en'" : "NULL") . ", 
                        address_si = " . ($address_si ? "'$address_si'" : "NULL") . ", 
                        address_ta = " . ($address_ta ? "'$address_ta'" : "NULL") . " 
                    WHERE id = $id";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "RTI Officer updated successfully", "id" => $id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating RTI officer: " . $conn->error]);
            }
        } else {
            // Insert new RTI officer
            $sql = "INSERT INTO rti_officers (role_type, name_en, name_si, name_ta, designation_en, designation_si, designation_ta, phone, email, address_en, address_si, address_ta) 
                    VALUES (
                        '$role_type', 
                        '$name_en', 
                        " . ($name_si ? "'$name_si'" : "NULL") . ", 
                        " . ($name_ta ? "'$name_ta'" : "NULL") . ", 
                        '$designation_en', 
                        " . ($designation_si ? "'$designation_si'" : "NULL") . ", 
                        " . ($designation_ta ? "'$designation_ta'" : "NULL") . ", 
                        '$phone', 
                        '$email', 
                        " . ($address_en ? "'$address_en'" : "NULL") . ", 
                        " . ($address_si ? "'$address_si'" : "NULL") . ", 
                        " . ($address_ta ? "'$address_ta'" : "NULL") . "
                    )";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "RTI Officer added successfully", "id" => $conn->insert_id]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error adding RTI officer: " . $conn->error]);
            }
        }
        break;

    case 'DELETE':
        // Delete RTI officer (using query param ?id=X)
        if (!isset($_GET['id'])) {
             echo json_encode(["status" => "error", "message" => "Missing officer ID"]);
             exit;
        }
        $id = intval($_GET['id']);

        $sql = "DELETE FROM rti_officers WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "RTI Officer deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting RTI officer: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Method not allowed"]);
        break;
}

if ($conn) $conn->close();
?>
