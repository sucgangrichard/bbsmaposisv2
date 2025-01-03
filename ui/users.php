<?php

include_once 'conndb.php';
session_start();


if($_SESSION['username']=="" OR $_SESSION['role']=="User"){

  header('location:../index.php');
  
  }


  if($_SESSION['role']=="Admin" ){

    include_once "header.php";

    
  }else{

    include_once "headeruser.php";

  }

error_reporting(0);

$id=$_GET['id'];

if(isset($id)){

$delete=$pdo->prepare("delete from tbl_user where user_id =".$id);

if($delete->execute()){

  $_SESSION['status']="Account deleted successfully";
  $_SESSION['status_code']="success";

}else{

$_SESSION['status']="Account Is Not Deleted";
$_SESSION['status_code']="warning";
     }





}








if(isset($_POST['btnsave'])){

$username = $_POST['txtname'];
// $useremail = $_POST['txtemail'];
$userpassword= $_POST['txtpassword'];
$userrole= $_POST['txtselect_option'];

if(isset($_POST['txtname'])){

$select=$pdo->prepare("select username from tbl_user where username='$username'");

$select->execute();


if($select->rowCount()>0){



$_SESSION['status']="Username already exists!";
  $_SESSION['status_code']="warning";

}else{

  $insert=$pdo->prepare("insert into tbl_user (username,userpassword,role) values(:name,:password,:role)");

  $insert->bindParam(':name',$username);
//   $insert->bindParam(':email',$useremail);
  $insert->bindParam(':password',$userpassword);
  $insert->bindParam(':role',$userrole);
  
  if($insert->execute()){
  
  
  
  $_SESSION['status']="Insert successfully the user into the database";
  $_SESSION['status_code']="success";
  
  }else{
  
  
  
  $_SESSION['status']="Error inserting the user into the database";
  $_SESSION['status_code']="error";
  
  }



}







}













}






?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Users Account</h1> -->
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
     
        

        <div class="card card-info card-outline">
            <div class="card-header">
              <h5 class="m-0">Users Account</h5>
            </div>
            <div class="card-body">

<div class="row">

<div class="col-md-4">

<form action="" method="post">
               
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" placeholder="Enter Username" name="txtname" required>
                  </div>


                  <!-- <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control"  placeholder="Enter email" name="txtemail" required>
                  </div> -->
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control"  placeholder="Password" name="txtpassword" required>
                  </div>
                 
                  <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="txtselect_option" required>
                          <option value="" disabled selected>Select Role</option>
                          <option>Admin</option>
                          <option>User</option>
                         
                        </select>
                      </div>
               

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
                </div>
              </form>


</div>









<div class="col-md-8">

<table class="table table-striped table-hover ">
<thead>
<tr>
 <td>User ID</td>
 <td>Username</td>
 <!-- <td>Email</td> -->
 <td>Role</td> 
 <td>Login Time</td>
 <td>Logout Time</td>
 <td>Delete</td>   
</tr>

</thead>


<tbody>

<?php

$select = $pdo->prepare("select * from tbl_user order by user_id ASC");
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ))
{

echo'
<tr>
<td>'.$row->user_id.'</td>
<td>'.$row->username.'</td>

<td>'.$row->role.'</td>
<td class="badge-info ">'.$row->logintime.'</td>
<td class="badge-danger">'.$row->logout.'</td>
<td>

<a href="users.php?id='.$row->user_id.'" class="btn btn-danger"><i class="fa fa-trash-alt"></i></a>
</td>



</tr>';

}

?>

</tbody>

</table>




</div>


           

       
             
            </div>



            </div>
          </div>
     

       
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php

include_once "footer.php";


?>

<?php
  if(isset($_SESSION['status']) && $_SESSION['status']!='')
 
  {

?>
<script>

  
     Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      });

</script>
<?php
unset($_SESSION['status']);
  }
  ?>