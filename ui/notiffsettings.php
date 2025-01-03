


<?php
include_once "conndb.php";
session_start();
if($_SESSION['username']==""  OR $_SESSION['role']=="User"){

  header('location:../index.php');
  
  }


  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }else{
  
    include_once'headeruser.php';
  }

  


// Include database connection or configuration file


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['email'])) {
      $newEmail = $_POST['email'];
      $sql = "UPDATE email_settings SET email = :email WHERE id = 1";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['email' => $newEmail]);
      echo "Email updated successfully!";
  }

  if (isset($_POST['interval']) && isset($_POST['interval_unit'])) {
      $intervalValue = $_POST['interval'];
      $intervalUnit = $_POST['interval_unit'];
      $sql = "INSERT INTO notification_settings (id, interval_value, interval_unit) VALUES (1, :interval_value, :interval_unit)
              ON DUPLICATE KEY UPDATE interval_value = :interval_value, interval_unit = :interval_unit";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(['interval_value' => $intervalValue, 'interval_unit' => $intervalUnit]);
      echo "Notification interval updated successfully!";
  }
}

// Fetch the current email address
$sql = "SELECT email FROM email_settings WHERE id = 1";
$stmt = $pdo->query($sql);
$currentEmail = $stmt->fetch(PDO::FETCH_ASSOC)['email'];

// Fetch the current notification interval
$sql = "SELECT interval_value, interval_unit FROM notification_settings WHERE id = 1";
$stmt = $pdo->query($sql);
$intervalData = $stmt->fetch(PDO::FETCH_ASSOC);
$currentIntervalValue = $intervalData['interval_value'];
$currentIntervalUnit = $intervalData['interval_unit'];

// Return the interval in JSON format if requested via AJAX
if (isset($_GET['ajax']) && $_GET['ajax'] == 'true') {
  $intervalInSeconds = ($currentIntervalUnit == 'minutes') ? $currentIntervalValue * 60 : $currentIntervalValue;
  echo json_encode(['intervalInSeconds' => $intervalInSeconds]);
  exit;
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Orders</h1> -->
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li> -->
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
        

        <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">Notification Settings</h5>
            </div>
            <div class="card-body">
            <!-- <h1>Change Notification Email</h1> -->
            <form method="POST" action="">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($currentEmail); ?>" required>
        </div>
        <button type="submit"class="btn btn-light">Save Changes</button>
    </form>
            
    <hr>

     <!-- New form for setting time interval -->
    <form method="POST" action="">
    <div class="form-group">
        <label for="interval">Notification Interval:</label>
        <input type="number" id="interval" name="interval" value="<?php echo htmlspecialchars($currentIntervalValue); ?>" min="1" required>
        <select id="interval_unit" name="interval_unit" required>
            <option value="seconds" <?php if ($currentIntervalUnit == 'seconds') echo 'selected'; ?>>Seconds</option>
            <option value="minutes" <?php if ($currentIntervalUnit == 'minutes') echo 'selected'; ?>>Minutes</option>
        </select>
    </div>
    <button type="submit" class="btn btn-light">Save Changes</button>
    </form>
            
            <hr>
        
            </div>
          </div>
     

       
        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php

include_once "footer.php";


?>
