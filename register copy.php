<?php include('./header.php'); ?>
<?php include('admin/db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    ARMMC Online Recruitment System
                </div>
                <div class="card-body">
                    <form action="register_process.php" id="register-form">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button class="btn btn-primary btn-block">Register</button>
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <button id="cancel-button" class="btn btn-secondary btn-block" type="button" onclick="window.location.href = 'index.php';">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#register-form').submit(function(e){
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method:'POST',
                data:$(this).serialize(),
                error: function(err) {
                    console.log(err);
                },
                success:function(response){
                    if(response == 0){
                        alert("Registration successful! You can now login.");
                        $('#register-form')[0].reset();
                        // Redirect to login page
                        window.location.href = 'loginuser.php';
                    } else {
                        alert("Registration failed. Please try again.");
                    }
                }
            });
        });
    });
</script>

</body>
</html>
