<?php
ob_start();
include_once 'conndb.php';
session_start();

date_default_timezone_set("Asia/Manila");

if($_SESSION['username']==""  OR $_SESSION['role']=="Admin"){

  header('location:../index.php');
  
  }


  if($_SESSION['role']=="User"){
    include_once'headeruser.php';
  }else{
  
    include_once'header.php';
  }


  // function fill_product($pdo){

  //   $output='';
  //   $select=$pdo->prepare("select * from tbl_mmenu order by product asc");
    
  //   $select->execute();
    
  //   $result=$select->fetchAll();
    
  //   foreach($result as $row){
  //   $output.='<option value="'.$row["pid"].'">'.$row["product"].'</option>';
    
  //   }
    
  //   return $output; 
    
  //   }

  function fill_chao_fan_category($pdo) {
    $output = '';
    $select = $pdo->prepare("SELECT * FROM tbl_mmenu WHERE category = 'Chao Fan' ORDER BY product_name ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
      $output .= '<option value="' . $row["menu_id"] . '">' . $row["product_name"] . '</option>';
    }
    return $output;
  }

  function fill_noodle_soup_category($pdo) {
    $output = '';
    $select = $pdo->prepare("SELECT * FROM tbl_mmenu WHERE category = 'Noodles Soup' ORDER BY product_name ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
      $output .= '<option value="' . $row["menu_id"] . '">' . $row["product_name"] . '</option>';
    }
    return $output;
  }

  function fill_drinks_category($pdo) {
    $output = '';
    $select = $pdo->prepare("SELECT * FROM tbl_mmenu WHERE category = 'Drinks' ORDER BY product_name ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
      $output .= '<option value="' . $row["menu_id"] . '">' . $row["product_name"] . '</option>';
    }
    return $output;
  }

  function fill_siopao_dimsum_category($pdo) {
    $output = '';
    $select = $pdo->prepare("SELECT * FROM tbl_mmenu WHERE category = 'Siopao Dimsum' ORDER BY product_name ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
      $output .= '<option value="' . $row["menu_id"] . '">' . $row["product_name"] . '</option>';
    }
    return $output;
  }

  function fill_rice_meals_category($pdo) {
    $output = '';
    $select = $pdo->prepare("SELECT * FROM tbl_mmenu WHERE category = 'Rice Meals' ORDER BY product_name ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
      $output .= '<option value="' . $row["menu_id"] . '">' . $row["product_name"] . '</option>';
    }
    return $output;
  }

  function fill_sdish_dessert_category($pdo) {
    $output = '';
    $select = $pdo->prepare("SELECT * FROM tbl_mmenu WHERE category = 'Sdish Dessert' ORDER BY product_name ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
      $output .= '<option value="' . $row["menu_id"] . '">' . $row["product_name"] . '</option>';
    }
    return $output;
  }

  function fill_breakfast_category($pdo) {
    $output = '';
    $select = $pdo->prepare("SELECT * FROM tbl_mmenu WHERE category = 'BreakFast' ORDER BY product_name ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
      $output .= '<option value="' . $row["menu_id"] . '">' . $row["product_name"] . '</option>';
    }
    return $output;
  }

  function fill_milksha_category($pdo) {
    $output = '';
    $select = $pdo->prepare("SELECT * FROM tbl_mmenu WHERE category = 'MilkSha' ORDER BY product_name ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
      $output .= '<option value="' . $row["menu_id"] . '">' . $row["product_name"] . '</option>';
    }
    return $output;
  }

  function fill_lauriat_family_category($pdo) {
    $output = '';
    $select = $pdo->prepare("SELECT * FROM tbl_mmenu WHERE category = 'Lauriat Family' ORDER BY product_name ASC");
    $select->execute();
    $result = $select->fetchAll();
    foreach ($result as $row) {
      $output .= '<option value="' . $row["menu_id"] . '">' . $row["product_name"] . '</option>';
    }
    return $output;
  }


    

    if(isset($_POST['btnsaveorder'])){
      $orderdate=date('Y-m-d');
      $time_value = date('H:i:s');


      $table_number=$_POST['txttable_number'];
      $subtotal=$_POST['txtsubtotal'];
      $change=$_POST['txtchange'];
      $paid=$_POST['txtpaid'];
      $payment_type=$_POST['rb'];
      $vatablesales=$_POST['txtvatablesales'];
      $vatamount=$_POST['txtvatamount'];
      $dinein = $_POST['txtdine_in'];

      // $arr_menu_id = $_POST['menu_id_arr'];//menu_id
      // $arr_product_name = $_POST['product_arr'];//product_name
      // $arr_qty = $_POST['quantity_arr']; //qty
      // $arr_total_per_item = $_POST['saleprice_arr']; //total_per_qty
      // $arr_available = $_POST['available_c_arr']; //available
      //table_number

      // Check if arrays are set and not null before accessing them
$arr_menu_id = isset($_POST['menu_id_arr']) ? $_POST['menu_id_arr'] : [];
$arr_product_name = isset($_POST['product_arr']) ? $_POST['product_arr'] : [];
$arr_qty = isset($_POST['quantity_arr']) ? $_POST['quantity_arr'] : [];
$arr_total_per_item = isset($_POST['saleprice_arr']) ? $_POST['saleprice_arr'] : [];
$arr_available = isset($_POST['available_c_arr']) ? $_POST['available_c_arr'] : [];

// Check if arrays are not null before using count()
if (is_array($arr_menu_id) && is_array($arr_product_name) && is_array($arr_qty) && is_array($arr_total_per_item) && is_array($arr_available)) {
    $count = count($arr_menu_id); // Example usage of count()
    // Your code logic here
} else {
    // Handle the case where arrays are not set or not arrays
    echo "One or more required arrays are not set or not valid arrays.";
}

      $insert=$pdo->prepare("insert into tbl_invoice (total_due, change_amount, paid, payment_type, vatable_sales, vat_amount, order_date, table_number, dine_in, time_value) values(:total_due, :change_amount, :paid, :payment_type, :vatable_sales, :vat_amount, :order_date, :table_number, :dine_in, :time_value)");
$insert->bindParam(':total_due', $subtotal);
$insert->bindParam(':change_amount', $change);
$insert->bindParam(':paid', $paid);
$insert->bindParam(':payment_type', $payment_type);
$insert->bindParam(':vatable_sales', $vatablesales);
$insert->bindParam(':vat_amount', $vatamount);
$insert->bindParam(':order_date', $orderdate);
$insert->bindParam(':table_number', $table_number);
$insert->bindParam(':time_value', $time_value);

$insert->bindParam(':dine_in', $dinein);
      $insert->execute();
      // var_dump($arr_total_per_item);


      $invoice_id = $pdo->lastInsertId();
      if($invoice_id!=null){
        for($i=0;$i<count($arr_menu_id);$i++){
$rem_qty = $arr_available[$i] - $arr_qty[$i];
        if($rem_qty<0){
          return"order is not available";
        }else{
          $update=$pdo->prepare("update tbl_mmenu set available='$rem_qty' where menu_id='".$arr_menu_id[$i]."'");
          $update->execute();
        }

        $insert=$pdo->prepare("insert into tbl_invoice_details (invoice_id, menu_id, product_name, qty, total_per_qty, table_number,order_date, time_value) values(:invoice_id, :menu_id, :product_name, :qty, :total_per_qty, :table_number, :order_date, :time_value)");
        $insert->bindParam(':invoice_id', $invoice_id);
        $insert->bindParam(':menu_id', $arr_menu_id[$i]);
        $insert->bindParam(':product_name', $arr_product_name[$i]);
        $insert->bindParam(':qty', $arr_qty[$i]);
        $insert->bindParam(':total_per_qty', $arr_total_per_item[$i]);
        $insert->bindParam(':order_date', $orderdate);
        $insert->bindParam(':table_number', $table_number);
        $insert->bindParam(':time_value', $time_value);
        if(!$insert->execute()){
          print_r($insert->errorInfo());
        }

      }
      header('location:user_orderlist.php');
    }
  }
  ob_end_flush();
    $select=$pdo->prepare("select * from tbl_taxdis where taxdis_id =1");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);


?>
<style type="text/css">

.tableFixHead{
overflow: scroll;
overflow: auto;
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
        

        <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">Add Order</h5>
            </div>
            <div class="card-body">
              <!-- <h6 class="card-title">Special title treatment</h6>

              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a> -->
              <div class="row">
              <div class="col-md-8">
              <form action="" method="post" name="">

                <div class="row">

                <div class="col-md-4"style="background-color: #DEAA79;">

                
                  
                <div class="form-group">
                  <label> Noodles Soup</label>
                  <select class="form-control select2bs4 select2 " id="select3" style="width: 100%;">
                  <option disabled selected>Select Noodles Soup</option><?php echo fill_noodle_soup_category($pdo);?>
                  </select>
                </div>
                </div>
                


                <div class="col-md-4" style="background-color: #FFE6A9;">

                <div class="form-group">
                  <label>Siopao Dimsum</label>
                  <select class="form-control select2bs4 select2" id="select4"  style="width: 100%;">
                  <option disabled selected>Select Siopao Dimsum</option><?php echo fill_siopao_dimsum_category($pdo);?>
                    
                  </select>
                </div>
                </div>

                <div class="col-md-4"style="background-color: #B1C29E;">

                <div class="form-group">
                  <label>Sdish Dessert</label>
                  <select class="form-control select2bs4 select2" id="select5" style="width: 100%;">
                  <option disabled selected>Select Sdish Dessert</option><?php echo fill_sdish_dessert_category($pdo);?>
                  </select>
                </div>
                </div>
                </div>

                <div class="row">

                <div class="col-md-4"style="background-color: #659287;">

                <div class="form-group">
                  <label> Chao Fan</label>
                  <select class="form-control select2bs4 select2" id="select6" style="width: 100%;">
                  <option disabled selected>Select Chao fan</option><?php echo fill_chao_fan_category($pdo);?>
                  </select>
                </div>
                </div>
                


                <div class="col-md-4" style="background-color: #FFF8E8;">

                <div class="form-group">
                  <label>Rice Meals</label>
                  <select class="form-control select2bs4 select2" id="select2" style="width: 100%;">
                  <option disabled selected>Select Rice Meals</option><?php echo fill_rice_meals_category($pdo);?>
                    
                  </select>
                </div>
                </div>

                <div class="col-md-4"style="background-color: #674636;">

                <div class="form-group">
                  <label>BreakFast</label>
                  <select class="form-control select2bs4 select2" id="select7" style="width: 100%;">
                  <option disabled selected>Select BreakFast</option><?php echo fill_breakfast_category($pdo);?>
                  </select>
                </div>
                </div>
                </div>

                <div class="row">

                <div class="col-md-4"style="background-color: #DE8F5F;">

                <div class="form-group">
                  <label> Drinks</label>
                  <select class="form-control select2bs4 select2" id="select8" style="width: 100%;">
                  <option disabled selected>Select Drinks</option><?php echo fill_drinks_category($pdo);?>
                  </select>
                </div>
                </div>
                


                <div class="col-md-4" style="background-color: #FFB38E;">

                <div class="form-group">
                  <label>Lauriat Family</label>
                  <select class="form-control select2bs4 select2" id="select9" style="width: 100%;">
                  <option disabled selected>Select Lauriat Family</option><?php echo fill_lauriat_family_category($pdo);?>
                    
                  </select>
                </div>
                </div>

                <div class="col-md-4"style="background-color: #E6D9A2;">

                <div class="form-group" >
                  <label>MilkSha</label>
                  <select class="form-control select2bs4 select2" id="select10" style="width: 100%;">
                  <option disabled selected>Select Milksha</option><?php echo fill_milksha_category($pdo);?>
                  </select>
                </div>
                </div>
                </div>
                
<br>
                <div class="tableFixHead">


<table id="producttable" class="table table-bordered table-hover">
<thead>
<tr>
 <th>Qty#</th>
 <th>Product Name  </th>
 <th>Avail.  </th>
 <th>Price  </th> 
 <th>Total  </th> 
 <th>Action </th>
    
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
              <!-- <input type="hidden" class="form-control" name="txtdine_in"  id="txtdine_in_id" value="Dine-In" > -->

              <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Table Number</span>
                  </div>
                  <input type="number" class="form-control" name="txttable_number"  id="txttable_number_id" placeholder="Enter Table#" required >
                  <div class="input-group-append">
                    <span class="input-group-text">#</span>
                  </div>
                </div>
                <hr style="height:2px; border-width:0; color:black; background-color:black;">
              <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Total Due</span>
                  </div>
                  <input type="text" class="form-control" name="txtsubtotal"  id="txtsubtotal_id" readonly >
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>

                <!-- <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">TOTAL DUE</span>
                  </div>
                  <input type="text" class="form-control" name="txtsubtotal"  id="" readonly >
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div> -->

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">CHANGE</span>
                  </div>
                  <input type="text" class="form-control" name="txtchange"  id="txtchange_id" readonly >
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>

                <hr style="height:2px; border-width:0; color:black; background-color:black;">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">PAID</span>
                  </div>
                  <input type="number" class="form-control" name="txtpaid"  id="txtpaid_id" placeholder="Enter Amount ₱" required>
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>

                <hr style="height:2px; border-width:0; color:black; background-color:black;">

                <div class="icheck-success d-inline">
                        <input type="radio" name="rb" value="Cash" checked id="radioSuccess1">
                        <label for="radioSuccess1">
                            CASH
                        </label>
                      </div>

                      <div class="icheck-warning d-inline">
                        <input type="radio" name="rb" value="Gcash" id="radioSuccess2">
                        <label for="radioSuccess2">
                          Gcash
                        </label>
                      </div>

                      <div class="icheck-primary d-inline">
                        <input type="radio" name="rb" value="Maya" id="radioSuccess3">
                        <label for="radioSuccess3">
                          Maya
                        </label>
                      </div>
                      
                      <div class="icheck-danger d-inline">
                        <input type="radio" name="rb" value="Debit/Credit" id="radioSuccess4">
                        <label for="radioSuccess4">
                          Debit/Credit
                        </label>
                      </div>

                      <hr style="height:2px; border-width:0; color:black; background-color:black;">

                      <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">VAT Rate%</span>
                  </div>
                  <input type="text" class="form-control" name="txtvatrate"  id="txtvatrate_id" value="<?php echo $row->vat?>" readonly >
                  <div class="input-group-append">
                    <span class="input-group-text">%</span>
                  </div>
                </div>  

                      <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">VATable Sales</span>
                  </div>
                  <input type="text" class="form-control" name="txtvatablesales"  id="txtvatablesales_id" readonly >
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>

                


                <!-- <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">VAT-Exempt Sales</span>
                  </div>
                  <input type="text" class="form-control" name="txtsubtotal"  id="txtsubtotal_id" readonly >
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div> -->

                <!-- <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">VAT Zero-Rated Sales</span>
                  </div>
                  <input type="text" class="form-control" name="txtsubtotal"  id="txtsubtotal_id" readonly >
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div> -->

                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">VAT Amount</span>
                  </div>
                  <input type="text" class="form-control" name="txtvatamount"  id="txtvatamount_id" readonly >
                  <div class="input-group-append">
                    <span class="input-group-text">₱</span>
                  </div>
                </div>
                <hr style="height:2px; border-width:0; color:black; background-color:black;">

                <div class="col-md-12">
              

                <div class="row">
                <div class="col-md-12"style="background-color: #89A8B2;">

                
                  
                <div class="form-group text-center">
                <label>Dine-In OR Take-Out</label>
            <select class="form-control select2bs4 select2" style="width: 100%;" name="txtdine_in" id="txtdine_in_id" required>
            <option value="" disabled selected>Select Category</option>
            <?php
$select=$pdo->prepare("select * from tbl_do_category order by do_cat_id desc");
$select->execute();

while($row=$select->fetch(PDO::FETCH_ASSOC))
{
extract($row);

?>
<option><?php echo $row['do'];?></option>

<?php

}

?>
            </select>
                </div>
                </div>
                </div>
                </div>
                <hr style="height:2px; border-width:0; color:black; background-color:black;">
                <div class="card-footer">

                


<div class="text-center">
  <button type="submit" class="btn btn-success" name="btnsaveorder">
    <i class="fas fa-check"></i> Save order
  </button>
</div>
                </div>
              </div>
              </div>
              
            </div>
          </div>
     
          </form>
       
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
 
  //Initialize Select2 Elements
  $('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})
</script>

<script>


  var productarr=[];

$(function() {

  $('#select2, #select3, #select4, #select5, #select6, #select7, #select8, #select9, #select10').on('change', function() {
    var menu_id = $(this).val();




$.ajax({
        url: "getmenu.php",
        method: "get",
        dataType: "json",
        data: { id: menu_id },
        success: function(data) {
//alert("pid");

//console.log(data);


if(jQuery.inArray(data["menu_id"],productarr)!== -1){

  var actualqty = parseInt($('#qty_id'+data["menu_id"]).val())+1;
  $('#qty_id'+data["menu_id"]).val(actualqty);

  var saleprice=parseInt(actualqty)*data["saleprice"];

  $('#saleprice_id'+data["menu_id"]).html(saleprice);
  $('#saleprice_idd'+data["menu_id"]).val(saleprice);

  calculate();

  //$("#txtbarcode_id").val("");

  // calculate(0,0);
}else{

  addrow(data["menu_id"], data["product_name"], data["available"], data["price"]);

productarr.push(data["menu_id"]);

function addrow(menu_id, product_name, available, price) {
    var tr = '<tr>' +
        '<td>' +
        '<div class="input-group">' +
        '<div class="input-group-prepend">' +
        '<button class="btn btn-outline-secondary btn-minus" type="button" data-id="' + menu_id + '">-</button>' +
        '</div>' +
        '<input type="text" class="form-control qty" name="quantity_arr[]" id="qty_id' + menu_id + '" value="'+1+'" size="1">' +
        '<div class="input-group-append">' +
        '<button class="btn btn-outline-secondary btn-plus" type="button" data-id="' + menu_id + '">+</button>' +
        '</div>' +
        '</div>' +
        '</td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><class="form-control product_name_c" name="product_arr[]" <span class="badge badge-dark">' + product_name + '</span><input type="hidden" class="form-control menu_id" name="menu_id_arr[]" value="' + menu_id + '" ><input type="hidden" class="form-control product_name" name="product_arr[]" value="' + product_name + '" >  </td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-primary availablelbl" name="available_arr[]" id="available_id' + menu_id + '">' + available + '</span><input type="hidden" class="form-control available_c" name="available_c_arr[]" id="available_idd' + menu_id + '" value="' + available + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-warning price" name="price_arr[]" id="price_id' + menu_id + '">' + price + '</span><input type="hidden" class="form-control price_c" name="price_c_arr[]" id="price_idd' + menu_id + '" value="' + price + '"></td>' +
        '<td style="text-align:left; vertical-align:middle; font-size:17px;"><span class="badge badge-success totalamt" name="netamt_arr[]" id="saleprice_id' + menu_id + '">' + price + '</span><input type="hidden" class="form-control saleprice" name="saleprice_arr[]" id="saleprice_idd' + menu_id + '" value="' + price + '"></td>' +
        '<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove" data-id="' + menu_id + '"><span class="fas fa-trash"></span></center></td>' +
        '</tr>';

    $('.details').append(tr);
    calculate();

    // Add event listener for quantity change
    $('#qty_id' + menu_id).on('input', function() {
        var quantity = $(this).val();
        var total = quantity * price;
        $('#saleprice_id' + menu_id).text(total);
        $('#saleprice_idd' + menu_id).val(total);
        calculate()
    });

    // Add event listeners for plus and minus buttons
    $('.btn-minus[data-id="' + menu_id + '"]').on('click', function() {
        var qtyInput = $('#qty_id' + menu_id);
        var currentQty = parseInt(qtyInput.val());
        if (currentQty > 1) {
            qtyInput.val(currentQty - 1).trigger('input');
        }
        calculate()
    });

    $('.btn-plus[data-id="' + menu_id + '"]').on('click', function() {
    var qtyInput = $('#qty_id' + menu_id);
    var currentQty = parseInt(qtyInput.val());
    var availableQty = parseInt($(this).closest('tr').find('.available_c').val());

    if (currentQty < availableQty) {
        qtyInput.val(currentQty + 1).trigger('input');
        if (currentQty + 1 === availableQty) {
            Swal.fire("Info", "You have reached the available stock limit", "info");
            // $(this).prop('disabled', true); // Disable the button
        }
    } else {
        Swal.fire("Warning", "Quantity is greater than available stock", "warning");
    }
    calculate();
});

     // Event delegation for the delete button
$(document).on('click', '.btnremove', function () {
    // Find the row containing the delete button and remove it
    $(this).closest('tr').remove();
    calculate();
});
}//end function addrow

}
// $("#txtbarcode_id").val("");
}   // end of success function
})  // end of ajax request
})  // end of onchange function
}); // end of main function

$("#itemtable").delegate(".qty", "keyup change", function() {
  var quantity = $(this);
  var tr = $(this).closest('tr');

  if ((quantity.val() - 0) > (tr.find('.available_c').val() - 0)) {
    Swal.fire("Warning", "Quantity is greater than available stock", "warning");
    quantity.val(tr.find('.available_c').val());
  } else {
    // You can add any additional logic here if needed
  }
});


function calculate(){

var subtotal=0;
var total=0;
var change=0;

var paid=0;

var vat=0;
var vatablesales=0;
var vatamount1=0;
var vatamount2=0;

$(".saleprice").each(function(){
subtotal=subtotal+($(this).val()*1);
});

$("#txtsubtotal_id").val(subtotal.toFixed(2));

// vat=parseFloat($("#txtvatablesales_id").val());

// vat=vat/100 + 1;
// vat=subtotal*vat; 

// $("#txtvatablesales_id").val(vat.toFixed(2));
vat = parseFloat($("#txtvatrate_id").val());
vat2 = parseFloat($("#txtvatrate_id").val());

vat = vat / 100 + 1;
vatablesales = subtotal / vat;

vatamount1 = vat2 / 100;
vatamount2 = vatablesales * vatamount1;

paid = parseFloat($("#txtpaid_id").val()) || 0;
change = paid - subtotal;
$("#txtchange_id").val(change.toFixed(2));
$("#txtpaid_id").on('input', function() {
  calculate();
});


$("#txtvatablesales_id").val(vatablesales.toFixed(2));
$("#txtvatamount_id").val(vatamount2.toFixed(2));

// vatamount = vat / 100;
// vatamount = vatablesales * vatamount;
// $("#txtvatamount_id").val(vatamount.toFixed(2));

// vatamount = vat / 100;
// vatamount = subtotal * vatamount;
// $("#txtvatamount_id").val(vatablesales.toFixed(2));


} 

</script>