<?php
include_once "conndb.php"; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    try {
        // Prepare the SQL statement to update the stock
        $sql = $pdo->prepare("UPDATE tbl_product SET stock = stock + ? WHERE id = ?");
        $sql->execute([$quantity, $id]);

        // Check if the update was successful
        if ($sql->rowCount() > 0) {
            echo "Stock updated successfully!";
        } else {
            echo "No changes made to the stock.";
        }
    } catch (PDOException $e) {
        echo "Error updating stock: " . $e->getMessage();
    }
}
?>