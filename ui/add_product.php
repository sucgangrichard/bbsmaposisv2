
<?php
include_once "conndb.php";

session_start();

// Fetch data from tbl_product
$sql = "SELECT product_name, stock FROM tbl_product";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$donutData = array();
foreach ($products as $product) {
    $donutData[] = array(
        'label' => $product['product_name'],
        'data' => $product['stock']
    );
}

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

    <!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"></h1>
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
            <h5 class="m-0">Add Barcoding Stock Quantity</h5>
            
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
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

                    <div class="col-md-4">
                       
                    <div id="donut-chart" style="height: 300px;"></div>
                    <div style="text-align: center; margin: 20px;">
    <button class="btn btn-danger" onclick="confirmRefresh()">
        <i class="fa-solid fa-arrows-rotate"></i>
    </button>
</div>

<script>
function confirmRefresh() {
    Swal.fire({
        title: 'Save the data before you proceed!',
        text: "Data must saved before refreshing a page!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, refresh it!'
    }).then((result) => {
        if (result.isConfirmed) {
            refreshPage();
        }
    })
}

function refreshPage() {
    location.reload();
}   
</script>
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

  
  <?php include_once"footer.php";
  ?>


<script>
 var productarr = [];
var scanningDisabled = false;

$(function() {
    $('#txtbarcode_id').on('change', function() {
        if (scanningDisabled) {
            alert("Scanning is disabled due to an unrecognizable product.");
            return;
        }

        var barcode = $("#txtbarcode_id").val();
        $("#txtbarcode_id").val(""); // Clear the input field immediately

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
                    $('#qty_id' + data["id"]).val(actualqty);
                } else {
                    addrow(data["id"], data["barcode"], data["product_name"], data["stock"], data["category"], data["date_of_receipt"], data["expiration_date"]);
                    productarr.push(data["id"]);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error); // Debugging: log any AJAX errors
            }
        });
    });


    // Event listener for save button
$(document).on('click', '.btnsave', function() {
    var id = $(this).data('id');
    var quantity = $('#qty_id' + id).val();
    

    $.ajax({
        url: "saveproduct.php",
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
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-secondary" name="" id="' + id + '">' + barcode + '</span><input type="hidden" class="form-control" name="" id="' + id + '" value="' + barcode + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-secondary " name="" id="' + id + '">' + product_name + '</span><input type="hidden" class="form-control " name="" id="' + id + '" value="' + product_name + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-success stock_id" name="" id="stock_id' + id + '">' + stock + '</span><input type="hidden" class="form-control stock_id" name="" id="stock_id' + id + '" value="' + stock + '"></td>' +
        '<td ><input type="text" class="form-control qty_id_c " name="" id="qty_id' + id + '" value="' + 1 + '" size="1" style="width: 50px;" ></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-secondary " name="" id="' + id + '">' + category + '</span><input type="hidden" class="form-control " name="" id="' + id + '" value="' + category + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-warning " name="" id="' + id + '">' + date_of_receipt + '</span><input type="hidden" class="form-control " name="" id="' + id + '" value="' + date_of_receipt + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-info " name="" id="' + id + '">' + expiration_date + '</span><input type="hidden" class="form-control " name="" id="' + id + '" value="' + expiration_date + '"></td>' +
        '<td><center><button type="button" name="save" class="btn btn-success btn-sm btnsave" data-id="' + id + '"><span class="fas fa-save"></span></center></td>' +
        
        '<td><center><button type="button" name="delete" class="btn btn-danger btn-sm btndelete" data-id="' + id + '"><span class="fas fa-trash"></span></center></td>' +
        '</tr>';

        $('.details').append(tr);
// Add event listener to the quantity input field
$('#qty_id' + id).on('input', function() {
        if ($(this).val().length > 5) {
            $(this).val('');
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Barcode scanned into quantity field. Please scan again.'
            });
        }
    });
        
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

<script>
  // Function to fetch new data and update the donut chart
  function fetchDonutData() {
    fetch('path_to_your_data_endpoint.php')
      .then(response => response.json())
      .then(data => {
        // Update the donut chart with the new data
        $.plot('#donut-chart', data, {
          series: {
            pie: {
              show       : true,
              radius     : 1,
              innerRadius: 0.5,
              label      : {
                show     : true,
                radius   : 2 / 3,
                formatter: labelFormatter,
                threshold: 0.1
              }
            }
          }
        });
      })
      .catch(error => console.error('Error fetching donut data:', error));
  }

  // Call fetchDonutData every 5 seconds
  setInterval(fetchDonutData, 5000);

  $(document).ready(function() {
    // Initial plot
    $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.5,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }
        }
      }
    });

    // Start auto-refresh
    fetchDonutData();
  });
</script>

<script>
  function labelFormatter(label, series) {
    return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' +
      label + '<br>' + Math.round(series.percent) + '%</div>';
  }
</script>


<!-- FLOT CHARTS -->
<script src="../plugins/flot/jquery.flot.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="../plugins/flot/plugins/jquery.flot.resize.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="../plugins/flot/plugins/jquery.flot.pie.js"></script>