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

$vat = $_POST['txtvat'];

$seniordiscount = $_POST['txtseniordiscount'];

// $discount = $_POST['txtdiscount'];

if(empty($vat)){

    $_SESSION['status']="Feild is Empty";
    $_SESSION['status_code']="warning";



}else{

$insert=$pdo->prepare("insert into tbl_taxdis (vat, seniordiscount) values(:vat,:seniordiscount)");

$insert->bindParam(':vat',$vat);

$insert->bindParam(':seniordiscount',$seniordiscount);
// $insert->bindParam(':discount',$discount);

if($insert->execute()){
    $_SESSION['status']="Tax And Discount Added successfully";
    $_SESSION['status_code']="success";

}else{

    $_SESSION['status']="Failed";
    $_SESSION['status_code']="warning";
}
}}








if(isset($_POST['btnupdate'])){

 

  $vat = $_POST['txtvat'];

  $seniordiscount = $_POST['txtseniordiscount'];
  
//   $discount = $_POST['txtdiscount'];



  $id = $_POST['txtid'];
  
  if(empty($vat)){
  
      $_SESSION['status']=" Feild is Empty";
      $_SESSION['status_code']="warning";
  
  
  
  }else{
  
  $update=$pdo->prepare("update tbl_taxdis set vat=:vat,seniordiscount=:seniordiscount where taxdis_id=".$id);
  
 
  $update->bindParam(':vat',$vat);

  $update->bindParam(':seniordiscount',$seniordiscount);
//   $update->bindParam(':dis',$discount);



  
  if($update->execute()){
      $_SESSION['status']="Tax And Dis Update successfully";
      $_SESSION['status_code']="success";
  
  }else{
  
      $_SESSION['status']="Failed";
      $_SESSION['status_code']="warning";
  }
  }}


//   If(isset($_POST['btndelete'])){
   
//    $delete=$pdo->prepare("delete from tbl_category where catid=".$_POST['btndelete']); 

//    if($delete->execute()){
//     $_SESSION['status']="Deleted";
//     $_SESSION['status_code']="success";

//    }else{

//     $_SESSION['status']="Delete Failed";
//     $_SESSION['status_code']="warning";


//    }




//   }else{




//   }


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">TAX AND DISCOUNT</h1>
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
    
    <div class="card card-warning card-outline">
            <div class="card-header">
              <h5 class="m-0">Tax And Discount Form</h5>
            </div>

            
            <form action="" method="post">
            <div class="card-body">


<div class="row">


<?php

if(isset($_POST['btnedit'])){

$select=$pdo->prepare("select * from tbl_taxdis where taxdis_id =".$_POST['btnedit']);

$select->execute();

if($select){
$row=$select->fetch(PDO::FETCH_OBJ);

echo'<div class="col-md-4">


               
<div class="form-group">
 

  <input type="hidden" class="form-control" placeholder="Enter Category"  value="'.$row->taxdis_id.'" name="txtid" >







  <div class="form-group">
  <label for="exampleInputEmail1">VAT(%)</label>
  <input type="text" class="form-control" placeholder="Enter VAT" value="'.$row->vat.'" name="txtvat" >
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Senior Discount(%)</label>
  <input type="text" class="form-control" placeholder="Enter Senior Discount" value="'.$row->seniordiscount.'"  name="txtseniordiscount" >
</div>




  
</div>


<div class="card-footer">
<button type="submit" class="btn btn-info" name="btnupdate">Update</button>
</div>



</div>';




}





}else{

echo'<div class="col-md-4">


               


<div class="form-group">
  <label for="exampleInputEmail1">VAT(%)</label>
  <input type="text" class="form-control" placeholder="Enter VAT"  name="txtvat" >
</div>

<div class="form-group">
  <label for="exampleInputEmail1">Senior Discount(%)</label>
  <input type="text" class="form-control" placeholder="Enter Senior Discount"  name="txtseniordiscount" >
</div>




<div class="card-footer">
<button type="submit" class="btn btn-warning" name="btnsave">Save</button>
</div>



</div>';




}




?>



















<div class="col-md-8">

<table id="table_tax" class="table table-striped table-hover ">
<thead>
<tr>
 <td>#</td>
 <td>VAT</td>
 <td>Senior Discount</td>
 <!-- <td>Discount</td> -->
 <td>Edit</td>
 
 
</tr>

</thead>


<tbody>

<?php

$select = $pdo->prepare("select * from tbl_taxdis order by taxdis_id ASC");
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ))
{

echo'
<tr>
<td>'.$row->taxdis_id.'</td>
<td>'.$row->vat.'</td>
<td>'.$row->seniordiscount.'</td>



<td>

<button type="submit" class="btn btn-primary" value="'.$row->taxdis_id.'" name="btnedit">Edit</button>

</td>


</tr>';

}

?>

</tbody>


<tfoot>
<tr>
<td>#</td>
 <td>VAT</td>
 <td>Senior Discount</td>
 
 <td>Edit</td>
 
 
</tr>



</tfoot>


</table>




</div>


           

       
             
            </div>

         

            </div>
            </form>
          </div>
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


<script>

$(document).ready( function () {
    $('#table_tax').DataTable();
} );


</script>