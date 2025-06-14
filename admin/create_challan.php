<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "rameshwar");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all customers
$customers = [];
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
  $customers[] = $row;
}

// Handle form submission
if (isset($_POST['submit_challan'])) {
  $challan_no = $_POST['challan_no'] ?? '';
  $challan_date = $_POST['challan_date'] ?? '';
  $customer_id = $_POST['customer_id'] ?? '';
  $po_no = $_POST['p_o_no'] ?? '';
  $po_date = $_POST['p_o_date'] ?? '';

  // Validate
  if (!$challan_no || !$challan_date || !$customer_id) {
    die("❌ Please fill all required fields (No., Date, Customer).");
  }

  // Insert into challan table
  $stmt = $conn->prepare("INSERT INTO challan (challan_no, challan_date, customer_id, po_no, po_date) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssiss", $challan_no, $challan_date, $customer_id, $po_no, $po_date);
  $stmt->execute();
  $challan_id = $stmt->insert_id;
  $stmt->close();

  // Insert items
  $particulars = $_POST['particular'] ?? [];
  $qtys = $_POST['qty'] ?? [];
  $rates = $_POST['rate'] ?? [];

  $stmt_item = $conn->prepare("INSERT INTO challan_items (challan_id, particulars, qty, rate) VALUES (?, ?, ?, ?)");
  for ($i = 0; $i < count($particulars); $i++) {
    $name = trim($particulars[$i] ?? '');
    if ($name === '') continue;

    $qty = $qtys[$i] ?? '0';
    $rate = floatval($rates[$i] ?? 0);

    $stmt_item->bind_param("issd", $challan_id, $name, $qty, $rate);
    $stmt_item->execute();
  }
  $stmt_item->close();

  // Redirect or success message
  echo "<script>alert('✅ Challan saved successfully!'); window.location.href = 'challan_print.php?challan_id=$challan_id';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Challan Entry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .invoice-box { max-width: 1000px; margin: auto; padding: 30px; border: 1px solid #ccc; background: #fff; }
    .table input, .form-select, .form-control { font-size: 20px; }
    textarea.form-control { resize: none; }
  </style>
</head>
<body>
<form action="" method="POST">
  <div class="invoice-box">
    <h3 class="text-center mb-4">RAMESHWAR CREATION</h3>
    <p class="text-center">87-88, Shiva Park, 1st Floor, Behind Torrent Power, Nr. Sewage plant, Varachha Surat<br>GSTIN: 24AISPG9881B1ZZ | Contact: 98247 78263 / 98981 61095</p>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>No:</label>
        <input type="text" class="form-control" name="challan_no" required>
      </div>
      <div class="col-md-6">
        <label>Date:</label>
        <input type="date" class="form-control" name="challan_date" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>P.O. No.:</label>
        <input type="text" class="form-control" name="p_o_no">
      </div>
      <div class="col-md-6">
        <label>P.O. Date:</label>
        <input type="date" class="form-control" name="p_o_date">
      </div>
    </div>

    <div class="mb-3">
      <label>Bill To:</label>
      <select class="form-select" name="customer_id" required>
        <option disabled selected>-- Select Customer --</option>
        <?php foreach ($customers as $c): ?>
        <option value="<?= $c['Customer_ID'] ?>"><?= htmlspecialchars($c['Customer_name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <table class="table table-bordered">
      <thead class="table-light text-center">
        <tr>
          <th>No.</th><th>Particulars</th><th>Qty</th><th>Rate</th><th>Remark</th>
        </tr>
      </thead>
      <tbody id="item-body">
        <tr>
          <td>1</td>
          <td><textarea class="form-control" name="particular[]" rows="2" style="resize: vertical;"></textarea></td>
          <td><input type="text" step="0.01" class="form-control qty" name="qty[]" value="0"></td>
          <td><input type="number" step="0.01" class="form-control rate" name="rate[]" value="0"></td>
          <td><input type="text" class="form-control" name="remark[]" ></td>
        </tr>
      </tbody>
    </table>
    <button type="button" class="btn btn-secondary btn-sm mb-3" onclick="addRow()">Add Row</button>

    <div class="mt-4 text-center">
        <input type="submit" name="submit_challan" class="btn btn-primary" value="Submit Challan">   
    </div>
  </div>
</form>

<script>
function addRow() {
  const table = document.getElementById('item-body');
  const firstRow = table.rows[0];
  const newRow = firstRow.cloneNode(true); // Clone the row

  // Clear all input/textarea values in the cloned row
  newRow.querySelectorAll('input, textarea').forEach(input => input.value = '');

  // Update Sr. No.
  newRow.cells[0].innerText = table.rows.length + 1;

  table.appendChild(newRow);
}
</script>
</body>
</html>
