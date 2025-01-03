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

$category = $_POST['txtcategory'];

if(empty($category)){

    $_SESSION['status']="Category Field is Empty";
    $_SESSION['status_code']="warning";



}else{

$insert=$pdo->prepare("insert into tbl_menu_category (category) values(:category)");

$insert->bindParam(':category',$category);

if($insert->execute()){
    $_SESSION['status']="Category Added successfully";
    $_SESSION['status_code']="success";

}else{

    $_SESSION['status']="Category Added Failed";
    $_SESSION['status_code']="warning";
}
}}








if(isset($_POST['btnupdate'])){

  $category = $_POST['txtcategory'];
  $id = $_POST['txtcategory_id'];
  
  if(empty($category)){
  
      $_SESSION['status']="Category Field is Empty";
      $_SESSION['status_code']="warning";
  
  
  
  }else{
  
  $update=$pdo->prepare("update tbl_menu_category set category=:category where menu_cat_id=".$id);
  
  $update->bindParam(':category',$category);
  
  if($update->execute()){
      $_SESSION['status']="Category Update successfully";
      $_SESSION['status_code']="success";
  
  }else{
  
      $_SESSION['status']="Category Update Failed";
      $_SESSION['status_code']="warning";
  }
  }}


  If(isset($_POST['btndelete'])){
   
   $delete=$pdo->prepare("delete from tbl_menu_category where menu_cat_id=".$_POST['btndelete']); 

   if($delete->execute()){
    $_SESSION['status']="Deleted";
    $_SESSION['status_code']="success";

   }else{

    $_SESSION['status']="Delete Failed";
    $_SESSION['status_code']="warning";


   }




  }else{




  }


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Category</h1>
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
              <h5 class="m-0">Category Form</h5>
            </div>

            
            <form action="" method="post">
            <div class="card-body">


<div class="row">


<?php

if(isset($_POST['btnedit'])){

$select=$pdo->prepare("select * from tbl_menu_category where menu_cat_id =".$_POST['btnedit']);

$select->execute();

if($select){
$row=$select->fetch(PDO::FETCH_OBJ);

echo'<div class="col-md-4">


               
<div class="form-group">
  <label for="exampleInputEmail1">Category</label>

  <input type="hidden" class="form-control" placeholder="Enter Category"  value="'.$row->menu_cat_id.'" name="txtcategory_id" >

  <input type="text" class="form-control" placeholder="Enter Category"  value="'.$row->category.'" name="txtcategory" >
</div>


<div class="card-footer">
<button type="submit" class="btn btn-info" name="btnupdate">Update</button>
</div>



</div>';




}





}else{

echo'<div class="col-md-4">


               
<div class="form-group">
  <label for="exampleInputEmail1">Category</label>
  <input type="text" class="form-control" placeholder="Enter Category"  name="txtcategory" >
</div>


<div class="card-footer">
<button type="submit" class="btn btn-warning" name="btnsave">Save</button>
</div>



</div>';




}




?>



















<div class="col-md-8">

<table id="table_category" class="table table-striped table-hover ">
<thead>
<tr>
 <td>#</td>
 <td>Category</td>
 <td>Edit</td>
 <td>Delete</td>
 
</tr>

</thead>


<tbody>

<?php

$select = $pdo->prepare("select * from tbl_menu_category order by menu_cat_id ASC");
$select->execute();

while($row=$select->fetch(PDO::FETCH_OBJ))
{

echo'
<tr>
<td>'.$row->menu_cat_id.'</td>
<td>'.$row->category.'</td>

<td>

<button type="submit" class="btn btn-primary" value="'.$row->menu_cat_id.'" name="btnedit">Edit</button>

</td>

<td>

<button type="submit" class="btn btn-danger" value="'.$row->menu_cat_id.'" name="btndelete">Delete</button>

</td>

</tr>';

}

?>

</tbody>


<!-- <tfoot> -->
<!-- <tr>
 <td>#</td>
 <td>Category</td>
 <td>Edit</td>
 <td>Delete</td>
 
</tr> -->



<!-- </tfoot> -->


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
    $('#table_category').DataTable();
} );


</script>