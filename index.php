
<?php
include_once "ui/conndb.php";
session_start();

date_default_timezone_set("Asia/Manila");

if (isset($_POST['btn_login'])) {


  $username = $_POST['txt_username'];
  $password = $_POST['txt_password'];

  $select = $pdo->prepare("select * from tbl_user where username='$username' AND userpassword='$password'");
  $select->execute();


  $row = $select->fetch(PDO::FETCH_ASSOC);


  if (is_array($row)) {




    if ($row['username'] == $username and $row['userpassword'] == $password and $row['role'] == "Admin") {

     

      $_SESSION['status']="Login Success By Admin";
      
      $_SESSION['status_code']="success";
      // Update the login time
      $update = $pdo->prepare("UPDATE tbl_user SET logintime = NOW() WHERE username = :username");
      $update->bindParam(':username', $username);
      $update->execute();

      header('refresh: 1;ui/dashboard.php');

$_SESSION['user_id']=$row['user_id'];
$_SESSION['username'] = $row['username'];
$_SESSION['userpassword'] = $row['userpassword'];
$_SESSION['role'] = $row['role'];






    }else if($row['username'] == $username and $row['userpassword'] == $password and $row['role'] == "User"){


      $_SESSION['status']="Login Success By User";
      $_SESSION['status_code']="success";

      header('refresh: 3;ui/userdine_in.php');

      $_SESSION['user_id']=$row['user_id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['userpassword'] = $row['userpassword'];
      $_SESSION['role'] = $row['role'];


    }






  } else {



    // echo $success = "Wrong Email or Password";

    $_SESSION['status']="Wrong Username or Password";
    $_SESSION['status_code']="error";






  }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel | Login Page</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><img src="./ui/iconspng/addon.png" alt="Admin Panel Logo" class="img-fluid" style="max-width: 100px;">PANEL</a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="txt_username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-circle"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="txt_password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="btn_login">Login</button>
          </div>
        </div>
      </form>
      <div class="social-auth-links text-center mb-3">
        
      </div>
      
    </div>
  </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="plugins/toastr/toastr.min.js"></script>
</body>
</html>

<?php
  if(isset($_SESSION['status']) && $_SESSION['status']!='')
 
  {

?>
<script>

$(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 5000
     
    });

  
      Toast.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<div style="text-align: center;margin-top:0.6em"><?php echo $_SESSION['status'];?></div>',
        customClass: {
            popup: 'small-swal'
        }
      })
    });



</script>
<style>
.small-swal {
    width: 250px !important;
    padding: 10px !important;
}
</style>

<?php
unset($_SESSION['status']);
  }
  ?>
