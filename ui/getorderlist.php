<?php
include_once'conndb.php';
$id=$_GET['id'];

$select=$pdo->prepare("select * from tbl_invoice_details a INNER JOIN tbl_mmenu b ON a.menu_id=b.menu_id where a.invoice_id=$id");
$select->execute();

$row_invoice_details=$select->fetchAll(PDO::FETCH_ASSOC);

$response=$row_invoice_details;

header('Content-Type: application/json');

echo json_encode($response);

?>