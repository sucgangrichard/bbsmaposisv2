<?php
// Include your database connection file
include 'conndb.php';

// Get the product ID from the request
$id = $_GET['id'];

// Prepare and execute the SQL query to fetch the stock information
$query = $conn->prepare("SELECT stock FROM tbl_product WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

// Check if the product exists and fetch the stock information
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stock = $row['stock'];
    // Return the stock information as a JSON response
    echo json_encode(['stock' => $stock]);
} else {
    // Return an error response if the product is not found
    echo json_encode(['error' => 'Product not found']);
}

// Close the database connection
$conn->close();
?>