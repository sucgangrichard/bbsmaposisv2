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


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

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
              <h5 class="m-0">Menu List :</h5>
            </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover " id="table_product">
                <thead>
                  <tr>
                    <!-- <td>#</td> -->
                    <td>Product Name</td>
                    <td>Category</td>
                    <td>Price</td>
                    <td>Avail.QTY</td>
                    <td>Date</td>
                    <td>Approved By</td>
                    <td>Image</td>
                    <!-- <td>Image</td>
                    <td>Action</td> -->

                  </tr>

                </thead>


                <tbody>

                  <?php

                  $select = $pdo->prepare("select * from tbl_mmenu order by menu_id ASC");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '
<tr>

<td>' . $row->product_name . '</td>
<td>' . $row->category . '</td>
<td>' . $row->price . '</td>
<td>' . $row->available . '</td>
<td>' . $row->updated_date . '</td>
<td>' . $row->approved_by . '</td>
<td>' . $row->image . '</td>


<td><image src="menuimages/' . $row->image . '" class="img-rounded" width="40px" height="40px/"></td>

<td>

<div class="btn-group">
        



<a href="viewproduct_1.php?id=' . $row->menu_id . '" class="btn btn-warning btn-xs" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Product"></span></a>


<a href="edit_menu.php?id=' . $row->menu_id . '" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Product"></span></a>

<button id=' . $row->menu_id . '  class="btn btn-danger btn-xs btndelete"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Product"></span></button>


</div>

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
    $('#table_product').DataTable();
  });
</script>

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
      </script>