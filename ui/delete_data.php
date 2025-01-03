<?php
include_once 'conndb.php';
session_start();

if ($_SESSION['username'] == "" || $_SESSION['role'] != "Admin") {
    header('location:../index.php');
    exit();
}

if (isset($_POST['delete'])) {
    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Delete from the first table
        $sql1 = "DELETE FROM tbl_mmenu"; // Replace 'tbl_mmenu' with the actual table name
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute();

        // Delete from the second table
        $sql2 = "DELETE FROM tbl_product"; // Replace 'table2' with the actual table name
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute();

        // Delete from the third table
        $sql3 = "DELETE FROM tbl_invoice"; // Replace 'table3' with the actual table name
        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute();

        // Delete from the fourth table
        $sql4 = "DELETE FROM tbl_invoice_details"; // Replace 'table4' with the actual table name
        $stmt4 = $pdo->prepare($sql4);
        $stmt4->execute();

        // Commit the transaction
        $pdo->commit();
        echo "Data deleted successfully";
    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $pdo->rollBack();
        echo "Error deleting data: " . $e->getMessage();
    }

    header('location:backup.php');
    exit();
}
?>