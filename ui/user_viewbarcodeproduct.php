<?php
include_once 'conndb.php';
session_start();
if($_SESSION['username']==""  OR $_SESSION['role']=="Admin"){

  header('location:../index.php');
  
  }


  if($_SESSION['role']=="User"){
    include_once'headeruser.php';
  }else{
  
    include_once'header.php';
  }

include 'barcode/barcode128.php';
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Admin Dashboard</h1> -->
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
        

        <div class="card card-info card-outline">
            <div class="card-header">
              <h5 class="m-0">View Product</h5>
            </div>
            <div class="card-body">

<?php
$id =$_GET['id'];

$select = $pdo->prepare("select * from tbl_product where id = $id");
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ)){

echo'
<div class="row">
<div class="col-md-6">

<ul class="list-group">

<center><p class="list-group-item list-group-item-info"><b>PRODUCT DETAILS</b></p></center>  

  <li class="list-group-item"><b>Barcode</b> <span class="badge badge-light float-right">'.bar128($row->barcode).'</span></li>
  <li class="list-group-item"><b>Product Name</b><span class="badge badge-warning float-right">'.$row->product_name.'</span></li>
  <li class="list-group-item"><b>Category</b> <span class="badge badge-success float-right">'.$row->category.'</span></li>
  <li class="list-group-item"><b>Description </b><span class="badge badge-primary float-right">'.$row->description.'</span></li>
  <li class="list-group-item"><b>Stock Quantity</b> <span class="badge badge-danger float-right">'.$row->stock.'</span></li>
  <li class="list-group-item"><b>Data of Receipt </b><span class="badge badge-secondary float-right">'.$row->date_of_receipt.'</span></li>
  <li class="list-group-item"><b>Expiration Date</b> <span class="badge badge-dark float-right">'.$row->expiration_date.'</span></li>
  <li class="list-group-item"><b>Received by</b> <span class="badge badge-success float-right">'.$row->received_by.'</span></li>
</ul>
</div>

<div class="col-md-6">
<ul class="list-group">
<center><p class="list-group-item list-group-item-info"><b>PRODUCT IMAGE</b></p></center>  
<img src="productimages/'.$row->product_image.'" class="img-thumbnail"/>
</ul>
</div>
</div>






';







}





?>


             






             
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