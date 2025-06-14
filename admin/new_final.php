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
$sale_type = $invoice['sale_type'];

// Get items
$items_sql = "SELECT * FROM invoice_items WHERE invoice_id = $invoice_id";
$items_result = $conn->query($items_sql);
$items = [];
while ($row = $items_result->fetch_assoc()) {
  $items[] = $row;
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=794px">

    <title>Rameshwar Creation - Tax Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
        font-family: 'Arial', sans-serif;
        font-size: 14px;
        }
        .border-all {
        border: 1px solid black;
        }
        .header-bg {
        background-color: #d2e4f9;
        }
        .section-title {
        background-color: #d2e4f9;
        font-weight: bold;
        text-align: center;
        }
        .subheading {
        font-weight: bold;
        font-size: 20px;
        text-align: center;
        padding: 5px 0;
        }
        .small-text {
        font-size: 13px;
        }
        .red-text {
        color: red;
        font-weight: bold;
        }
        .invoice-box {
        border: 2px solid black;
        margin-top: 20px;
        }
        .table-bordered td, .table-bordered th {
        border: 1px solid black !important;
        }
        .invoice-grid {
        border: 1px solid black;
        }
        .invoice-row {
        display: flex;
        }
        .invoice-cell {
        border-right: 1px solid black;
        padding: 8px;
        text-align: center;
        }
        .invoice-cell:last-child {
        border-right: none;
        }
        .header-row, .footer-row {
        background-color: #cce0f9;
        font-weight: bold;
        border-bottom: 1px solid black;
        }
        .left-align {
        text-align: left !important;
        }
        .bordered {
        border: 1px solid black;
        }
        .cell {
        padding: 6px 10px;
        border-right: 2px solid black;
        border-bottom: 1px solid black;
        }
        .cell:last-child {
        border-right: none;
        }
        .row-no-border > div {
        border-bottom: none !important;
        }
        .no-border {
        border: none !important;
        }
        .bg-light-blue {
        background-color: #cce0f9;
        }
        .bg-red {
        background-color: #ffcccc;
        font-weight: bold;
        }
        .fw-bold {
        font-weight: bold;
        }
        .align-end {
        text-align: end;
        }
        
.company-logo {
  max-width: 100px;
  height: auto;
}

@media print {
    body {
      zoom: 0.85;
      margin: 0;
      padding: 0;
      background-color: white !important;
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }

    .invoice-box {
      background-color: white !important;
      
    }

    .no-print {
      display: none !important;
    }

    .container {
      max-width: 100%;
      padding: 0;
      margin: 0;
    }

    .col-md-9, .col-md-3, .col-md-1, .col-md-8 {
      flex: 0 0 auto;
      width: auto;
    }

    @page {
      size: A4;
      margin: 10mm;
    }
  }
    </style>
    </head>
    <body>
        <div class="text-center my-3 me-3 no-print">
  <button class="btn btn-primary" onclick="window.print()">🖨️ Print Invoice</button>
</div>
    <div class="container invoice-box p-0" >
    <!-- New Header Start -->
        <!-- Company Header with Logo -->
        <div class="row g-0 border align-items-center">
            <div class="col-md-9 p-2 d-flex">
                <div>
                    <img src="image.jpeg" alt="Logo" class="company-logo" style="max-width: 100px; height: auto;">
                </div>
            <div class="ps-3">
                <h2 class="mb-1 fw-bold" style="font-family: 'Times New Roman'">RAMESHWAR CREATION</h2>
                <div>PLOT NO. 87-88, SHIVA PARK SOCIETY, NEAR SEWAGE PLANT, BEHIND</div>
                <div>TORRENT POWER VARACHHA ROAD, Surat, 395010, Gujarat</div>
                <div>Contact: 9824778263 | 9898161095</div>
            </div>
        </div>
        <div class="col-md-3 p-2">
            <div class="d-flex px-2 pt-2 mb-2">
                <div class="text-center"><strong>GSTIN:</strong>&nbsp;&nbsp;&nbsp; 24AISPG9881B1ZZ</div>
            </div>
        </div>
    </div>

<!-- Invoice Title -->
<div class="d-flex justify-content-between align-items-start border-top border-black border-2">
  <div class="p-2">
    <div class="fw-bold">Billed To:</div>
    <div><strong><?= $invoice['Customer_name'] ?></strong></div>
    <?= nl2br($invoice['Customer_address']) ?><br>
    GSTIN: <?= $invoice['GST_in'] ?>
  </div>

  <div class="text-center border-start border-black border-2 p-0" style="min-width: 250px;">
    <div class="fw-bold border-bottom border-black border-2" style="font-size: 28px;">Invoice</div>
    <div class="d-flex justify-content-between px-2 pt-2 mb-1">
      <div class="fw-bold">Number:</div>
      <div class="fw-bold text-center" style="font-size:18px;"><?= $invoice['invoice_no'] ?></div>
    </div>
    <div class="d-flex justify-content-between px-2 pt-2 mb-1">
      <div class="fw-bold">Date:</div>
      <div><?= date('d-m-Y', strtotime($invoice['invoice_date'])) ?></div>
    </div>
  </div>
</div>

<!-- New Header End -->

    <!-- Invoice Grid -->
    <div class="invoice-grid" ><!--invoice-cell text-center footer-row -->
        <div class="invoice-row header-row border-top border-black border-2">
        <div class="invoice-cell border-2" style="width: 5%;">Sr. No.</div>
        <div class="invoice-cell border-2 fs-6" style="width: 35%;">Product</div>
        <div class="invoice-cell border-2 fs-6" style="width: 10%;">Qty</div>
        <div class="invoice-cell border-2 fs-6" style="width: 10%;">Rate</div>
        <div class="invoice-cell border-2 fs-6" style="width: 15%;">Amount</div>
        <div class="invoice-cell border-2 fs-6" style="width: 10%;">Discount</div>
        <div class="invoice-cell border-2 fs-6" style="width: 15%;">Net Amount</div>
        </div>
        <!-- <div class="product-details" > -->
        <div class="invoice-container border-2" style="overflow: visible;">
    <?php foreach ($items as $i => $item): ?>
        <div class="invoice-row " style="display: flex; width: 100%;"> <!-- Each row is full width -->
            <div class="invoice-cell border-2" style="width: 5%;"><?= $i + 1 ?></div>
            <div class="invoice-cell border-2" style="width: 35%;"><?= !empty($item['product_name']) ? $item['product_name'] : '' ?></div>
            <div class="invoice-cell border-2" style="width: 10%;"><?= $item['qty'] != 0 ? $item['qty'] : '' ?></div>
            <div class="invoice-cell border-2" style="width: 10%;"><?= $item['rate'] != 0 ? number_format($item['rate'], 2) : '' ?></div>
            <div class="invoice-cell border-2" style="width: 15%;"><?= $item['amount'] != 0 ? number_format($item['amount'], 2) : '' ?></div>
            <div class="invoice-cell border-2" style="width: 10%;"><?= $item['discount'] != 0 ? $item['discount'] . '%' : '' ?></div>
            <div class="invoice-cell border-2" style="width: 15%;"><?= $item['net_amount'] != 0 ? number_format($item['net_amount'], 2) : '' ?></div>
        </div>
    <!-- </div> -->
    <?php endforeach; ?>
    <?php
    // 🔁 Fill empty rows up to a max (e.g., 15 rows)
    $filled = count($items);
    $max_rows = 13;
    $remaining = $max_rows - $filled;
    for ($j = 0; $j < $remaining; $j++):
  ?>
    <div class="invoice-row" style="display: flex; width: 100%;">
      <div class="invoice-cell border-2" style="width: 5%;">&nbsp;</div>
      <div class="invoice-cell border-2" style="width: 35%;">&nbsp;</div>
      <div class="invoice-cell border-2" style="width: 10%;">&nbsp;</div>
      <div class="invoice-cell border-2" style="width: 10%;">&nbsp;</div>
      <div class="invoice-cell border-2" style="width: 15%;">&nbsp;</div>
      <div class="invoice-cell border-2" style="width: 10%;">&nbsp;</div>
      <div class="invoice-cell border-2" style="width: 15%;">&nbsp;</div>
    </div>
  <?php endfor; ?>
</div>
</div>
    <?php
$totalQty = 0;
$totalRate = 0;
$totalAmount = 0;
$totalDiscount = 0;
$totalNetAmount = 0;

foreach ($items as $item) {
    // $totalQty += $item['qty'];
    // $totalRate += $item['rate']; // Usually rate isn't summed, but keeping it for your structure
    $totalAmount += $item['amount'];
    // $totalDiscount += $item['discount']; // If needed as a raw sum
    $totalNetAmount += $item['net_amount'];
}
?>

<div class="invoice-row border-top border-start border-end border-black border-2 footer-row">
    <div class="invoice-cell border-2 text-end pe-2" style="width: 40%;" colspan="2"><strong>Total</strong></div>
    <div class="invoice-cell border-2" style="width: 10%;"><?= $totalQty != 0 ? number_format($totalQty, 2) : '' ?></div>
    <div class="invoice-cell border-2" style="width: 10%;"><?= $totalRate != 0 ? number_format($totalRate, 2) : '' ?></div>
    <div class="invoice-cell border-2" style="width: 15%;"><?= $totalAmount != 0 ? number_format($totalAmount, 2) : '' ?></div>
    <div class="invoice-cell border-2" style="width: 10%;"></div> <!-- Total discount % is typically not displayed -->
    <div class="invoice-cell border-2" style="width: 15%;"><?= $totalNetAmount != 0 ? number_format($totalNetAmount, 2) : '' ?></div>
</div>


    <!-- <div class="invoice-row" style="border-top: 1px solid black;">
    <div class="invoice-cell text-center footer-row" style="width: 37%;">Total Amount in words</div>
    <div class="invoice-cell text-center footer-row" style="width: 33%;">HSN\SAC CODE - <?= $invoice['hsn_code'] ?></div>
    <div class="invoice-cell text-center" style="width: 25%;">Amount</div>
    <div class="invoice-cell text-center" style="width: 13%;"><?= $totalNetAmount != 0 ? number_format($totalNetAmount, 2) : '' ?></div>
    </div> -->

    <!-- Footer Summary -->
    <div class="d-flex bordered" style="border-left: none; border-right: none; ">
  <!-- LEFT BLOCK: HSN + Words -->
  <div class="flex-fill d-flex flex-column justify-content-start align-items-start border-2 fw-bold"
       style="padding: 12px; font-size: 20px; line-height: 2; height: 84%;">
    <div>HSN/SAC CODE: <?= $invoice['hsn_code'] ?></div>
    <div>Total Amount in Words:</div>
    <div><?= $invoice['amount_in_words'] ?></div>
  </div>

  <!-- RIGHT BLOCK: GST + Totals -->
  <div style="width: 400px; height: 100%;">
    <?php $sale_type = strtolower($invoice['sale_type']); ?>

    <?php if ($sale_type === 'state'): ?>
    <div class="d-flex bordered" style="height: 36px;">
      <div class="cell fw-bold text-center" style="width: 40%;">CGST</div>
      <div class="cell text-center" style="width: 25%;"><?= $invoice['cgst_rate'] ?>%</div>
      <div class="cell text-center" style="width: 35%;"><?= number_format($invoice['cgst'], 2) ?></div>
    </div>
    <div class="d-flex bordered" style="height: 36px;">
      <div class="cell fw-bold text-center" style="width: 40%;">SGST</div>
      <div class="cell text-center" style="width: 25%;"><?= $invoice['sgst_rate'] ?>%</div>
      <div class="cell text-center" style="width: 35%;"><?= number_format($invoice['sgst'], 2) ?></div>
    </div>
    <?php elseif ($sale_type === 'interstate'): ?>
    <div class="d-flex bordered" style="height: 36px;">
      <div class="cell fw-bold text-center" style="width: 40%;">IGST</div>
      <div class="cell text-center" style="width: 25%;"><?= $invoice['igst_rate'] ?>%</div>
      <div class="cell text-center" style="width: 35%;"><?= number_format($invoice['igst'], 2) ?></div>
    </div>
    <?php endif; ?>

    <!-- Totals -->
    <div class="d-flex bordered" style="height: 36px;">
      <div class="cell fw-bold text-center" style="width: 65%;">TOTAL AMOUNT</div>
      <div class="cell text-center" style="width: 35%;"><?= $invoice['total_amount'] ?></div>
    </div>
    <div class="d-flex bordered" style="height: 36px;">
      <div class="cell fw-bold text-center" style="width: 65%;">ROUND OFF</div>
      <div class="cell text-center" style="width: 35%;"><?= $invoice['round_off'] ?></div>
    </div>
    <div class="d-flex bordered" style="height: 36px;">
      <div class="cell fw-bold text-center" style="width: 65%;">Amount</div>
      <div class="cell fw-bold text-center" style="width: 35%;"><?= $invoice['final_amount'] ?></div>
    </div>
  </div>
</div>

    <div class="row g-0" style="border-top: 1px solid black; min-height: 150px;">
        
        <div class="col-6 p-2" >
        Terms & Condition : Subject to our home Jurisdiction.
    </div>
        <div class="col-6 d-flex justify-content-end align-items-end px-3 py-4">
        <div class="text-end">Sign .....</div>
        </div>
    </div>

    
    </div>

    </body>
    </html>