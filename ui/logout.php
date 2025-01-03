<?php
session_start();
date_default_timezone_set("Asia/Manila");
// Include database connection file
include_once 'conndb.php';
$username = $_SESSION['username'];
// Update the login time
$update = $pdo->prepare("UPDATE tbl_user SET logout = NOW() WHERE username = :username");
$update->bindParam(':username', $username);
$update->execute();
session_destroy();


header('location:../index.php');




?>