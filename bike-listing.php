<?php
session_start();
include('includes/config.php');
error_reporting(0);

$limit = 6; // Bikes per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Query to get total bikes count
$sql = "SELECT COUNT(id) as total FROM tblvehicles";
$query = $dbh->prepare($sql);
$query->execute();
$total_results = $query->fetch(PDO::FETCH_OBJ)->total;
$total_pages = ceil($total_results / $limit);

// Query to fetch bike details with pagination
$sql = "SELECT tblvehicles.*, tblbrands.BrandName FROM tblvehicles 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        LIMIT $start, $limit";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Bike Rental | Bike Listing</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/styles.css">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
</head>
<body>
<?php include('includes/header.php'); ?>

<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="result-sorting-wrapper">
          <p><span><?php echo htmlentities($total_results); ?> Bikes Available</span></p>
        </div>
        
        <?php if ($query->rowCount() > 0) {
          foreach ($results as $result) { ?>
           
                
                
              </div>
            </div>
          <?php } 
        } else {
          echo "<p>No bikes available.</p>";
        } ?>
        
        <!-- Pagination -->
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
              
                <a class="page-link" href="bike-listing.php?page=<?php echo $i; ?>">  </a>
              </li>
            <?php } ?>
          </ul>
        </nav>
      </div>
      
      <!-- Sidebar -->
      <aside class="col-md-3">
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-filter"></i> Find Your Bike</h5>
          </div>
          <div class="sidebar_filter">
            <form action="search-carresult.php" method="post">
              <div class="form-group select">
                <select class="form-control" name="brand">
                  <option>Select Brand</option>
                  <?php 
                  $sql = "SELECT * FROM tblbrands";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $brands = $query->fetchAll(PDO::FETCH_OBJ);
                  foreach ($brands as $brand) {
                    echo "<option value='{$brand->id}'>{$brand->BrandName}</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group select">
                <select class="form-control" name="fueltype">
                  <option>Select Fuel Type</option>
                  <option value="Petrol">Petrol</option>
                  <option value="Diesel">Diesel</option>
                  <option value="CNG">CNG</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block">Search Bike</button>
              </div>
            </form>
          </div>
        </div>

      </aside>
    </div>
  </div>
</section>

<?php include('includes/footer.php'); ?>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
