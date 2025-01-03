<?php
include_once "conndb.php";
session_start();
if($_SESSION['username']==""  OR $_SESSION['role']=="Admin"){

  header('location:../index.php');
  
  }


  if($_SESSION['role']=="User"){
    include_once'headeruser.php';
  }else{
  
    include_once'header.php';
  }

  

?>
<style type="text/css">

.tableFixHead{
overflow: scroll;
height: 520px;
}
.tableFixHead thead th {
    position: sticky;
    top:0 ;
    z-index: 1;
}

table {border-collapse:collapse; width: 100px;}
th,td {padding:8px 16px;}
th{background: #eee;}


    </style>


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
              <h5 class="m-0">Menu list</h5>
            </div>
            <div class="card-body">
              
            <div class="tableFixHead">
            <table class="table table-striped table-hover " id="table_orderlist">
                <thead>
                    <tr>
                    <td>Product Name</td>
                    <td>Category</td>
                    <td>Avail.QTY</td>
                    <td>Price</td>
                    
                    <td>Date</td>
                    <td>Endorsed by</td>
                    <td>Image</td>
                    <td>Action</td>
                    </tr>
                </thead>
                
                <tbody>
<?php
$select= $pdo->prepare("SELECT * FROM tbl_mmenu");
$select->execute();
while($row=$select->fetch(PDO::FETCH_OBJ)){
    $menu_id=$row->menu_id;
    $menu_name=$row->product_name;
    $menu_category=$row->category;
    $menu_price=$row->available;
    $menu_qty=$row->price;
    $menu_date=$row->updated_date;
    $menu_approvedby=$row->approved_by;
    $menu_image=$row->image;
    
    
    echo'
    <tr>
    <td>'.$menu_name.'</td>
    <td>'.$menu_category.'</td>
    <td>'.$menu_price.'</td>
    <td>'.$menu_qty.'</td>
    <td>'.$menu_date.'</td>
    <td>'.$menu_approvedby.'</td>
    <td><image src="menuimages/' . $row->image . '" class="img-rounded" width="40px" height="40px/"></td>
    
<td><div class="btn-group">
        



<a href="user_viewproduct2.php?id=' . $row->menu_id . '" class="btn btn-warning btn-xs" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>





</div></td>
    
    </tr>
    ';
}

?>
<!-- <a href="edit_menu.php?id=' . $row->menu_id . '" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>

<button id=' . $row->menu_id . '  class="btn btn-danger btn-xs btndelete"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button> -->
                </tbody>
                
            </table>
            </div>

            <hr>
        <div class="d-flex justify-content-end mt-3 mt-md-0 ml-auto">
      <form action="export_stock_list1.php" method="post">
        <button type="submit" class="btn btn-primary mr-2">Export as CSV</button>
      </form>
    </div>
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

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>


<script>



  $(document).ready(function() {
    $('.btndelete').click(function() {
            var tdh = $(this);
            var id = $(this).attr("id");


            Swal.fire({ 
  title: 'Do you want to delete?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {



    $.ajax({
                            url: 'menu_delete.php',
                            type: 'post',
                            data: {
                            pidd: id
                            },
                            success: function(data) {
                            tdh.parents('tr').hide();
                            }


                        });







    Swal.fire(
      'Deleted!',
      'Your Product has been deleted.',
      'success'
    )
  }
})








           
                      });
            
          });
     

</script>

<script>
  $(document).ready(function() {
    $('#table_orderlist').DataTable({

      "order":[[0,"desc"]]
    });
  });
</script> 