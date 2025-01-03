<?php
include_once 'conndb.php'; // Include your database connection

function checkStockAndNotify($pdo) {
    // Query to check stock levels
    $sql = "SELECT product_name, stock FROM tbl_product WHERE stock < 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($results) > 0) {
        // Semaphore API credentials
        $api_key = '0e90cb305305ed1a4dc08d4ddf87b1d6';
        $sender_name = 'Notification';

        foreach ($results as $row) {
            $message = "Stock Alert: The stock for " . $row['product_name'] . " is less than 10.";
            $recipient = '09912419832'; // Replace with your phone number

            // Send SMS using Semaphore API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/messages');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'apikey' => $api_key,
                'number' => $recipient,
                'message' => $message,
                'sendername' => $sender_name
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            // Handle response if needed
            // $response_data = json_decode($response, true);
        }
    }
}

// Call the function
checkStockAndNotify($pdo);
?>