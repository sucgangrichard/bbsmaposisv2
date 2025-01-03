<?php
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
include_once 'conndb.php'; // Include database connection or configuration file

// Fetch the current email address
$sql = "SELECT email FROM email_settings WHERE id = 1";
$stmt = $pdo->query($sql);
$currentEmail = $stmt->fetch(PDO::FETCH_ASSOC)['email'];

// Fetch the notification interval
$sql = "SELECT interval_value, interval_unit FROM notification_settings WHERE id = 1";
$stmt = $pdo->query($sql);
$intervalData = $stmt->fetch(PDO::FETCH_ASSOC);
$intervalValue = $intervalData['interval_value'];
$intervalUnit = $intervalData['interval_unit'];

// Convert interval to seconds
$intervalInSeconds = ($intervalUnit == 'minutes') ? $intervalValue * 60 : $intervalValue;

// Function to check stock levels
function checkStockLevels($pdo, $intervalInSeconds) {
    // Check the last notification time
    $sql = "SELECT last_notification FROM notification_log ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->query($sql);
    $lastNotification = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no notification has been sent or it has been more than the interval, send a notification
    if (!$lastNotification || (time() - strtotime($lastNotification['last_notification'])) > $intervalInSeconds) {
        $sql = "SELECT product_name, available FROM tbl_mmenu WHERE available < 10";
        $result = $pdo->query($sql);

        $lowStockItems = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                sendEmailNotification($row['product_name'], $row['available']);
                $lowStockItems[] = $row;
            }
        }

        $sql = "SELECT product_name, stock FROM tbl_product WHERE stock < 10";
        $result = $pdo->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                sendEmailNotification($row['product_name'], $row['stock']);
                $lowStockItems[] = $row;
            }
        }

        $sql = "INSERT INTO notification_log (last_notification) VALUES (NOW())";
        $pdo->query($sql);

        return $lowStockItems;
    }

    return [];
}

// Function to send email notification
function sendEmailNotification($productName, $stock) {
    global $currentEmail;
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;
        $mail->Username   = 'richard.l.sucgang@gmail.com'; // SMTP username
        $mail->Password   = 'gwiitdscznvhptue'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom($currentEmail, 'Stock Notification');
        $mail->addAddress($currentEmail); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Low Stock Notification';
        $mail->Body    = 'The stock level of ' . $productName . ' is running low. Current stock: ' . $stock;

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
    }
}

// Call the function to check stock levels
$lowStockItems = checkStockLevels($pdo, $intervalInSeconds);
// echo json_encode($lowStockItems);
?>  