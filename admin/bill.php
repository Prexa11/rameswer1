<?php
$conn = new mysqli("localhost", "root", "", "rameshwar");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$invoice_id = isset($_GET['invoice_id']) ? intval($_GET['invoice_id']) : 0;
if ($invoice_id <= 0) {
  die("<h2>❌ Invalid or missing invoice ID.</h2>");
}

// Get invoice
$invoice_sql = "SELECT i.*, c.Customer_name, c.Customer_address, c.GST_in
                FROM invoice i
                JOIN customer c ON i.customer_id = c.Customer_ID
                WHERE i.invoice_id = $invoice_id";
$invoice_result = $conn->query($invoice_sql);
if ($invoice_result->num_rows == 0) {
  die("<h2>❌ Invoice not found.</h2>");
}
$invoice = $invoice_result->fetch_assoc();

// Get items
$items_sql = "SELECT * FROM invoice_items WHERE invoice_id = $invoice_id";
$items_result = $conn->query($items_sql);
$items = [];
while ($row = $items_result->fetch_assoc()) {
  $items[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Invoice #<?= $invoice['invoice_no'] ?></title>
</head>
<body>
  <h2>Invoice #<?= $invoice['invoice_no'] ?> - <?= $invoice['invoice_date'] ?></h2>
  <p><strong>Customer:</strong> <?= $invoice['Customer_name'] ?></p>
  <p><strong>Address:</strong> <?= nl2br($invoice['Customer_address']) ?></p>
  <p><strong>GSTIN:</strong> <?= $invoice['GST_in'] ?></p>

  <h3>Items</h3>
  <ul>
    <?php foreach ($items as $item): ?>
      <li><?= $item['product_name'] ?> - Qty: <?= $item['qty'] ?>, Rate: <?= $item['rate'] ?>, Net: <?= $item['net_amount'] ?></li>
    <?php endforeach; ?>
  </ul>

  <h4>Summary</h4>
  <p>CGST: <?= $invoice['cgst'] ?></p>
  <p>SGST: <?= $invoice['sgst'] ?></p>
  <p>IGST: <?= $invoice['igst'] ?></p>
  <p>Total: <?= $invoice['total_amount'] ?></p>
  <p>Round Off: <?= $invoice['round_off'] ?></p>
  <p><strong>Net Amount: <?= $invoice['final_amount'] ?></strong></p>
  <p><strong>Amount in Words: <?= $invoice['amount_in_words'] ?></strong></p>
</body>
</html>
