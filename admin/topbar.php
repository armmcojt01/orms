<style>
	/* .logo {

    margin: auto;
    font-size: 20px;
    background: white;
    padding: 2px 8px;
    border-radius: 50% 50%;
    color: #000000b3;
} */
.float-left {
    float: left;
}
.logo img {
    width: 55px; /* Adjust this value to your desired width */
    height: auto; /* This ensures the aspect ratio is maintained */
  }
</style>
<nav class="navbar navbar-light fixed-top bg-primary" style="padding:0;">
  <div class="container-fluid mt-2 mb-2">
    <div class="col-lg-12">
      <div class="col-md-1 float-left" style="display: flex;">
        <div class="logo">
        <img src="assets\img\armmcicon.ico" alt="Logo" style="width: 45px; height: 45px;">
        </div>
      </div>
      <div class="col-md-7 float-left text-white">
        <h4>ARMMC Online Recruitment Management System</h4>
      </div>
      <div class="col-md-2 float-right text-white">
        <a href="ajax.php?action=logout" class="text-white"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i></a>
      </div>
    </div>
  </div>
</nav>
