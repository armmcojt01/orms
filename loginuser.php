<?php include('./header.php'); ?>
<?php include('admin/db_connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ARMMC | Recruitment Management System</title>
<link rel="icon" type="image/png" href="armmcicon.ico">
<?php include('./header.php'); ?>
<?php include('admin/db_connect.php'); ?>
</head>
<style>
	body {
		width: 100%;
	    height: calc(100%);
	}

	main#main {
		width: 100%;
		height: calc(100%);
		background: white;
	}

	#login-right {
		position: absolute;
		right: 0;
		width: 40%;
		height: calc(100%);
		background: white;
		display: flex;
		align-items: center;
	}

	#login-left {
		position: absolute;
		left: 0;
		width: 60%;
		height: calc(100%);
		background: #59b6ec61;
		display: flex;
		align-items: center;
		background: url(admin/assets/img/recruitment-cover.png);
	    background-repeat: no-repeat;
	    background-size: cover;
	}

	#login-right .card {
		margin: auto;
		z-index: 1;
	}

	.logo-container {
		display: flex;
		align-items: center;
		margin-bottom: 20px;
	}

	.logo img {
		width: 120px;
		height: 120px;
		margin-right: 20px;
	}

	.content p {
		font-size: medium;
		margin: 0;
	}

	div#login-right::before {
	    content: "";
	    position: absolute;
	    top: 0;
	    left: 0;
	    width: calc(100%);
	    height: calc(100%);
	    background: #000000e0;
	}
</style>


<body>
    <main id="main" class="bg-dark">
        <!-- Login form -->
        <div id="login-left"></div>
        <div id="login-right">
            <div class="card col-md-8">
                <div class="container">
                    <div class="logo-container">
                        <div class="logo">
                            <img src="admin\assets\img\armmcfinal.png" alt="Your Logo">
                        </div>
                        <div class="content">
                            <p>Welcome to ARMMC Online Recruitment Management System</p>
                        </div>
                    </div>
                    <h2 class="text-center mt-4">Applicant Login</h2>
                    <form id="user-login-form">
                        <div class="form-group">
                            <label for="username" class="control-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button>
                        <!-- Register button -->
                        <a href="register.php" class="btn btn-sm btn-block btn-outline-primary mt-3">Register</a>
                    </form>
                    <!-- Footer section -->
                    <footer class="main-footer" style="margin-left: 0px;">
                        <p>
                            <div class="text-center">
                                <strong style="font-size: smaller;">Copyright &copy; 
                                    <?php echo date("Y"); ?> <a href="http://localhost/ORMS/index.php">ORMS by IMISS</a>.
                                </strong>
                                <p style="font-size: smaller;">All rights reserved.</p>
                            </div>
                        </p>
                    </footer>
                </div>
            </div>
        </div>
    </main>
    <!-- Add your JavaScript code here -->
    <script>
        $(document).ready(function() {
            $('#user-login-form').submit(function(e){
                e.preventDefault();
                $('#user-login-form button[type="button"]').attr('disabled',true).html('Logging in...');
                if($(this).find('.alert-danger').length > 0 )
                    $(this).find('.alert-danger').remove();
                $.ajax({
                    url:'user_login_process.php',
                    method:'POST',
                    data:$(this).serialize(),
                    error:err=>{
                        console.log(err);
                        $('#user-login-form button[type="button"]').removeAttr('disabled').html('Login');
                    },
                    success:function(resp){
                             if(resp == 1){
                                  location.href ='http://localhost/ORMS/user_applications';
                                    } else {
                                            $('#user-login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
                                            $('#user-login-form button[type="button"]').removeAttr('disabled').html('Login');
                                    }
                    }
                    })
                });
            });

    </script>
    
</body>
</html>