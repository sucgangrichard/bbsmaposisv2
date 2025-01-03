<?php
require 'conndb.php'; // Ensure this file includes the $pdo connection

// Check low stock in tbl_product
$sqlProduct = "SELECT COUNT(*) as lowStockCount FROM tbl_product WHERE stock < 10";
$resultProduct = $pdo->query($sqlProduct);
$rowProduct = $resultProduct->fetch(PDO::FETCH_ASSOC);
$lowStockCountProduct = $rowProduct['lowStockCount'];

// Check low stock in tbl_mmenu
$sqlMenu = "SELECT COUNT(*) as lowStockCount FROM tbl_mmenu WHERE available < 10";
$resultMenu = $pdo->query($sqlMenu);
$rowMenu = $resultMenu->fetch(PDO::FETCH_ASSOC);
$lowStockCountMenu = $rowMenu['lowStockCount'];

// Combine results
$lowStockCount = $lowStockCountProduct + $lowStockCountMenu;
$response = ['lowStockCount' => $lowStockCount, 'hasLowStock' => $lowStockCount > 0];

echo json_encode($response);
?>