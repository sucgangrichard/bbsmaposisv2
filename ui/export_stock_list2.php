<?php
// Include the database connection file
include 'conndb.php';

try {
    // Fetch data from database
    $sql = "SELECT 
    tbl_invoice_details.order_date,
    tbl_invoice.time_value, 
    tbl_invoice.invoice_id, 
    tbl_invoice.table_number,
    tbl_invoice.dine_in,
    SUM(tbl_invoice_details.qty) as total_qty,
    -- tbl_invoice_details.product_name, 
   
    -- tbl_mmenu.price,
    -- tbl_invoice_details.total_per_qty,
    tbl_invoice.total_due,
    tbl_invoice.paid,
    tbl_invoice.change_amount,
    tbl_invoice.payment_type,
    tbl_invoice.vatable_sales,
    tbl_invoice.vat_amount
    

            FROM tbl_invoice
            JOIN tbl_invoice_details ON tbl_invoice.invoice_id = tbl_invoice_details.invoice_id
            JOIN tbl_mmenu ON tbl_invoice_details.product_name = tbl_mmenu.product_name
             GROUP BY 
                tbl_invoice.invoice_id";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Order_list.csv');

$output = fopen('php://output', 'w');


    // Write the column headers
    fputcsv($output, array('Date','Time', 'Invoice ID', 'Table Number', 'Dine/Out' ,'Quantity', 'Total Due', 'Paid','Change Amount','Payment Type','VATable Sales','VAT amount'));

    // Write the rows
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }

    fclose($output);
    // echo "Data has been exported to order_list.csv";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>