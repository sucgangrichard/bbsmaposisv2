<?php

include_once'conndb.php';

$product_id=$_GET["id"];

$barcode=$_GET["id"];

$select=$pdo->prepare("select * from tbl_product where product_id=$product_id OR barcode=$barcode");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$response=$row;

header('Content-Type: application/json');

echo json_encode($response);





?>