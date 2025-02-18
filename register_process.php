<?php
include('admin/db_connect.php');

if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM loginuser WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        echo 0; // User already exists
        exit;
    } else {
        // Insert user data into the loginuser table
        $stmt = $conn->prepare("INSERT INTO loginuser (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if($stmt->execute()){
            echo 1; // Registration successful
            exit;
        } else {
            // Registration failed
            echo 2;
            exit;
        }
    }
} else {
    // Invalid request
    echo -1;
    exit;
}
?>
