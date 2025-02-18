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

$firstname = "";
$lastname = "";
$position_name = "";

if (isset($_GET['email'])) {
    $email = $_GET['email']; 
    $position_id = $_GET['position_id'];
    
    $stmt = $conn->prepare("
        SELECT a.*, r.status_label, v.position AS position_name
        FROM application a
        LEFT JOIN recruitment_status r ON a.process_id = r.id
        LEFT JOIN vacancy v ON a.position_id = v.id
        WHERE a.email = ? AND a.position_id = ?
    ");

    $stmt->bind_param("si", $email, $position_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $applicant = $result->fetch_assoc();

        $firstname = $applicant['firstname'];
        $lastname = $applicant['lastname'];
        $position_name = $applicant['position_name'];

        echo "Application received from: " . htmlspecialchars($email);

        sendStatusUpdateEmail($email, $firstname, $lastname, $position_name);
    } else {
        echo "No applicant found with this email or position.";
        exit;
    }
} else {
    echo "No email was passed.";
}

function sendStatusUpdateEmail($email, $firstname, $lastname, $position_name) {
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
        $mail->Subject = "Application Submitted - ARMMC";
        $mail->Body = "
                        <h1>Good day, $firstname $lastname!</h1>
                        <p>Your application for the position <b>" . strtoupper($position_name) . "</b> has been successfully submitted.</p>
                        <p>Name: <b>$firstname $lastname</b></p>
                        <p>Please keep your lines open for the next steps in the process. Stay safe!</p>
                        <br>
                        <p>Thank you,</p>
                        <p>ARMMC</p>
                    ";
    
        $mail->send();
       
        header("Location: index.php");
        exit;

    } catch (Exception $e) {
        error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
    }
}

$conn->close();
?>
