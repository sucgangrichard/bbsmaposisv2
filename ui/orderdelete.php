<?php

include_once'conndb.php';


$id=$_POST['pidd'];


$select=$pdo->prepare("select * from tbl_invoice_details where invoice_id=$id");
$select->execute();
$row_invoice_details=$select->fetchAll(PDO::FETCH_ASSOC);

foreach($row_invoice_details as $product_invoice_details){

    $updateproduct_stock=$pdo->prepare("update tbl_mmenu set available=available+".$product_invoice_details['qty']." where menu_id='".$product_invoice_details['menu_id']."'");
    $updateproduct_stock->execute();
    
    }




$sql="delete tbl_invoice,tbl_invoice_details from tbl_invoice INNER JOIN tbl_invoice_details ON tbl_invoice.invoice_id = tbl_invoice_details.invoice_id WHERE tbl_invoice.invoice_id=$id";

$delete=$pdo->prepare($sql);


if($delete->execute()){


}else{

echo'error: Failed to delete';

}




?>