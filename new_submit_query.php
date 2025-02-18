<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "recruitment_db";

// Create connection
$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $position_id = $_POST['position'];  // Assuming this field exists

    // Initialize data string
    $data = " lastname = '$lastname' ";
    $data .= ", firstname = '$firstname' ";
    $data .= ", middlename = '$middlename' ";
    $data .= ", address = '$address' ";
    $data .= ", contact = '$contact' ";
    $data .= ", email = '$email' ";
    $data .= ", gender = '$gender' ";
    
    // Handle cover letter if exists (you can adjust this part if needed)
    if (isset($_POST['cover_letter'])) {
        $cover_letter = $_POST['cover_letter'];
        $data .= ", cover_letter = '" . htmlentities(str_replace("'", "&#x2019;", $cover_letter)) . "' ";
    }

    // Position applied for (department/item no.)
    $data .= ", position_id = '$position_id' ";

    // Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['tmp_name'] != '') {
        // Generate unique file name
        $fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['resume']['name'];

        // Move uploaded file to the server directory
        $move = move_uploaded_file($_FILES['resume']['tmp_name'], 'assets/resume/' . $fname);
        
        if ($move) {
            $data .= ", resume_path = '$fname' ";
        } else {
            echo "Error uploading file!";
            exit;
        }
    }

    // If there's an ID (update), otherwise insert
    if (empty($id)) {
        // INSERT Query
        $save = $con->query("INSERT INTO application SET " . $data);
    } else {
        // UPDATE Query
        $save = $con->query("UPDATE application SET " . $data . " WHERE id = $id");
    }

    if ($save) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $con->error;
    }
}
?>
