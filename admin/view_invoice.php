<?php
$conn = new mysqli("localhost", "root", "", "rameshwar");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT invoice_id, invoice_no, invoice_date FROM invoice ORDER BY invoice_id DESC";
$result = $conn->query($sql);
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $invoice_id = intval($_POST['invoice_id']);
  $invoice_no = $conn->real_escape_string($_POST['invoice_no']);
  $invoice_date = $conn->real_escape_string($_POST['invoice_date']);
  $final_amount = floatval($_POST['final_amount']);

  // Update invoice table
  $sql_invoice = "UPDATE invoice SET 
                  invoice_no = '$invoice_no',
                  invoice_date = '$invoice_date',
                  final_amount = $final_amount
                  WHERE invoice_id = $invoice_id";
  if (!$conn->query($sql_invoice)) {
    die("Invoice update failed: " . $conn->error);
  }

  // Update invoice items
  $item_ids = $_POST['item_id'];          // array of item IDs
  $product_names = $_POST['product_name'];
  $qtys = $_POST['qty'];
  $rates = $_POST['rate'];
  $amounts = $_POST['amount'];
  $discounts = $_POST['discount'];
  $net_amounts = $_POST['net_amount'];

  for ($i = 0; $i < count($item_ids); $i++) {
    $item_id = intval($item_ids[$i]);
    $product_name = $conn->real_escape_string($product_names[$i]);
    $qty = intval($qtys[$i]);
    $rate = floatval($rates[$i]);
    $amount = floatval($amounts[$i]);
    $discount = floatval($discounts[$i]);
    $net_amount = floatval($net_amounts[$i]);

    $sql_item = "UPDATE invoice_items SET
                 product_name = '$product_name',
                 qty = $qty,
                 rate = $rate,
                 amount = $amount,
                 discount = $discount,
                 net_amount = $net_amount
                 WHERE item_id = $item_id AND invoice_id = $invoice_id";

    if (!$conn->query($sql_item)) {
      die("Item update failed for item_id $item_id: " . $conn->error);
    }
  }

  echo "Invoice and items updated successfully!";
  // Optionally redirect somewhere:
  // header("Location: somepage.php?invoice_id=$invoice_id");
  // exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>All Invoices</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h2 class="mb-4">All Invoices</h2>
  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Invoice No</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['invoice_id'] ?></td>
            <td><?= htmlspecialchars($row['invoice_no']) ?></td>
            <td><?= htmlspecialchars($row['invoice_date']) ?></td>
            <td>
              <a href="invoice_print.php?invoice_id=<?= $row['invoice_id'] ?>" class="btn btn-sm btn-primary">View</a>
              <a href="update_invoice.php?invoice_id=<?= $row['invoice_id'] ?>" class="btn btn-sm btn-warning">Update</a>
              <a href="delete_invoice.php?invoice_id=<?= $row['invoice_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this invoice?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4">No invoices found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>
