<?php
$conn = new mysqli("localhost", "root", "", "rameshwar");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_id'])) {
  $invoice_id = intval($_POST['invoice_id']);
  $invoice_no = $_POST['invoice_no'];
  $invoice_date = $_POST['invoice_date'];
  $sale_type = $_POST['sale_type'];
  $hsn_code = $_POST['hsn_code'];
  $cgst_rate = floatval($_POST['cgst_rate']);
  $sgst_rate = floatval($_POST['sgst_rate']);
  $igst_rate = floatval($_POST['igst_rate']);
  $cgst = floatval($_POST['cgst']);
  $sgst = floatval($_POST['sgst']);
  $igst = floatval($_POST['igst']);
  $total_amount = floatval($_POST['total_amount']);
  $round_off = floatval($_POST['round_off']);
  $final_amount = floatval($_POST['final_amount']);
  $amount_in_words = $_POST['amount_in_words'];

  $conn->query("
    UPDATE invoice SET
      invoice_no = '$invoice_no',
      invoice_date = '$invoice_date',
      sale_type = '$sale_type',
      hsn_code = '$hsn_code',
      cgst_rate = '$cgst_rate',
      sgst_rate = '$sgst_rate',
      igst_rate = '$igst_rate',
      cgst = '$cgst',
      sgst = '$sgst',
      igst = '$igst',
      total_amount = '$total_amount',
      round_off = '$round_off',
      final_amount = '$final_amount',
      amount_in_words = '$amount_in_words'
    WHERE invoice_id = '$invoice_id'
  ");

  // Update and add items
  $existing_ids = isset($_POST['item_id']) ? $_POST['item_id'] : [];
  $product_names = $_POST['product_name'];
  $qtys = $_POST['qty'];
  $rates = $_POST['rate'];
  $amounts = $_POST['amount'];
  $discounts = $_POST['discount'];
  $net_amounts = $_POST['net_amount'];

  for ($i = 0; $i < count($product_names); $i++) {
    $name = $conn->real_escape_string($product_names[$i]);
    $qty = floatval($qtys[$i]);
    $rate = floatval($rates[$i]);
    $amt = floatval($amounts[$i]);
    $disc = floatval($discounts[$i]);
    $net = floatval($net_amounts[$i]);

    if (!empty($existing_ids[$i])) {
      $item_id = intval($existing_ids[$i]);
      $conn->query("UPDATE invoice_items SET product_name='$name', qty='$qty', rate='$rate', amount='$amt', discount='$disc', net_amount='$net' WHERE item_id='$item_id'");
    } else {
      $conn->query("INSERT INTO invoice_items (invoice_id, product_name, qty, rate, amount, discount, net_amount) VALUES ('$invoice_id', '$name', '$qty', '$rate', '$amt', '$disc', '$net')");
    }
  }

  // Delete items if marked
  if (isset($_POST['delete_item_ids'])) {
    $delete_ids = explode(',', $_POST['delete_item_ids']);
    foreach ($delete_ids as $del_id) {
      if (is_numeric($del_id)) {
        $conn->query("DELETE FROM invoice_items WHERE item_id = $del_id");
      }
    }
  }

  header("Location: invoice_print.php?invoice_id=$invoice_id");
  exit;
}

// Load data
$invoice_id = intval($_GET['invoice_id'] ?? 0);
$invoice = $conn->query("SELECT * FROM invoice WHERE invoice_id = $invoice_id")->fetch_assoc();
$items = $conn->query("SELECT * FROM invoice_items WHERE invoice_id = $invoice_id")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script>
    let deletedItems = [];

    function addRow() {
      const table = document.getElementById('item-body');
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td><input type="hidden" name="item_id[]" value=""><input type="text" name="product_name[]" class="form-control"></td>
        <td><input type="number" name="qty[]" value="0" class="form-control"></td>
        <td><input type="number" name="rate[]" value="0" class="form-control"></td>
        <td><input type="number" name="amount[]" value="0" class="form-control"></td>
        <td><input type="number" name="discount[]" value="0" class="form-control"></td>
        <td><input type="number" name="net_amount[]" value="0" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">🗑</button></td>
      `;
      table.appendChild(newRow);
    }

    function deleteRow(btn) {
  const tableBody = btn.closest('tbody');
  const rows = tableBody.querySelectorAll('tr');
  
  if (rows.length > 1) {
    btn.closest('tr').remove();
  } else {
    alert("At least one product row must remain.");
  }
}
  </script>
</head>
<body class="container py-4">
  <h2>Edit Invoice #<?= htmlspecialchars($invoice['invoice_no']) ?></h2>
  <form method="POST">
    <input type="hidden" name="invoice_id" value="<?= $invoice_id ?>">
    <input type="hidden" name="delete_item_ids" id="delete_item_ids" value="">

    <div class="mb-3"><label>Invoice No</label><input type="text" name="invoice_no" value="<?= $invoice['invoice_no'] ?>" class="form-control"></div>
    <div class="mb-3"><label>Date</label><input type="date" name="invoice_date" value="<?= $invoice['invoice_date'] ?>" class="form-control"></div>
    <div class="mb-3">
      <label>Sale Type</label>
      <select name="sale_type" class="form-select">
        <option value="state" <?= $invoice['sale_type'] === 'state' ? 'selected' : '' ?>>State</option>
        <option value="interstate" <?= $invoice['sale_type'] === 'interstate' ? 'selected' : '' ?>>InterState</option>
      </select>
    </div>
    <div class="mb-3"><label>HSN Code</label><input type="text" name="hsn_code" value="<?= $invoice['hsn_code'] ?>" class="form-control"></div>

    <div class="row">
      <div class="col"><label>CGST %</label><input type="text" name="cgst_rate" value="<?= $invoice['cgst_rate'] ?>" class="form-control"></div>
      <div class="col"><label>SGST %</label><input type="text" name="sgst_rate" value="<?= $invoice['sgst_rate'] ?>" class="form-control"></div>
      <div class="col"><label>IGST %</label><input type="text" name="igst_rate" value="<?= $invoice['igst_rate'] ?>" class="form-control"></div>
    </div>

    <div class="row mt-2">
      <div class="col"><label>CGST</label><input type="text" name="cgst" value="<?= $invoice['cgst'] ?>" class="form-control"></div>
      <div class="col"><label>SGST</label><input type="text" name="sgst" value="<?= $invoice['sgst'] ?>" class="form-control"></div>
      <div class="col"><label>IGST</label><input type="text" name="igst" value="<?= $invoice['igst'] ?>" class="form-control"></div>
    </div>

    <div class="row mt-2">
      <div class="col"><label>Total Amount</label><input type="text" name="total_amount" value="<?= $invoice['total_amount'] ?>" class="form-control"></div>
      <div class="col"><label>Round Off</label><input type="text" name="round_off" value="<?= $invoice['round_off'] ?>" class="form-control"></div>
      <div class="col"><label>Final Amount</label><input type="text" name="final_amount" value="<?= $invoice['final_amount'] ?>" class="form-control"></div>
    </div>

    <div class="mt-3"><label>Amount in Words</label><input type="text" name="amount_in_words" value="<?= $invoice['amount_in_words'] ?>" class="form-control"></div>

    <h4 class="mt-4">Invoice Items</h4>
    <table class="table table-bordered">
      <thead><tr><th>Product</th><th>Qty</th><th>Rate</th><th>Amount</th><th>Discount</th><th>Net</th><th>Action</th></tr></thead>
      <tbody id="item-body">
        <?php foreach ($items as $item): ?>
          <tr>
            <td><input type="hidden" name="item_id[]" value="<?= $item['item_id'] ?>"><input type="text" name="product_name[]" value="<?= htmlspecialchars($item['product_name']) ?>" class="form-control"></td>
            <td><input type="number" name="qty[]" value="<?= $item['qty'] ?>" class="form-control"></td>
            <td><input type="number" name="rate[]" value="<?= $item['rate'] ?>" class="form-control"></td>
            <td><input type="number" name="amount[]" value="<?= $item['amount'] ?>" class="form-control"></td>
            <td><input type="number" name="discount[]" value="<?= $item['discount'] ?>" class="form-control"></td>
            <td><input type="number" name="net_amount[]" value="<?= $item['net_amount'] ?>" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <button type="button" class="btn btn-secondary" onclick="addRow()">➕ Add Row</button>
    <button type="submit" class="btn btn-success">💾 Update Invoice</button>
  </form>
</body>
</html>
