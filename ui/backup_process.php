<?php
session_start();
require 'conndb.php';

if ($_POST['action'] == 'backup') {
    try {
        // Get all tables
        $tables = array();
        $result = $pdo->query("SHOW TABLES");
        while ($row = $result->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        // Generate SQL script
        $sqlScript = "";
        $totalTables = count($tables);
        $currentTable = isset($_SESSION['currentTable']) ? $_SESSION['currentTable'] : 0;

        if ($currentTable < $totalTables) {
            $table = $tables[$currentTable];

            // Get table structure
            $result = $pdo->query("SHOW CREATE TABLE $table");
            $row = $result->fetch(PDO::FETCH_NUM);
            $sqlScript .= "\n\n" . $row[1] . ";\n\n";

            // Get table data
            $result = $pdo->query("SELECT * FROM $table");
            $columnCount = $result->columnCount();

            // Loop through each row
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
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

            // Save the SQL script to a backup file
    $backupDir = './backupdata/'; // Ensure the directory path ends with a slash
    $backupDir = 'C:/backupdata/'; // Ensure the directory path ends with a slash
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0777, true);
    }
    $backupFile = $backupDir . 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $fileHandler = fopen($backupFile, 'a');
    fwrite($fileHandler, $sqlScript);
    fclose($fileHandler);

    // Update progress
    $currentTable++;
    $_SESSION['currentTable'] = $currentTable;
    $progress = ($currentTable / $totalTables) * 100;

    echo json_encode(['progress' => $progress, 'status' => 'Backing up table ' . $table]);
} else {
    unset($_SESSION['currentTable']);
    echo json_encode(['progress' => 100, 'status' => 'Backup completed successfully.', 'completed' => true]);
}
} catch (PDOException $e) {
    echo json_encode(['status' => 'Error: ' . $e->getMessage()]);
}
}
?>