<?php
include('admin/db_connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch user data from the database
    $stmt = $conn->prepare("SELECT * FROM loginuser WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Passwords match, proceed with login
            $_SESSION['login_id'] = $row['id'];
            echo 1; // Success response
        } else {
            // Incorrect password
            echo 0; // Incorrect username or password
        }
    } else {
        // User not found
        echo 0; // Incorrect username or password
    }
}
?>
