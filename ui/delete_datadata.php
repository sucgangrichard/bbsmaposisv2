<?php
include 'conndb.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'delete') {
    $tables = ['tbl_invoice', 'tbl_invoice_details', 'tbl_product'];
    $success = true;

    try {
        $pdo->beginTransaction();

        foreach ($tables as $table) {
            $sql = "DELETE FROM $table";
            $stmt = $pdo->prepare($sql);
            if (!$stmt->execute()) {
                $success = false;
                break;
            }
        }

        if ($success) {
            $pdo->commit();
            echo json_encode(['success' => true]);
        } else {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Error deleting data']);
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Exception: ' . $e->getMessage()]);
    }
}
?>