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



  if (isset($_POST['btnsave'])) {
    // Loop through the scanned barcodes and insert them into the database
    foreach ($_SESSION['scanned_barcodes'] as $barcode => $quantity) {
        // Check if the barcode already exists in the database
        $sql = $pdo->prepare("SELECT stock FROM tbl_product WHERE barcode = ?");
        $sql->execute([$barcode]);

        if ($sql->rowCount() > 0) {
            // If exists, update the stock quantity
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $new_stock = $row['stock'] + $quantity;

            // Update stock in the database
            $update_sql = $pdo->prepare("UPDATE tbl_product SET stock = ? WHERE barcode = ?");
            $update_sql->execute([$new_stock, $barcode]);

            
        } else {
            // If not exists, insert the new barcode and quantity
            $insert_sql = $pdo->prepare("INSERT INTO tbl_product (barcode, stock) VALUES (?, ?)");
            $insert_sql->execute([$barcode, $quantity]);
        }
    }

    // Clear scanned barcodes session after saving
    $_SESSION['scanned_barcodes'] = [];

    // Optionally, display a success message
    echo "<p>Data has been saved successfully!</p>";
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
          <!-- <h1 class="m-0">Stock Usage Tracker</h1> -->
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
            <h5 class="m-0">Stock Usage Tracker</h5>
            </div>
            <div class="card-body">
           <div class="col-md-12">


           <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                  </div>
                  <input type="text" class="form-control" placeholder="Scan Barcode" autocomplete="off" name="txtbarcode" id="txtbarcode_id">
                </div>

                <div class="tableFixHead">


<table id="producttable" class="table table-bordered table-hover">
<thead>
<tr>
 <th>Barcode</th>
 <th>PROD  </th>
 <th>STK  </th>
 <th>QTY    </th>
 <th>CAT  </th> 
 <th>EXP    </th>   
 <th>RCPT    </th>  
 <th>Save   </th> 
 <th>Delete  </th>  
</tr>

</thead>


<tbody class="details" id="itemtable">

<tr data-widget="expandable-table" aria-expanded="false">
                     
</tr>           
</tbody>
</table>



</div>


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
 var productarr=[];

$(function() {

    $('#txtbarcode_id').on('change', function() {

        var barcode = $("#txtbarcode_id").val();

         // Check if the barcode contains only numbers
         if (!/^\d+$/.test(barcode)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Barcode',
                text: 'Only 1D barcodes (numbers only) are allowed.'
            });
            $("#txtbarcode_id").val("");
            return;
        }

        $.ajax({
            url: "getproduct.php",
            method: "get",
            dataType: "json",
            data: { id: barcode },
            success: function(data) {

              if (!data || !data["id"]) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Unrecognizable Product',
                        text: 'The scanned product is not recognized. Please check the barcode.'
                        
                    });
                    $("#txtbarcode_id").val("");
                    return;
                }

                if (jQuery.inArray(data["id"], productarr) !== -1) {
                    var actualqty = parseInt($('#qty_id' + data["id"]).val()) + 1;
                    if (actualqty > data["stock"]) {
                        // alert("Quantity has reached the stock limit for product: " + data["product_name"]);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Stock Limit Reached',
                            text: 'Quantity has reached the stock limit for product: ' + data["product_name"]
                        });
                      } else {
                        $('#qty_id' + data["id"]).val(actualqty);
                    }
                } else {
                    addrow(data["id"], data["barcode"], data["product_name"], data["stock"], data["category"], data["date_of_receipt"], data["expiration_date"]);
                    productarr.push(data["id"]);
                }
                $("#txtbarcode_id").val("");
            }
        });
        $("#txtbarcode_id").val("");
    });

    // Event listener for save button
$(document).on('click', '.btnsave', function() {
    var id = $(this).data('id');
    var quantity = $('#qty_id' + id).val();
    

    $.ajax({
        url: "saveproduct_1.php",
        method: "post",
        data: { id: id, quantity: quantity },
        success: function(response) {
            // Reset the quantity to zero
            $('#qty_id' + id).val(0);
            // Set focus to the barcode input field
            $('#txtbarcode_id').focus();

            // Refresh the stock information
            refreshStock(id);

            // Show the success message
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Stock updated successfully!'
            });
               // Remove the current row
               
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error updating stock.'
            });
        }
    });
});

function refreshStock(id) {
    $.ajax({
        url: "getstock.php",
        method: "get",
        data: { id: id },
        success: function(response) {
            var data = JSON.parse(response);
            // Update the stock information on the page
            $('#stock_id' + id).text(data.stock);
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error fetching stock information.'
            });
        }
    });
}

function addrow(id, barcode, product_name, stock, category, date_of_receipt, expiration_date) {
    var tr = '<tr>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-primary" name="" id="' + id + '">' + barcode + '</span><input type="hidden" class="form-control" name="" id="' + id + '" value="' + barcode + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-primary " name="" id="' + id + '">' + product_name + '</span><input type="hidden" class="form-control " name="" id="' + id + '" value="' + product_name + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-primary stock_id" name="" id="stock_id' + id + '">' + stock + '</span><input type="hidden" class="form-control stock_id" name="" id="stock_id' + id + '" value="' + stock + '"></td>' +
        '<td><input type="text" class="form-control qty_id_c" name="" id="qty_id' + id + '" value="' + 1 + '" size="1"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-primary " name="" id="' + id + '">' + category + '</span><input type="hidden" class="form-control " name="" id="' + id + '" value="' + category + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-primary " name="" id="' + id + '">' + date_of_receipt + '</span><input type="hidden" class="form-control " name="" id="' + id + '" value="' + date_of_receipt + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-primary " name="" id="' + id + '">' + expiration_date + '</span><input type="hidden" class="form-control " name="" id="' + id + '" value="' + expiration_date + '"></td>' +
        '<td><center><button type="button" name="save" class="btn btn-success btn-sm btnsave" data-id="' + id + '"><span class="fas fa-save"></span></center></td>' +
        
        '<td><center><button type="button" name="delete" class="btn btn-danger btn-sm btndelete" data-id="' + id + '"><span class="fas fa-trash"></span></center></td>' +
        '</tr>';

        $('.details').append(tr);
    }
    // Event delegation for the delete button
$(document).on('click', '.btnsave', function () {
    // Find the row containing the delete button and remove it
    $(this).closest('tr').remove();
});

$(document).on('click', '.btndelete', function () {
    // Find the row containing the delete button and remove it
    $(this).closest('tr').remove();
});
});
</script>



