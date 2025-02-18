<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$database = "recruitment_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM recruitment_status";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Status Label</th>
            </tr>";
   
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['status_label']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No recruitment statuses found.";
}

if (isset($_GET['email']) && isset($_GET['position_id'])) {
    $email = $_GET['email'];
    $position_id = $_GET['position_id'];

    $stmt = $conn->prepare("
    SELECT a.*, r.status_label, v.position AS position_name
    FROM application a
    LEFT JOIN recruitment_status r ON a.process_id = r.id
    LEFT JOIN vacancy v ON a.position_id = v.id
    WHERE a.email = ? AND a.position_id = ?
    ");

    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("si", $email, $position_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $applicant = $result->fetch_assoc();

        $firstname = $applicant['firstname'];
        $lastname = $applicant['lastname'];
        $cover_letter = $applicant['cover_letter'];
        $message = $applicant['message'];
        $status_label = $applicant['status_label'];
        $position_name = $applicant['position_name'];

        echo "Application received from: " . htmlspecialchars($email);

        sendStatusUpdateEmail($email, $status_label, $message, $firstname, $lastname, $position_name);
    } else {
        echo "No applicant found with this email or position.";
        exit;
    }
} else {
    echo "No email or position_id was passed.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $position_id = $_POST['position_id'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $cover_letter = $_POST['cover_letter'];
    $process_id = $_POST['process_id'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("UPDATE application SET
                position_id = ?,
                lastname = ?,
                firstname = ?,
                middlename = ?,
                gender = ?,
                email = ?,
                contact = ?,
                address = ?,
                message = ?,
                cover_letter = ?,
                process_id = ?
              WHERE id = ?");
    $stmt->bind_param("issssssssiii", $position_id, $lastname, $firstname, $middlename, $gender, $email, $contact, $address, $message, $cover_letter, $process_id, $id);

    if ($stmt->execute()) {
        $status_stmt = $conn->prepare("SELECT status_label FROM recruitment_status WHERE id = ?");
        $status_stmt->bind_param("i", $process_id);
        $status_stmt->execute();
        $status_result = $status_stmt->get_result();
        $status_label = ($status_result->num_rows > 0) ? $status_result->fetch_assoc()['status_label'] : "Unknown";

        $position_stmt = $conn->prepare("SELECT position AS position_name FROM vacancy WHERE id = ?");
        $position_stmt->bind_param("i", $position_id);
        $position_stmt->execute();
        $position_result = $position_stmt->get_result();
        $position_name = ($position_result->num_rows > 0) ? $position_result->fetch_assoc()['position_name'] : "Unknown";

        sendStatusUpdateEmail($email, $status_label, $message, $firstname, $lastname, $position_name);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
}

function sendStatusUpdateEmail($email, $status_label, $message, $firstname, $lastname, $position_name) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'angelodesabille09@gmail.com';
        $mail->Password = 'zkmd nquv chps tlrm';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('angelodesabille09@gmail.com', 'ARMMC HR');
        $mail->addAddress($email);
       
        $mail->isHTML(true);
        $mail->Subject = 'Application Status Update';
        $mail->Body = "<p>Dear Applicant, <h1>$firstname $lastname</h1></p>
                        <p>Your application for: <strong>$position_name</strong></p>
                        <p>has been evaluated and reviewed <br>
                        STATUS: <strong>$status_label</strong>.</p>
                        <p>$message</p>
                        <br>
                        <p>Best regards,<br>Company HR Team</p>";
       
        $mail->send();
       
        header("Location: index.php?page=applications");
        exit;

    } catch (Exception $e) {
        error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
    }
}

$conn->close();
?>
