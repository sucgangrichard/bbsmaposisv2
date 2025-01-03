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

  if(isset($_POST['btnsave'])){

    $barcode       =$_POST['txtbarcode'];
    $product_name  =$_POST['txtproduct_name'];
    $stock         =$_POST['txtstock'];
    $category      =$_POST['txtselect_option'];
    $expiration_date = date('Y-m-d',strtotime($_POST['date_1']));
    $date_of_receipt = date('Y-m-d',strtotime($_POST['date_2']));
    $received_by   =$_POST['txtreceived_by'];
    $packaging_type =$_POST['txtpackaging_type'];
    $description   =$_POST['txtdescription'];
    
    // Check if barcode already exists
    $select = $pdo->prepare("SELECT * FROM tbl_product WHERE barcode = :barcode");
    $select->bindParam(':barcode', $barcode);
    $select->execute();
    
    if($select->rowCount() > 0) {
      $_SESSION['status'] = "Barcode already exists!";
      $_SESSION['status_code'] = "error";
      header('location: stock_registry1.php');
      exit();
    }
  
  //Image Code or File Code Start Here..
  $f_name        =$_FILES['myfile']['name'];
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
      
    }else{
      
    if(move_uploaded_file($f_tmp,$store)){
  
  $product_image=$f_newfile;
  
  $insert=$pdo->prepare("insert into tbl_product ( barcode,product_name,stock,category,description,expiration_date, date_of_receipt,received_by,packaging_type,product_image) 
  values(:barcode,:product_name,:stock,:category,:description,:expiration_date, :date_of_receipt,:received_by,:packaging_type,:product_image)");
  
  $insert->bindParam(':barcode',$barcode);
  $insert->bindParam(':product_name',$product_name);
  $insert->bindParam(':stock',$stock);
  $insert->bindParam(':category',$category);
  $insert->bindParam(':description',$description);
  $insert->bindParam(':expiration_date',$expiration_date);
  $insert->bindParam(':date_of_receipt',$date_of_receipt);
  $insert->bindParam(':received_by',$received_by);
  $insert->bindParam(':packaging_type',$packaging_type);
  $insert->bindParam(':product_image',$product_image);
  
  if($insert->execute()){
    $_SESSION['status']="Product Inserted Successfully";
    $_SESSION['status_code']="success";
  }else{
    $_SESSION['status']="Product Inserted Failed";
    $_SESSION['status_code']="error";
  }
  
    } 
    }   
    }else{
      $_SESSION['status']="only jpg, jpeg, png and gif can be upload";
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
            <!-- <h1 class="m-0">Stock Registry</h1> -->
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
                <h5 class="m-0">Product Registry</h5>
              </div>
              <form action="" method="post" enctype="multipart/form-data">
  
              <div class="card-body">
              <div class="row">
              <div class="col-md-6">
              <label>Barcode</label>
              <div class="input-group mb-3">
                
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Scan Barcode" autocomplete="off" name="txtbarcode" id="txtbarcode_id">
                  </div>
  
                    <div class="form-group">
                      <label >Product Name</label>
                      <input type="text" class="form-control" placeholder="Enter Name" name="txtproduct_name" autocomplete="off" required>
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
    <option><?php echo $row['category'];?></option>
  
  <?php
  
  }
  
  ?>
                     
                           
                          </select>
                        </div>
  
                        <div class="form-group">
                      <label >Endorsed By</label>
                      <input type="text" class="form-control" placeholder="Enter Received By" name="txtreceived_by" autocomplete="off">
                    </div>
                    <!-- <div class="form-group">
                      <label >Condition at Receipt</label>
                      <input type="text" class="form-control" placeholder="Enter Barcode" name="txtbarcode" autocomplete="off">
                    </div> -->
                    <div class="form-group">
                      <label >Packaging Type</label>
                      <input type="text" class="form-control" placeholder="Enter Packaging Type" name="txtpackaging_type" autocomplete="off">
                    </div>
  
  
  
                        <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" placeholder="Enter Description" name="txtdescription" rows="4"></textarea>
                    </div>
  
  
  
  
  </div>
  
  
  
  
  <div class="col-md-6">
  
  
  <!-- <div class="form-group"> -->
       <!-- <label >Stock Quantity</label> -->
       <input type="hidden" min="0" step="any" class="form-control" placeholder="Preferrably = 0" name="txtstock" autocomplete="off">
      <!-- </div> -->
  
  
      <div class="form-group">
       <label >Expiration Date</label>
       <div class="input-group date" id="date_1" data-target-input="nearest">
                          <input type="text" class="form-control date_1" data-target="#date_1" name="date_1" placeholder="YYYY-MM-DD" 
                          pattern="\d{4}-\d{2}-\d{2}"  required/>
                          <div class="input-group-append" data-target="#date_1" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
      </div>
  
      <div class="form-group">
       <label >Date of Receipt</label>
       <div class="input-group date" id="date_2" data-target-input="nearest">
                          <input type="text" class="form-control date_2" data-target="#date_2"  name="date_2" placeholder="YYYY-MM-DD" 
                          pattern="\d{4}-\d{2}-\d{2}"  required/>
                          <div class="input-group-append" data-target="#date_2" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
      </div>
  
  
      <div class="form-group">
                      <label >Product image</label>
                      <input type="file" class="input-group"  name="myfile">
                      <p>Upload image</p>
                    </div>
  
  
  
  </div>
  
  
             
  
         
               
              </div>
  
           
  
              </div>
  
              <div class="card-footer">
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="btnsave">Save Product</button></div>
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