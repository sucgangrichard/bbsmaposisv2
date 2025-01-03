


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
    $newEmail = $_POST['email'];
    // Save the new email to the database or configuration file
    $sql = "UPDATE email_settings SET email = :email WHERE id = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $newEmail]);
    echo "Email updated successfully!";
}

// Fetch the current email address
$sql = "SELECT email FROM email_settings WHERE id = 1";
$stmt = $pdo->query($sql);
$currentEmail = $stmt->fetch(PDO::FETCH_ASSOC)['email'];
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
