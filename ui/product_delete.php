<?php
include_once'conndb.php';



$id=$_POST['pidd'];
$sql="delete from tbl_product where id =$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){

}else{

    echo"Error in deleting product";
}




?>