<?php
include_once'conndb.php';



$id=$_POST['pidd'];
$sql="delete from tbl_mmenu where menu_id =$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){

}else{

    echo"Error in deleting product";
}




?>