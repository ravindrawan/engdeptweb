<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'db_connect.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

// === CREATE TABLE IF NOT EXISTS ===
$conn->query("CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(200) DEFAULT '',
    rating TINYINT DEFAULT 0,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// === ADD FEEDBACK ===
if ($action === 'add') {
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $rating  = intval($_POST['rating'] ?? 0);
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'Name and message are required.']);
        exit;
    }
    if ($rating < 0 || $rating > 5) $rating = 0;

    $stmt = $conn->prepare("INSERT INTO feedback (name, email, rating, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name, $email, $rating, $message);
    if ($stmt->execute()) {

        // === SEND EMAIL NOTIFICATION ===
        $to      = 'info@nwpeng.gov.lk';
        $subject = 'New Feedback Received - NWP Engineering Website';

        // Build star display
        $stars = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);

        $body  = "=== New Feedback / Suggestion ===\n\n";
        $body .= "Name    : $name\n";
        $body .= "Email   : " . ($email ?: 'Not provided') . "\n";
        $body .= "Rating  : $stars ($rating/5)\n";
        $body .= "Date    : " . date('Y-m-d H:i:s') . "\n\n";
        $body .= "--- Message ---\n";
        $body .= "$message\n\n";
        $body .= "-------------------------------\n";
        $body .= "Sent from NWP Engineering Department Website\n";

        $headers  = "From: NWP Website <noreply@nwpeng.gov.lk>\r\n";
        $headers .= "Reply-To: " . ($email ?: 'noreply@nwpeng.gov.lk') . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send email (won't block response if mail server is unavailable)
        @mail($to, $subject, $body, $headers);

        echo json_encode(['status' => 'success', 'message' => 'Feedback saved.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error.']);
    }
    $stmt->close();
    exit;
}

// === LIST FEEDBACK (admin use) ===
if ($action === 'list') {
    $result = $conn->query("SELECT * FROM feedback ORDER BY submitted_at DESC");
    $rows = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    echo json_encode(['status' => 'success', 'feedback' => $rows]);
    exit;
}

// === DELETE FEEDBACK ===
if ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
    $stmt->close();
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Unknown action.']);
