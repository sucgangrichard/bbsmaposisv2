<?php
include_once 'conndb.php';
ob_start();
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

$select = $pdo->prepare("select * from tbl_mmenu where menu_id=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$id_db=$row['menu_id'];

// $barcode_db=$row['barcode'];
$product_name_db=$row['product_name'];
$category_db=$row['category'];
$price_db=$row['price'];
$available_db=$row['available'];
$updated_date_db=$row['updated_date'];
$approved_by_db=$row['approved_by'];
// $description_db=$row['description'];
// $stock_db=$row['stock'];
// $date_of_receipt_db=$row['date_of_receipt'];
// $expiration_date_db=$row['expiration_date'];
// $received_by_db=$row['received_by'];
$image_db=$row['image'];



if(isset($_POST['btneditproduct'])){

    $product_name_txt       =$_POST['txtproduct_name'];
    $category_txt      =$_POST['txtselect_option'];
    $price_txt         =$_POST['txtprice'];
    $available_txt   =$_POST['txtavailable'];
    $updated_date_txt     = date('Y-m-d',strtotime($_POST['date_1']));
    $approved_by_txt =$_POST['txtapproved_by'];
    // $received_by_txt =$_POST['txtreceived_by'];
    
    $f_name        =$_FILES['myfile']['name'];
  
    if(!empty($f_name)){
      $f_tmp         =$_FILES['myfile']['tmp_name'];
      $f_size        =$_FILES['myfile']['size'];
      $f_extension   =explode('.',$f_name);
      $f_extension   =strtolower(end($f_extension));
      $f_newfile     =uniqid().'.'. $f_extension;   
      $store = "menuimages/".$f_newfile;
        
      if($f_extension=='jpg' || $f_extension=='jpeg' || $f_extension=='png' || $f_extension=='gif'){
        if($f_size>=1000000 ){
          $_SESSION['status']="Max file should be 1MB";
          $_SESSION['status_code']="warning";
        } else {
          if(move_uploaded_file($f_tmp,$store)){
            $update = $pdo->prepare("UPDATE tbl_mmenu SET product_name=:product_name, category=:category, price=:price, available=:available, updated_date=:updated_date, approved_by=:approved_by, image=:image WHERE menu_id=$id");
  
            $update->bindParam(':product_name', $product_name_txt);
            $update->bindParam(':category', $category_txt);
            $update->bindParam(':price', $price_txt);
            $update->bindParam(':available', $available_txt);
            $update->bindParam(':updated_date', $updated_date_txt);
            $update->bindParam(':approved_by', $approved_by_txt);
            // $update->bindParam(':received_by', $received_by_txt);
            $update->bindParam(':image', $f_newfile);
            // header('Location: menu_list1.php');
            if($update->execute()){
              
              $_SESSION['status']="Product Updated Successfully With New Image";
              // header('Location: menu_list1.php');
              $_SESSION['status_code']="success";
              // header('Location: menu_list1.php');
              
              
            } else {
              $_SESSION['status']="Product Update Failed";
              $_SESSION['status_code']="error";
            }
          }
        }
      }
    } else {
        $update = $pdo->prepare("UPDATE tbl_mmenu SET product_name=:product_name, category=:category, price=:price, available=:available, updated_date=:updated_date, approved_by=:approved_by, image=:image WHERE menu_id=$id");
  
        $update->bindParam(':product_name', $product_name_txt);
        $update->bindParam(':category', $category_txt);
        $update->bindParam(':price', $price_txt);
        $update->bindParam(':available', $available_txt);
        $update->bindParam(':updated_date', $updated_date_txt);
        $update->bindParam(':approved_by', $approved_by_txt);
        // $update->bindParam(':received_by', $received_by_txt);
        $update->bindParam(':image', $f_newfile);
        
        if($update->execute()){
          $_SESSION['status']="Product Updated Successfully With New Image";
          $_SESSION['status_code']="success";
          
          
        } else {
          $_SESSION['status']="Product Update Failed";
          $_SESSION['status_code']="error";

}




 }
 header('Location: user_menu_list2.php');



 
 
}

ob_end_flush();
$select = $pdo->prepare("select * from tbl_mmenu where menu_id=$id");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$id_db=$row['menu_id'];
// $barcode_db=$row['barcode'];
$product_name_db=$row['product_name'];
$category_db=$row['category'];
$price_db=$row['price'];
$available_db=$row['available'];
$updated_date_db=$row['updated_date'];
$approved_db=$row['approved_by'];
// $description_db=$row['description'];
// $stock_db=$row['stock'];
// $date_of_receipt_db=$row['date_of_receipt'];
// $expiration_date_db=$row['expiration_date'];
// $received_by_db=$row['received_by'];
$image_db=$row['image'];





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
          <h1 class="m-0">Edit Menu</h1>
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
              <h5 class="m-0">Edit Menu Form</h5>
            </div>
            <form action="" method="post" enctype="multipart/form-data">

            <div class="card-body">
            <div class="row">
            <div class="col-md-6">
            <!-- <label>Barcode</label> -->
            <!-- <div class="input-group mb-3">
              
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                  </div>
                  <input type="text" class="form-control" placeholder="Scan Barcode" autocomplete="off" name="txtbarcode" id="txtbarcode_id">
                </div> -->

                  <div class="form-group">
                    <label >Product Name</label>
                    <input type="text" class="form-control" value="<?php echo $product_name_db;?>" placeholder="Enter Name" name="txtproduct_name" autocomplete="off" required>
                  </div>

                  <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="txtselect_option" required>
                          <option value="" disabled selected><?php echo $row['category'];?></option>
                          <?php
$select=$pdo->prepare("select * from tbl_menu_category order by menu_cat_id desc");
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

                      
                  <!-- <div class="form-group">
                    <label >Condition at Receipt</label>
                    <input type="text" class="form-control" placeholder="Enter Barcode" name="txtbarcode" autocomplete="off">
                  </div> -->
                  <div class="form-group">
                  <label >Price</label>
                  <div class="input-group">
                    
                  
                  <input type="number" class="form-control" value="<?php echo $price_db;?>" name="txtprice"  id="txtprice_id" placeholder="Enter Price" required>
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>
                  </div>



                      <!-- <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" placeholder="Enter Description" name="txtdescription" rows="4" required></textarea>
                  </div> -->




</div>




<div class="col-md-6">


<div class="form-group">
     <label >Available#</label>
     <input type="number" min="0" step="any"value="<?php echo $available_db;?>" class="form-control" placeholder="Enter Available Quantity" name="txtavailable" autocomplete="off" required>
    </div>


    <div class="form-group">
     <label >Updated Date</label>
     <div class="input-group date" id="date_1" data-target-input="nearest">
                        <input type="text" class="form-control date_1" value="<?php echo $updated_date_db;?>" data-target="#date_1" name="date_1"  placeholder="YYYY-MM-DD" pattern="\d{4}-\d{2}-\d{2}"  required/>
                        <div class="input-group-append" data-target="#date_1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>

                    
    </div>

    <div class="form-group">
                    <label >Approved By</label>
                    <input type="text" class="form-control" value="<?php echo $approved_by_db;?>" placeholder="Enter Received By" name="txtapproved_by" autocomplete="off">
                  </div>

    <!-- <div class="form-group">
     <label >Date of Receipt</label>
     <div class="input-group date" id="date_2" data-target-input="nearest">
                        <input type="text" class="form-control date_2" data-target="#date_2"  name="date_2" required/>
                        <div class="input-group-append" data-target="#date_2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
    </div> -->


    <div class="form-group">
                    <label >Menu Image</label><br>
                    <image src="menuimages/<?php echo $image_db;?>" class="img-rounded" width="50px" height="50px/">
                    <input type="file" class="input-group"   name="myfile" required>
                    <p>Upload image</p>
                  </div>



</div>


           

       
             
            </div>

         

            </div>

            <div class="card-footer">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="btneditproduct">Save Changes</button></div>
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

<!-- InputMask -->
<script src="../plugins/moment/moment.min.js"></script>

<!-- date-range-picker -->
<script src="../plugins/daterangepicker/daterangepicker.js"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>




<script>

 //Date picker
 $('#date_1').datetimepicker({
        format: 'YYYY-MM-DD'
    });



    //Date picker
 $('#date_2').datetimepicker({
        format: 'YYYY-MM-DD'
    });




</script>

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

  <!-- Continue Open the alternative of posbarcode and open 'AddProduct php and then 
   just copy all the way open 2 tab database for this and to posbarcode
   Try to organize the input field-->