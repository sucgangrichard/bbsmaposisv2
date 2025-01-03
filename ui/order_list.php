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

  

?>
<style type="text/css">

.tableFixHead{
overflow: scroll;
height: 520px;
overflow: auto;
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
          <h1 class="m-0">Orders</h1>
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
              <h5 class="m-0">Order list</h5>
            </div>
            <div class="card-body">
              
            <div class="tableFixHead">
            <table class="table table-striped table-hover " id="table_orderlist">
                <thead>
                    <tr>
                    <td>Order Date</td><!--total_per_qty-->
                    <td>Time</td>
                    <td>Invoice ID</td>
                    <td>Table#</td><!--table_number-->
                    <td>D/O</td>
                    <td>qty</td><!--qty-->
                    <!-- <td>Product</td>product_name -->
                    <!-- <td>Total</td> total_per_qty -->
                    <td>Total Due</td><!--total_due-->
                    <td>Paid</td><!--paid-->
                    <td>Change</td><!--change_amount-->
                    
                    <td>Vatable Sales</td><!--vatable_sales-->
                    <td>Vat Amount</td><!--vat_amount-->
                    <td>Payment Type</td><!--payment_type-->
                  
                    <td>ActionIcons</td>
                    </tr>
                </thead>
                <?php
                $select = $pdo->prepare("SELECT 
                tbl_invoice_details.product_name,
                SUM(tbl_invoice_details.qty) as total_qty,
                -- tbl_invoice_details.qty,
                tbl_invoice_details.total_per_qty,
                tbl_invoice_details.table_number,
                tbl_invoice.invoice_id,
                tbl_invoice.total_due,
                tbl_invoice.change_amount,
                tbl_invoice.paid,
                tbl_invoice.payment_type,
                tbl_invoice.vatable_sales,
                tbl_invoice.vat_amount,
                tbl_invoice.order_date,
                tbl_invoice.dine_in,
                tbl_invoice.time_value

                FROM 
                tbl_invoice_details
            JOIN 
                tbl_invoice
            ON 
                tbl_invoice_details.invoice_id = tbl_invoice.invoice_id
            GROUP BY 
                tbl_invoice.invoice_id
            ORDER BY 
                tbl_invoice.invoice_id DESC
            -- FROM 
            --     tbl_invoice_details
            -- JOIN 
            --     tbl_invoice
            -- ON 
            --     tbl_invoice_details.invoice_id = tbl_invoice.invoice_id

            --     ORDER BY tbl_invoice.invoice_id DESC
            ");
    // $select = $pdo->prepare("SELECT 
    //   tbl_invoice_details.product_name,
    //   SUM(tbl_invoice_details.qty) as total_qty,
    //   tbl_invoice_details.total_per_qty,
    //   tbl_invoice_details.table_number,
    //   tbl_invoice.invoice_id,
    //   tbl_invoice.total_due,
    //   tbl_invoice.change_amount,
    //   tbl_invoice.paid,
    //   tbl_invoice.payment_type,
    //   tbl_invoice.vatable_sales,
    //   tbl_invoice.vat_amount,
    //   tbl_invoice.order_date,
    //   tbl_invoice.dine_in,
    //   tbl_invoice.time_value
    // FROM 
    //   tbl_invoice_details
    // JOIN 
    //   tbl_invoice
    // ON 
    //   tbl_invoice_details.invoice_id = tbl_invoice.invoice_id
    // GROUP BY 
    //   tbl_invoice.invoice_id
    // ORDER BY 
    //   tbl_invoice.invoice_id DESC
    // ");
    $select->execute();

    while ($row = $select->fetch(PDO::FETCH_OBJ)) {

        echo '
<tr>

<td>' . $row->order_date   . '</td>
<td>' . $row->time_value   . '</td>
<td>' . $row->invoice_id   . '</td>
<td>' . $row->table_number        . '</td>
<td>' . $row->dine_in        . '</td>
<td>' . $row->total_qty        . '</td>


<td>' . $row->total_due        . '</td>
<td>' . $row->paid         . '</td>
<td>' . $row->change_amount   . '</td>
<td>' . $row->vatable_sales         . '</td>
<td>' . $row->vat_amount          . '</td>';

// // <td>' . $row->product_name   . '</td>
//                     
//                     
//                     
//                     
//                     
//                     
//                     
//                     
//                     <td>Payment Type</td><!--payment_type-->
//                     <td>Vatable Sales</td><!--vatable_sales-->
//                     <td>Vat Amount</td><!--vat_amount-->




if($row->payment_type=="Cash"){
echo'<td><span class="badge badge-secondary">'.$row->payment_type.'</td></span></td>';
}else if($row->payment_type=="Gcash"){

echo'<td><span class="badge badge-success">'.$row->payment_type.'</td></span></td>';
}else if($row->payment_type=="Maya"){
echo'<td><span class="badge badge-primary">'.$row->payment_type.'</td></span></td>';

}else if($row->payment_type=="Debit/Credit"){
  echo'<td><span class="badge badge-warning">'.$row->payment_type.'</td></span></td>';

}






echo'
<td>
<div class="btn-group">
    <a href="printbill.php?id='.$row->invoice_id.'" class="btn btn-warning " role="button" target="_blank"><span class="fa fa-print" style="color:#ffffff" data-toggle="tooltip" title="Print Bill"></span></a>
    <a href="edit_dine_in.php?id='.$row->invoice_id.'" class="btn btn-info " role="button" onclick="return checkPassword('.$row->invoice_id.', \'edit_dine_in.php?id='.$row->invoice_id.'\')"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Order"></span></a>
    <button id='.$row->invoice_id.' class="btn btn-danger  btndelete" onclick="return checkPassword('.$row->invoice_id.', \'delete_order.php?id='.$row->invoice_id.'\')"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Order"></span></button>
</div>
</td>

</tr>';
      }

//       <td> <button id='.$row->invoice_id.' class="btn btn-danger  btndelete" onclick="return checkPassword('.$row->invoice_id.', \'delete_order.php?id='.$row->invoice_id.'\')"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Order"></span></button>
// <div class="btn-group">
// <a href="user_printbill.php?id='.$row->invoice_id.'" class="btn btn-warning " role="button" target="_blank"><span class="fa fa-print" style="color:#ffffff" data-toggle="tooltip" title="Print Bill"></span></a>
// <a href="useredit_dine_in.php?id='.$row->invoice_id.'" class="btn btn-info " role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Order"></span></a>
// <button id='.$row->invoice_id.' class="btn btn-danger  btndelete"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete Order"></span></button>
// </div>
// </td>
// </tr>';
                
                ?>
                <tbody>

                </tbody>
                
            </table>
            </div>
            <hr>
        <div class="d-flex justify-content-end mt-3 mt-md-0 ml-auto">
        <form action="export_stock_list2.php" method="post">
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
function checkPassword(invoiceId, redirectUrl) {
    Swal.fire({
        title: 'Enter Password',
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        showLoaderOnConfirm: true,
        preConfirm: (password) => {
            if (password === '1234') { // Replace '1234' with the actual password
                return true;
            } else {
                Swal.showValidationMessage('Incorrect password');
                return false;
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = redirectUrl;
        }
    });
    return false; // Prevent the default action until password is confirmed
}
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
                            url: 'orderdelete.php',
                            type: 'post',
                            data:{pidd:id},
                            success: function(data) {
                            tdh.parents('tr').hide();
                            }


                        });







    Swal.fire(
      'Deleted!',
      'Your Invoice has been deleted.',
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