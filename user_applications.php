<?php include('db_connect.php'); ?>

<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if login_user_id session variable is set
if (!isset($_SESSION['login_user_id'])) {
    // Redirect user to login page if not logged in
    header('Location: loginuser.php');
    exit();
}

// Get the login_user_id
$login_user_id = $_SESSION['loginuser_id'];

// Fetch applications submitted by the logged-in user
$qry = $conn->prepare("SELECT a.*, v.position FROM application a INNER JOIN vacancy v ON v.id = a.position_id WHERE a.user_id = ?");
$qry->bind_param("i", $loginuser_id);
$qry->execute();
$result = $qry->get_result();

// Fetch positions for filtering
$positions = $conn->query("SELECT * FROM vacancy");
while($row = $positions->fetch_assoc()){
    $pos[$row['id']] = $row['position'];
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <!-- Table Panel -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-12">
                                <span><large><b>Application List</b></large></span>
                                <button class="btn btn-sm btn-block btn-primary btn-sm col-md-2 float-right" type="button" id="new_application"><i class="fa fa-plus"></i> New Applicant</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Application Table -->
                        <table class="table table-bordered table-hover">
                            <colgroup>
                                <col width="10%">
                                <col width="30%">
                                <col width="20%">
                                <col width="30%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="text-center">Number</th>
                                    <th class="text-center">Applicant Information</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                while($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="">
                                        <p>Name : <b><?php echo ucwords($row['lastname'].', '.$row['firstname'].' '.$row['middlename']) ?></b></p>
                                        <p>Applied for : <b><?php echo $row['position'] ?></b></p>
                                    </td>
                                    <td class="text-center">
                                        <!-- Display application status -->
                                        <?php echo $row['status'] ?>
                                    </td>
                                    <td class="text-center">
                                        <!-- Add action buttons here -->
                                        <!-- Example: <button class="btn btn-sm btn-primary view_application" type="button" data-id="<?php echo $row['id'] ?>" >View</button> -->
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
