<?php
// Include the database connection
include 'conndb.php';

// Query to fetch product_name and stock
$stmt = $pdo->prepare("SELECT product_name, stock FROM tbl_product");
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format data for the donut chart
$donutData = [];
foreach ($data as $row) {
    $donutData[] = [
        'label' => $row['product_name'],
        'data' => $row['stock']
    ];
}

// Return data as JSON
echo json_encode($donutData);
?>