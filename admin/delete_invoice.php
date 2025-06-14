<?php
// ======= delete_invoice.php =======
$conn = new mysqli("localhost", "root", "", "rameshwar");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$invoice_id = isset($_GET['invoice_id']) ? intval($_GET['invoice_id']) : 0;
if ($invoice_id <= 0) {
  die("Invalid invoice ID");
}

// Delete items first (due to foreign key constraint)
$conn->query("DELETE FROM invoice_items WHERE invoice_id = $invoice_id");

// Then delete the invoice
if ($conn->query("DELETE FROM invoice WHERE invoice_id = $invoice_id") === TRUE) {
  header("Location: view_invoice.php?deleted=1");
  exit;
} else {
  echo "Error deleting invoice: " . $conn->error;
}
?>