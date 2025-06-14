<?php
include("connection/connect.php");
error_reporting(0);
session_start();


// sending query
// mysqli_query($db,"DELETE FROM customer WHERE Customer_ID = '".$_GET['customer_del']."'");
// header("location:view_customer.php");  

if (isset($_GET['customer_del'])) {
    $id = $_GET['customer_del'];

    // Get all invoice IDs for that customer
    $invoice_ids = [];
    $inv_result = mysqli_query($db, "SELECT invoice_id FROM invoice WHERE customer_id = '$id'");
    while ($row = mysqli_fetch_assoc($inv_result)) {
        $invoice_ids[] = $row['invoice_id'];
    }

    // Delete from invoice_items first
    if (!empty($invoice_ids)) {
        $id_list = implode(",", $invoice_ids);
        mysqli_query($db, "DELETE FROM invoice_items WHERE invoice_id IN ($id_list)");
    }

    // Then delete from invoice
    mysqli_query($db, "DELETE FROM invoice WHERE customer_id = '$id'");

    // Finally delete the customer
    $result = mysqli_query($db, "DELETE FROM customer WHERE Customer_ID = '$id'");

    if ($result) {
        header("Location: view_customer.php");
    } else {
        echo "Error: " . mysqli_error($db);
    }
}

?>
