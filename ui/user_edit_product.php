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


$id = $_GET['id'];

$select = $pdo->prepare("select * from tbl_product where id=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$id_db=$row['id'];

$barcode_db=$row['barcode'];
$product_name_db=$row['product_name'];
$category_db=$row['category'];
$description_db=$row['description'];
$stock_db=$row['stock'];
$date_of_receipt_db=$row['date_of_receipt'];
$expiration_date_db=$row['expiration_date'];
$received_by_db=$row['received_by'];
$image_db=$row['product_image'];



if(isset($_POST['btneditproduct'])){

    $product_name_txt       =$_POST['txtproduct_name'];
    $category_txt      =$_POST['txtselect_option'];
    $stock_txt         =$_POST['txtstock'];
    $description_txt   =$_POST['txtdescription'];
    $date_of_receipt_txt     =$_POST['txtdate_of_receipt'];
    $expiration_date_txt =$_POST['txtexpiration_date'];
    $received_by_txt =$_POST['txtreceived_by'];
    
    $f_name        =$_FILES['myfile']['name'];
  
    if(!empty($f_name)){
      $f_tmp         =$_FILES['myfile']['tmp_name'];
      $f_size        =$_FILES['myfile']['size'];
      $f_extension   =explode('.',$f_name);
      $f_extension   =strtolower(end($f_extension));
      $f_newfile     =uniqid().'.'. $f_extension;   
      $store = "productimages/".$f_newfile;
        
      if($f_extension=='jpg' || $f_extension=='jpeg' || $f_extension=='png' || $f_extension=='gif'){
        if($f_size>=1000000 ){
          $_SESSION['status']="Max file should be 1MB";
          $_SESSION['status_code']="warning";
        } else {
          if(move_uploaded_file($f_tmp,$store)){
            $update = $pdo->prepare("UPDATE tbl_product SET product_name=:product_name, category=:category, stock=:stock, description=:description, date_of_receipt=:date_of_receipt, expiration_date=:expiration_date, received_by=:received_by, product_image=:product_image WHERE id=$id");
  
            $update->bindParam(':product_name', $product_name_txt);
            $update->bindParam(':category', $category_txt);
            $update->bindParam(':stock', $stock_txt);
            $update->bindParam(':description', $description_txt);
            $update->bindParam(':date_of_receipt', $date_of_receipt_txt);
            $update->bindParam(':expiration_date', $expiration_date_txt);
            $update->bindParam(':received_by', $received_by_txt);
            $update->bindParam(':product_image', $f_newfile);
            
            if($update->execute()){
              $_SESSION['status']="Product Updated Successfully With New Image";
              $_SESSION['status_code']="success";
            } else {
              $_SESSION['status']="Product Update Failed";
              $_SESSION['status_code']="error";
            }
          }
        }
      }
    } else {
      $update = $pdo->prepare("UPDATE tbl_product SET product_name=:product_name, category=:category, stock=:stock, description=:description, date_of_receipt=:date_of_receipt, expiration_date=:expiration_date, received_by=:received_by WHERE id=$id");
  
      $update->bindParam(':product_name', $product_name_txt);
      $update->bindParam(':category', $category_txt);
      $update->bindParam(':stock', $stock_txt);
      $update->bindParam(':description', $description_txt);
      $update->bindParam(':date_of_receipt', $date_of_receipt_txt);
      $update->bindParam(':expiration_date', $expiration_date_txt);
      $update->bindParam(':received_by', $received_by_txt);
  
      if($update->execute()){
        $_SESSION['status']="Product Updated Successfully";
        $_SESSION['status_code']="success";
      } else {
        $_SESSION['status']="Product Update Failed";
        $_SESSION['status_code']="error";

}




 }





}


$select = $pdo->prepare("select * from tbl_product where id=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$id_db=$row['id'];

$barcode_db=$row['barcode'];
$product_name_db=$row['product_name'];
$category_db=$row['category'];
$description_db=$row['description'];
$stock_db=$row['stock'];
$date_of_receipt_db=$row['date_of_receipt'];
$expiration_date_db=$row['expiration_date'];
$received_by_db=$row['received_by'];
$image_db=$row['product_image'];





?>


<!-- daterange picker -->
<link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">

<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
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
        

        <div class="card card-success card-outline">
            <div class="card-header">
              <h5 class="m-0">Edit Product</h5>
            </div>
           
<form action="" method="post" name="formeditproduct" enctype="multipart/form-data">
            <div class="card-body">
<div class="row">
<div class="col-md-6">

<div class="form-group">
                    <label >Barcode</label>
 <input type="text" class="form-control" value="<?php echo $barcode_db;?>" placeholder="Enter Barcode" name="txtbarcode" autocomplete="off" disabled>
                  </div>

<div class="form-group">
                    <label >Product Name</label>
                    <input type="text" class="form-control" value="<?php echo $product_name_db;?>" placeholder="Enter Name" name="txtproduct_name" autocomplete="off" required>
                  </div>

                  <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="txtselect_option" required>
                          <option value="" disabled selected>Select Category</option>
                         
<?php
$select=$pdo->prepare("select * from tbl_category order by cat_id desc");
$select->execute();

while($row=$select->fetch(PDO::FETCH_ASSOC))
{
extract($row);

?>
  <option <?php if($row['category']==$category_db  ){ ?>
    
    selected="selected"
    
    
    <?php }?>  ><?php echo $row['category'];?></option>

<?php

}

?>
                   
                         
                        </select>
                      </div>


                      <div class="form-group">
                    <label>Description</label>
<textarea class="form-control" placeholder="Enter Description" name="txtdescription" rows="4" required><?php echo $description_db;?> </textarea>
                  </div>




</div>




<div class="col-md-6">


<div class="form-group">
     <label >Stock Quantity</label>
     <input type="number" min="1" step="any" class="form-control" value="<?php echo $stock_db;?>" placeholder="Enter Stock" name="txtstock" autocomplete="off" required>
    </div>


    <div class="form-group">
     <label >Date Of Receipt</label>
     <input type="date" class="form-control" value="<?php echo $date_of_receipt_db;?>" name="txtdate_of_receipt" autocomplete="off" required>
    </div>

    <div class="form-group">
     <label >Expiration_date</label>
     <input type="date" class="form-control" value="<?php echo $expiration_date_db;?>" name="txtexpiration_date" autocomplete="off" required>
    </div>

    <div class="form-group">
                    <label >Received By</label>
 <input type="text" class="form-control" value="<?php echo $received_by_db;?>" name="txtreceived_by" autocomplete="off" required>
                  </div>

    <div class="form-group">
                    <label >Product image</label><br />
                    <image src="productimages/<?php echo $image_db;?>" class="img-rounded" width="50px" height="50px/">


                    <input type="file" class="input-group"  name="myfile">
                    <p>Upload image</p>
                  </div>



</div>


           

       
             
            </div>

         

            </div>

            <div class="card-footer">
                <div class="text-center">
                  <button type="submit" class="btn btn-success" name="btneditproduct">Update Product</button></div>
                </div>
            
            </form>





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