<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['login']) == 0){
  header('location:index.php');
} else {
  if(isset($_POST['updateprofile'])) {
    $name     = $_POST['fullname'];
    $mobileno = $_POST['mobilenumber'];
    $dob      = $_POST['dob'];
    $address  = $_POST['address'];
    $license  = $_POST['license'];
    $aadhaar  = $_POST['aadhaar'];
    $email    = $_SESSION['login'];

    $sql = "UPDATE tblusers SET 
              FullName = :name,
              ContactNo = :mobileno,
              dob = :dob,
              Address = :address,
              license = :license,
              aadhaar = :aadhaar,
              UpdationDate = NOW()
            WHERE EmailId = :email";

    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':license', $license, PDO::PARAM_STR);
    $query->bindParam(':aadhaar', $aadhaar, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();

    $msg = "Profile Updated Successfully";
  }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
  <title>Bike Rental Portal | My Profile</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="assets/css/owl.carousel.css">
  <link rel="stylesheet" href="assets/css/owl.transitions.css">
  <link rel="stylesheet" href="assets/css/slick.css">
  <link rel="stylesheet" href="assets/css/bootstrap-slider.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
  <style>
    .errorWrap {
      padding: 10px;
      margin: 0 0 20px 0;
      background: #fff;
      border-left: 4px solid #dd3d36;
      box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
    .succWrap {
      padding: 10px;
      margin: 0 0 20px 0;
      background: #fff;
      border-left: 4px solid #5cb85c;
      box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    }
  </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Your Profile</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Profile</li>
      </ul>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>

<?php
$useremail = $_SESSION['login'];
$sql = "SELECT * FROM tblusers WHERE EmailId = :useremail";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0) {
  foreach($results as $result) {
?>
<section class="user_profile inner_pages">
  <div class="container">
    <div class="user_profile_info gray-bg padding_4x4_40">
      <div class="upload_user_logo"> <img src="assets/images/dealer-logo.jpg" alt="image"> </div>
      <div class="dealer_info">
        <h5><?php echo htmlentities($result->FullName);?></h5>
       
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-3">
        
      </div>
      <div class="col-md-6 col-sm-8">
        <div class="profile_wrap">
          <style>

.col-md-6 col-sm-8{
	background-color: black;
}

</style>
          <h5 class="uppercase underline">Profile Settings</h5>
          <?php if($msg){ ?><div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div><?php } ?>
          <form method="post">
            <div class="form-group">
              <label class="control-label">Reg Date -</label>
              <?php echo htmlentities($result->RegDate); ?>
            </div>
            <?php if($result->UpdationDate != "") { ?>
            <div class="form-group">
              <label class="control-label">Last Update at -</label>
              <?php echo htmlentities($result->UpdationDate); ?>
            </div>
            <?php } ?>
            <div class="form-group">
              <label class="control-label">Full Name</label>
              <input class="form-control white_bg" name="fullname" value="<?php echo htmlentities($result->FullName);?>" type="text" required>
            </div>
            <div class="form-group">
              <label class="control-label">Email Address</label>
              <input class="form-control white_bg" value="<?php echo htmlentities($result->EmailId);?>" type="email" readonly>
            </div>
            <div class="form-group">
              <label class="control-label">Phone Number</label>
              <input class="form-control white_bg" name="mobilenumber" value="<?php echo htmlentities($result->ContactNo);?>" type="text" required>
            </div>
            <div class="form-group">
              <label class="control-label">Date of Birth</label>
              <input class="form-control white_bg" name="dob" value="<?php echo htmlentities($result->dob);?>" type="date">
            </div>
            <div class="form-group">
              <label class="control-label">Your Address</label>
              <textarea class="form-control white_bg" name="address" rows="4"><?php echo htmlentities($result->Address);?></textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Aadhaar Number</label>
              <input class="form-control white_bg" name="aadhaar" value="<?php echo htmlentities($result->aadhaar);?>" type="text">
            </div>
            <div class="form-group">
              <label class="control-label">License Number</label>
              <input class="form-control white_bg" name="license" value="<?php echo htmlentities($result->license);?>" type="text">
            </div>
            <div class="form-group">
              <button type="submit" name="updateprofile" class="btn">Save Changes <span class="angle_arrow"><i class="fa fa-angle-right"></i></span></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } } ?>

<!-- Footer -->
<?php include('includes/footer.php'); ?>

<!-- Back to top -->
<div id="back-top" class="back-top">
  <a href="#top"><i class="fa fa-angle-up"></i></a>
</div>

<!-- Login/Register/Forgot Modals -->
<?php include('includes/login.php'); ?>
<?php include('includes/registration.php'); ?>
<?php include('includes/forgotpassword.php'); ?>

<!-- JS Files -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
<?php } ?>
