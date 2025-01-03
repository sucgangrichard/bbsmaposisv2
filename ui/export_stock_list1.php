<?php
include_once 'conndb.php';
session_start();

if ($_SESSION['username'] == "" || $_SESSION['role'] == "User") {
    header('location:../index.php');
    exit();
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Menu_list.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Product', 'Category', 'Quantity/Available#', 'Price', 'Date','Endorsed by', 'Image')); // Add your column headers here

$query =$pdo->query( 'select menu_id, product_name,category,available,price,updated_date, approved_by, image from tbl_mmenu'); // Adjust your query to match your table

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

fclose($output);
?>