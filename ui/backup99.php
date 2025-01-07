<?php
require 'conndb.php'; // Include the PDO connection

// List of tables to backup
$tables = [
    'email_settings', 'notification_log', 'notification_settings', 'tbl_category', 
    'tbl_do_category', 'tbl_invoice', 'tbl_invoice_details', 'tbl_menu_category', 
    'tbl_mmenu', 'tbl_product', 'tbl_taxdis', 'tbl_user', 'time_records'
];

// Initialize variable to hold SQL script
$sqlScript = "";

// Loop through each table
foreach ($tables as $table) {
    // Get CREATE TABLE statement
    $query = $pdo->query("SHOW CREATE TABLE $table");
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $sqlScript .= "\n\n" . $row['Create Table'] . ";\n\n";

    // Get table data
    $query = $pdo->query("SELECT * FROM $table");
    $columnCount = $query->columnCount();

    // Loop through each row of data
    while ($row = $query->fetch(PDO::FETCH_NUM)) {
        $sqlScript .= "INSERT INTO $table VALUES(";
        for ($j = 0; $j < $columnCount; $j++) {
            $row[$j] = $row[$j] ? addslashes($row[$j]) : "NULL";
            $sqlScript .= '"' . $row[$j] . '"';
            if ($j < ($columnCount - 1)) {
                $sqlScript .= ',';
            }
        }
        $sqlScript .= ");\n";
    }

    $sqlScript .= "\n";
}

// Save the SQL script to a backup file
$backupFileName = 'db-backup-' . time() . '.sql';
$fileHandler = fopen($backupFileName, 'w+');
fwrite($fileHandler, $sqlScript);
fclose($fileHandler);

// Download the SQL backup file
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($backupFileName));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($backupFileName));
readfile($backupFileName);

// Delete the backup file from the server
unlink($backupFileName);
// Return success response
echo json_encode(['status' => 'success', 'file' => $backupFileName]);
exit;
?>