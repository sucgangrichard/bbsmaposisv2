<?php

include_once'conndb.php';

$menu_id=$_GET["id"];

$product_name=$_GET["id"];

$select=$pdo->prepare("select * from tbl_mmenu where menu_id=$menu_id OR product_name=$product_name");
$select->execute();

$row=$select->fetch(PDO::FETCH_ASSOC);

$response=$row;

header('Content-Type: application/json');

echo json_encode($response);





?>