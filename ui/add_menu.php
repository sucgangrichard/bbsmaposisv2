<?php


include_once 'conndb.php';
session_start();



if($_SESSION['username']==""  OR $_SESSION['role']=="User"){

  header('location:../index.php');
  
  }


  if($_SESSION['role']=="Admin"){
    include_once'header.php';
  }else{
  
    include_once'headeruser.php';
  }

if(isset($_POST['btnsave'])){

    // $barcode       =$_POST['txtbarcode'];
    $product_name       =$_POST['txtproduct_name'];
    $available         =$_POST['txtavailable'];
    $category      =$_POST['txtselect_option'];
    $updated_date     = date('Y-m-d',strtotime($_POST['date_1']));
    // $date_of_receipt     = date('Y-m-d',strtotime($_POST['date_2']));
    $approved_by   =$_POST['txtapproved_by'];
    $price   =$_POST['txtprice'];
    // $condition_at_receipt   =$_POST['txtcondition_at_receipt'];
    //$packaging_type   =$_POST['txtpackaging_type'];
   // $description   =$_POST['txtdescription'];
    

//Image Code or File Code Start Here..
$f_name        =$_FILES['myfile']['name'];
$f_tmp         =$_FILES['myfile']['tmp_name'];
$f_size        =$_FILES['myfile']['size'];
$f_extension   =explode('.',$f_name);
$f_extension   =strtolower(end($f_extension));
$f_newfile     =uniqid().'.'. $f_extension;   
  
$store = "menuimages/".$f_newfile;
    
if($f_extension=='jpg' || $f_extension=='jpeg' ||   $f_extension=='png' || $f_extension=='gif'){
 
  if($f_size>=1000000 ){
        
 


  $_SESSION['status']="Max file should be 1MB";
  $_SESSION['status_code']="warning";
        
  }else{
      
  if(move_uploaded_file($f_tmp,$store)){

$product_image=$f_newfile;


if(empty($product_name)){


  $insert=$pdo->prepare("insert into tbl_mmenu ( product_name,category,available,price, updated_date,approved_by,image) 
  values(:product_name,:category,:available,:price, :updated_date,:approved_by,:image)");
  



 // $insert->bindParam(':barcode',$barcode);

  
  $insert->bindParam(':product_name',$product_name);
  $insert->bindParam(':category',$category);
  $insert->bindParam(':available',$available);
  $insert->bindParam(':price',$price);
  $insert->bindParam(':updated_date',$updated_date);
  $insert->bindParam(':approved_by',$approved_by);
  $insert->bindParam(':image',$product_image);
  
  $insert->execute();

  $menu_id=$pdo->lastInsertId(); // which was the 5



  



  date_default_timezone_set("Asia/Calcutta");
$newproduct_name=$pid.date('his');

$update=$pdo->prepare("update tbl_mmenu SET barcode='$newproduct_name' where menu_id='".$menu_id."'");

if($update->execute()){


  $_SESSION['status']="Product Inserted Successfully";
  $_SESSION['status_code']="success";
}else{
  $_SESSION['status']="Product Inserted Failed";
  $_SESSION['status_code']="error";

}




 


}else{




  $insert=$pdo->prepare("insert into tbl_mmenu ( product_name,category,available,price, updated_date,approved_by,image) 
  values(:product_name,:category,:available,:price, :updated_date,:approved_by,:image)");
  



 // $insert->bindParam(':barcode',$barcode);

  
  $insert->bindParam(':product_name',$product_name);
  $insert->bindParam(':category',$category);
  $insert->bindParam(':available',$available);
  $insert->bindParam(':price',$price);
  $insert->bindParam(':updated_date',$updated_date);
  $insert->bindParam(':approved_by',$approved_by);
  $insert->bindParam(':image',$product_image);

if($insert->execute()){

  $_SESSION['status']="Product Inserted Successfully";
  $_SESSION['status_code']="success";
}else{
  $_SESSION['status']="Product Inserted Failed";
  $_SESSION['status_code']="error";

}



}





           
  
           
  } 
        
  }   
        
  }else
{
     
  
      $_SESSION['status']="Invalid File Format";
      $_SESSION['status_code']="warning";

} 
}

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
          <!-- <h1 class="m-0">Add Menu</h1> -->
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
        

        <div class="card card-dark card-outline">
            <div class="card-header">
              <h5 class="m-0">Add Menu Form</h5>
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
                    <input type="text" class="form-control" placeholder="Enter Name" name="txtproduct_name" autocomplete="off" required>
                  </div>

                  <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="txtselect_option" required>
                          <option value="" disabled selected>Select Category</option>
                          <?php
$select=$pdo->prepare("select * from tbl_menu_category order by menu_cat_id desc");
$select->execute();

while($row=$select->fetch(PDO::FETCH_ASSOC))
{
extract($row);

?>
  <option><?php echo $row['category'];?></option>

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
                    
                  
                  <input type="number" class="form-control" name="txtprice"  id="txtprice_id" placeholder="Enter Price" required>
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
     <input type="number" min="0" step="any" class="form-control" placeholder="Enter the Estimated Amount to Be Consumed" name="txtavailable" autocomplete="off" required>
    </div>


    <div class="form-group">
     <label >Received Date</label>
     <!-- <input type="text" class="form-control" name="date_1" placeholder="YYYY-MM-DD" pattern="\d{4}-\d{2}-\d{2}" required> -->
     <div class="input-group date" id="date_1" data-target-input="nearest">
                        <input type="text" class="form-control date_1" data-target="#date_1" name="date_1"  placeholder="YYYY-MM-DD" pattern="\d{4}-\d{2}-\d{2}"  required/>
                        <div class="input-group-append" data-target="#date_1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>

                    
    </div>

    <div class="form-group">
                    <label >Approved By</label>
                    <input type="text" class="form-control" placeholder="Enter Received By" name="txtapproved_by" autocomplete="off">
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
                    <label >Menu Image</label>
                    <input type="file" class="input-group"  name="myfile">
                    <p>Upload image</p>
                  </div>



</div>


           

       
             
            </div>

         

            </div>

            <div class="card-footer">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="btnsave">Save Menu</button></div>
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

  