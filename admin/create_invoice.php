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

if (isset($_POST['submit_invoice'])) {
  // Get form data
  $invoice_no = $_POST['invoice_no'] ?? '';
  $invoice_date = $_POST['invoice_date'] ?? '';
  $customer_id = $_POST['customer_id'] ?? '';
  $sale_type = $_POST['sale_type'] ?? '';
  $hsn_code = $_POST['hsn_code'] ?? '';
  $cgst = ($_POST['cgst'] ?? '') !== "NOT APPLY" ? floatval($_POST['cgst']) : 0;
  $sgst = ($_POST['sgst'] ?? '') !== "NOT APPLY" ? floatval($_POST['sgst']) : 0;
  $igst = ($_POST['igst'] ?? '') !== "NOT APPLY" ? floatval($_POST['igst']) : 0;
  $total_amount = floatval($_POST['total_amount'] ?? 0);
  $round_off = floatval($_POST['round_off'] ?? 0);
  $final_amount = floatval($_POST['final_amount'] ?? 0);
  $amount_in_words = $_POST['amount_in_words'] ?? '';
  $cgst_rate = floatval($_POST['cgst_rate'] ?? 0);
  $sgst_rate = floatval($_POST['sgst_rate'] ?? 0);
  $igst_rate = floatval($_POST['igst_rate'] ?? 0);

  // Validate customer exists
  $check = $conn->query("SELECT * FROM customer WHERE Customer_ID = '$customer_id'");
  if (!$customer_id || $check->num_rows == 0) {
    die("❌ Error: Invalid or missing customer ID");
  }

  // Insert into invoice table
  $insert_invoice = "INSERT INTO invoice (
    invoice_no, invoice_date, customer_id, sale_type, hsn_code,
    cgst_rate, sgst_rate, igst_rate, cgst, sgst, igst,
    total_amount, round_off, final_amount, amount_in_words
  ) VALUES (
    '$invoice_no', '$invoice_date', '$customer_id', '$sale_type', '$hsn_code',
    '$cgst_rate', '$sgst_rate', '$igst_rate', '$cgst', '$sgst', '$igst',
    '$total_amount', '$round_off', '$final_amount', '$amount_in_words'
  )";

  if ($conn->query($insert_invoice) === TRUE) {
    $invoice_id = $conn->insert_id;

    $product_names = $_POST['product_name'] ?? [];
    $qtys = $_POST['qty'] ?? [];
    $rates = $_POST['rate'] ?? [];
    $amounts = $_POST['amount'] ?? [];
    $discounts = $_POST['discount'] ?? [];
    $net_amounts = $_POST['net_amount'] ?? [];

    for ($i = 0; $i < count($product_names); $i++) {
      $pname = trim($product_names[$i] ?? '');
      if ($pname === '') continue;

      $qty_text = $qtys[$i] ?? '0'; // E.g. "136 mtr"
      $rate = floatval($rates[$i] ?? 0);
      $amount = floatval($amounts[$i] ?? 0);
      $discount = floatval($discounts[$i] ?? 0);
      $net = floatval($net_amounts[$i] ?? 0);

      // Store full qty text (e.g., "136 mtr")
      $insert_item = "INSERT INTO invoice_items (
        invoice_id, product_name, qty, rate, amount, discount, net_amount
      ) VALUES (
        '$invoice_id', '$pname', '$qty_text', '$rate', '$amount', '$discount', '$net'
      )";

      $conn->query($insert_item);
    }

    // Redirect after success
    header("Location: invoice_print.php?invoice_id=$invoice_id");
    exit();
  } else {
    echo "<h3>❌ Error inserting invoice: " . $conn->error . "</h3>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dynamic Invoice</title>
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
        <label>Invoice No:</label>
        <input type="text" class="form-control" id="invoice_no" name="invoice_no">
      </div>
      <div class="col-md-6">
        <label>Date:</label>
        <input type="date" class="form-control" id="invoice_date" name="invoice_date">
      </div>
    </div>

    <div class="mb-3">
      <label>Bill To:</label>
      <select id="customer_select" class="form-select" name="customer_id" onchange="fillCustomerDetails(this)">
        <option disabled selected>-- Select Customer --</option>
        <?php foreach ($customers as $c): ?>
            <option value="<?= $c['Customer_ID'] ?>"
              data-name="<?= htmlspecialchars($c['Customer_name']) ?>"
              data-address="<?= htmlspecialchars($c['Customer_address']) ?>"
              data-gstin="<?= htmlspecialchars($c['GST_in']) ?>">
              <?= htmlspecialchars($c['Customer_name']) ?>
            </option>
          <?php endforeach; ?>
      </select>

      <label class="mt-2">Address:</label>
      <textarea id="customer_address" name="customer_address" class="form-control" rows="2" readonly></textarea>

      <label class="mt-2">GSTIN:</label>
      <input type="text" id="customer_gstin" name="customer_gstin" class="form-control" readonly>
    </div>

    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th>Sr.</th><th>Product</th><th>Qty</th><th>Rate</th><th>Amount</th><th>Discount (%)</th><th>Net</th>
        </tr>
      </thead>
      <tbody id="item-body">
        <tr>
          <td>1</td>
          <td><textarea class="form-control" name="product_name[]" rows="2" style="resize: vertical;"></textarea></td>
          <td><input type="text" step="0.01" class="form-control qty" name="qty[]" value="0"></td>
          <td><input type="number" step="0.01" class="form-control rate" name="rate[]" value="0"></td>
          <td><input type="text" class="form-control amount" name="amount[]" readonly></td>
          <td><input type="number" class="form-control discount"  name="discount[]" value="0"></td>
          <td><input type="text" class="form-control net" name="net_amount[]" readonly></td>
        </tr>
      </tbody>
    </table>
    <button type="button" class="btn btn-secondary btn-sm mb-3" onclick="addRow()">Add Row</button>

    <div class="row mb-2">
      <div class="col-md-6">
        <label>Sale Type:</label>
        <select id="sale_type" name="sale_type" class="form-select" onchange="updateInvoice()">
          <option value="state">State</option>
          <option value="interstate">InterState</option>
        </select>
      </div>
      <div class="col-md-6">
        <label>SAC Code:</label>
        <input type="text" class="form-control" name="hsn_code" value="998821">
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-4">
        <label>CGST %</label>
        <select id="cgst_rate" name="cgst_rate" class="form-select" onchange="updateInvoice()">
          <option value="2.5">2.5%</option>
          <option value="3">3%</option>
          <option value="9">9%</option>
          <option value="14">14%</option>
        </select>
        <input type="text" id="cgst" name="cgst" class="form-control mt-1" readonly>
      </div>
      <div class="col-md-4">
        <label>SGST %</label>
        <select id="sgst_rate" name="sgst_rate" class="form-select" onchange="updateInvoice()">
          <option value="2.5">2.5%</option>
          <option value="3">3%</option>
          <option value="9">9%</option>
          <option value="14">14%</option>
        </select>
        <input type="text" id="sgst" name="sgst" class="form-control mt-1" readonly>
      </div>
      <div class="col-md-4">
        <label>IGST %</label>
        <select id="igst_rate" name="igst_rate" class="form-select" onchange="updateInvoice()">
          <option value="5">5%</option>
          <option value="6">6%</option>
          <option value="18">18%</option>
          <option value="28">28%</option>
        </select>
        <input type="text" id="igst" name="igst" class="form-control mt-1" readonly>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-md-4">Total Amount<input type="text" id="total_amount" name="total_amount" class="form-control" readonly></div>
      <div class="col-md-4">Round Off<input type="text" id="round_off" name="round_off" class="form-control" readonly></div>
      <div class="col-md-4">Final Amount<input type="text" id="final_amount" name="final_amount" class="form-control" readonly></div>
    </div>

    <div class="mt-3">
      <label>Total Amount in Words:</label>
      <input type="text" id="amount_in_words" name="amount_in_words" class="form-control" readonly>
    </div>

    <div class="mt-4 text-center">
        <input type="submit" name="submit_invoice" class="btn btn-primary" value="Submit Invoice">   
    </div>
  </div>

  <script>
    function fillCustomerDetails(select) {
      const option = select.options[select.selectedIndex];
      document.getElementById('customer_address').value = option.dataset.address || '';
      document.getElementById('customer_gstin').value = option.dataset.gstin || '';
    }

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


    function numberToWordsIndian(num) {
  const a = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten",
    "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen",
    "Seventeen", "Eighteen", "Nineteen"];
  const b = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];

  if ((num = num.toString()).length > 9) return 'Overflow';

  num = ('000000000' + num).substr(-9);
  const crore = parseInt(num.substr(0, 2), 10);
  const lakh = parseInt(num.substr(2, 2), 10);
  const thousand = parseInt(num.substr(4, 2), 10);
  const hundred = parseInt(num.substr(6, 1), 10);
  const rest = parseInt(num.substr(7, 2), 10);

  let str = '';

  if (crore) {
    str += (a[crore] || b[Math.floor(crore / 10)] + ' ' + a[crore % 10]) + ' Crore ';
  }

  if (lakh) {
    str += (a[lakh] || b[Math.floor(lakh / 10)] + ' ' + a[lakh % 10]) + ' Lakh ';
  }

  if (thousand) {
    str += (a[thousand] || b[Math.floor(thousand / 10)] + ' ' + a[thousand % 10]) + ' Thousand ';
  }

  if (hundred) {
    str += a[hundred] + ' Hundred ';
  }

  if (rest) {
    str += (str !== '' ? 'and ' : '') + (a[rest] || b[Math.floor(rest / 10)] + ' ' + a[rest % 10]);
  }

  str = str.trim().replace(/\s+/g, ' '); // Clean extra spaces

  return 'Rupees ' + str + ' Only';
}



    function updateInvoice() {
      let total = 0;
      document.querySelectorAll('#item-body tr').forEach(row => {
        const qtyText = row.querySelector('.qty').value.trim();
const qtyMatch = qtyText.match(/\d+(\.\d+)?/);
const qty = qtyMatch ? parseFloat(qtyMatch[0]) : 0;

       let rate = parseFloat(row.querySelector('.rate').value) || 0;
        const discount = parseFloat(row.querySelector('.discount').value) || 0;
        const amt = qty * rate;
        const net = amt - (amt * discount / 100);
        row.querySelector('.amount').value = amt.toFixed(2);
        row.querySelector('.net').value = net.toFixed(2);
        total += net;
      });

      let cgst = 0, sgst = 0, igst = 0;
      const saleType = document.getElementById('sale_type').value;

      if (saleType === 'state') {
        const cgstRate = parseFloat(document.getElementById('cgst_rate').value) || 0;
        const sgstRate = parseFloat(document.getElementById('sgst_rate').value) || 0;
        cgst = total * cgstRate / 100;
        sgst = total * sgstRate / 100;
        document.getElementById('cgst').value = cgst.toFixed(2);
        document.getElementById('sgst').value = sgst.toFixed(2);
        document.getElementById('igst').value = 'NOT APPLY';
      } else {
        const igstRate = parseFloat(document.getElementById('igst_rate').value) || 0;
        igst = total * igstRate / 100;
        document.getElementById('igst').value = igst.toFixed(2);
        document.getElementById('cgst').value = 'NOT APPLY';
        document.getElementById('sgst').value = 'NOT APPLY';
      }

      const totalAmount = total + cgst + sgst + igst;
      const final = Math.round(totalAmount);
      const roundOff = (final - totalAmount).toFixed(2);

      document.getElementById('total_amount').value = totalAmount.toFixed(2);
      document.getElementById('final_amount').value = final.toFixed(2);
      document.getElementById('round_off').value = roundOff;
document.getElementById('amount_in_words').value = numberToWordsIndian(final);    }

    function submitInvoice() {
      updateInvoice();
      alert("Invoice submitted successfully!");
    }

    document.addEventListener('input', function (e) {
      if (e.target.closest('#item-body')) updateInvoice();
    });
    document.getElementById('sale_type').addEventListener('change', updateInvoice);
  </script>
  </form>
</body>
</html>