<?php
include_once 'conndb.php';
session_start();

if ($_SESSION['username'] == "" || $_SESSION['role'] == "User") {
    header('location:../index.php');
    exit();
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=stock_list.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Barcode', 'Product', 'Category', 'Quantity', 'Packaging Type', 'Received By', 'Date of Receipt', 'Expiration Date', 'Image')); // Add your column headers here

$query =$pdo->query( 'SELECT id, barcode, product_name,category,stock,packaging_type,received_by,date_of_receipt,expiration_date,product_image FROM tbl_product'); // Adjust your query to match your table

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>