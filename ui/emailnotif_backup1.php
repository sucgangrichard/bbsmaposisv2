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

// Function to check stock levels
function checkStockLevels($pdo) {
    // Check the last notification time
    $sql = "SELECT last_notification FROM notification_log ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->query($sql);
    $lastNotification = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no notification has been sent or it has been more than a day, send a notification
    if (!$lastNotification || (time() - strtotime($lastNotification['last_notification'])) > 30) { //set this to 5 seconds to function properly
        $sql = "SELECT product_name, available FROM tbl_mmenu WHERE available < 10";
        $result = $pdo->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                sendEmailNotification($row['product_name'], $row['available']);
            }
        }

        // Check stock levels in tbl_product
        $sql = "SELECT product_name, stock FROM tbl_product WHERE stock < 10";
        $result = $pdo->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                sendEmailNotification($row['product_name'], $row['stock']);
            }
        }

        // Update the last notification time
        $sql = "INSERT INTO notification_log (last_notification) VALUES (NOW())";
        $pdo->query($sql);
    }
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
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>