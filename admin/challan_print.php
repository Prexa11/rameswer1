<?php
$conn = new mysqli("localhost", "root", "", "rameshwar");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$challan_id = isset($_GET['challan_id']) ? intval($_GET['challan_id']) : 0;
if ($challan_id <= 0) {
  die("<h2>❌ Invalid or missing challan ID.</h2>");
}

$sql = "SELECT ch.*, c.Customer_name, c.Customer_address 
        FROM challan ch
        JOIN customer c ON ch.customer_id = c.Customer_ID
        WHERE challan_id = $challan_id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
  die("<h2>❌ Challan not found.</h2>");
}
$challan = $result->fetch_assoc();

$items_sql = "SELECT * FROM challan_items WHERE challan_id = $challan_id";
$items_result = $conn->query($items_sql);
$items = [];
while ($row = $items_result->fetch_assoc()) {
  $items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Delivery Challan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  body {
    font-size: 13px;
    margin: 0;
    padding: 0;
    background: #f9f9f9;
  }

  .page {
    width: 210mm;
    height: 160.5mm; /* Half of A4 148.5mm (A5 size) */
    margin: auto;
    /* padding: 5mm;
    box-sizing: border-box; */
  }

  .challan-box {
    width: 100%;
    height: 100%;
    padding: 12px;
    border: 1px solid #000;
    background: #fff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .invoice-row {
  display: flex;
  width: 100%;
}

.invoice-cell {
  padding: 4px 6px;
  border-right: 1px solid #000;
  font-size: 12px;
  border-bottom: none !important; /* No row lines */
}

.invoice-row:last-child .invoice-cell {
  border-bottom: none; /* Still no line on last row */
}

/* Only apply horizontal line on top of header */
.header-row {
  border-top: 1px solid #000;
  font-weight: bold;
  background-color: #f0f0f0;
}
 .header-row .invoice-cell {
  font-size: 14px;
  font-weight: bold;
  background-color: #f0f0f0;
  border-bottom: 1px solid #000;
  border-right: 1px solid #000;
}


.invoice-container {
  border-left: 1px solid #000;
  border-right: 1px solid #000;
  border-bottom: 1px solid #000;
  overflow: hidden;
}


  .header-row {
    font-weight: bold;
    background-color: #f0f0f0;
    border-top: 1px solid #000;
  }

  .details-grid .d-flex {
    margin-bottom: 1px;
  }

  .details-grid label {
    width: 85px;
    display: inline-block;
  }

  @media print {
    @page {
      size: A5 portrait;
      margin: 0;
    }

    body {
      margin: 0;
      print-color-adjust: exact !important;
      -webkit-print-color-adjust: exact !important;
    }

    .page {
      page-break-after: always;
    }
  }
</style>
  
</head>
<body>
  <div class="page">
    <div class="challan-box">
      <!-- Header -->
      <div class="d-flex justify-content-between mb-2">
  <!-- Logo + Company Info -->
  <div class="d-flex">
    <img src="image.jpeg" alt="Logo" style="max-width: 80px; margin-right: 10px;">
    <div>
      <h6 class="fw-bold mb-1">RAMESHWAR CREATION</h6>
      <div>PLOT NO. 87-88, SHIVA PARK SOCIETY, NEAR SEWAGE PLANT, BEHIND</div>
      <div>TORRENT POWER VARACHHA ROAD, Surat, 395010, Gujarat</div>
      <div>Contact: 9824778263 | 9898161095</div>
    </div>
  </div>

  <!-- Challan Info Next to Header -->
  <div class="details-grid ms-3" style="font-size: 13px;">
    <div class="d-flex"><label><strong>Challan No.:</strong></label> <div><?= htmlspecialchars($challan['challan_no']) ?></div></div>
    <div class="d-flex"><label><strong>Date:</strong></label> <div><?= date('d/m/Y', strtotime($challan['challan_date'])) ?></div></div>
    <div class="d-flex"><label><strong>P.O. No.:</strong></label> <div><?= htmlspecialchars($challan['po_no']) ?></div></div>
    <div class="d-flex"><label><strong>P.O. Date:</strong></label> <div><?= $challan['po_date'] ? date('d/m/Y', strtotime($challan['po_date'])) : '' ?></div></div>
  </div>
</div>


      <div class="d-flex justify-content-between fw-bold  pt-1">
        <div class="text-primary">DELIVERY CHALLAN</div>
        <div>GSTIN: 24AISPG9881B1ZZ</div>
        
      </div>

      <!-- Customer and Challan Info -->
      <div class="row mt-2 border-top border-2">
        <div>
          <div><strong>Name:</strong> <?= htmlspecialchars($challan['Customer_name']) ?></div>
          <div><strong>Address:</strong> <?= htmlspecialchars($challan['Customer_address']) ?></div>
        </div>
      </div>

      <!-- Item Table -->
      <div class="invoice-row header-row border-bottom border-black text-center" >
        <div class="invoice-cell border-start border-black" style="width: 5%;">Sr.</div>
        <div class="invoice-cell" style="width: 40%;">Particulars</div>
        <div class="invoice-cell" style="width: 15%;">Qty</div>
        <div class="invoice-cell" style="width: 15%;">Rate</div>
        <div class="invoice-cell" style="width: 25%;">Remark</div>
      </div>
      <div class="invoice-container text-center">
        <?php foreach ($items as $i => $item): ?>
          <div class="invoice-row">
            <div class="invoice-cell" style="width: 5%;"><?= $i + 1 ?></div>
            <div class="invoice-cell" style="width: 40%;"><?= nl2br(htmlspecialchars($item['particulars'])) ?></div>
            <div class="invoice-cell" style="width: 15%;"><?= htmlspecialchars($item['qty']) ?></div>
            <div class="invoice-cell" style="width: 15%;"><?= $item['rate'] != 0 ? number_format($item['rate'], 2) : '' ?></div>
            <div class="invoice-cell" style="width: 25%;"><?= isset($item['remark']) ? nl2br(htmlspecialchars($item['remark'])) : '' ?></div>
          </div>
        <?php endforeach; ?>

        <?php
        $filled = count($items);
        $max_rows = 15;
        $remaining = $max_rows - $filled;
        for ($j = 0; $j < $remaining; $j++):
        ?>
        <div class="invoice-row">
          <div class="invoice-cell" style="width: 5%;">&nbsp;</div>
          <div class="invoice-cell" style="width: 40%;">&nbsp;</div>
          <div class="invoice-cell" style="width: 15%;">&nbsp;</div>
          <div class="invoice-cell" style="width: 15%;">&nbsp;</div>
          <div class="invoice-cell" style="width: 25%;">&nbsp;</div>
        </div>
        <?php endfor; ?>
      </div>

      <!-- Footer -->
      <div class="d-flex justify-content-between align-items-center px-3 " style="font-size: 14px;">
        <div><strong>Subject to SURAT Jurisdiction</strong></div>
        <div style="font-size: 16px;"><strong>For, Rameshwar Creation</strong></div>
      </div>

      <div class="d-flex justify-content-between px-3 pt-3" style="font-size: 14px;">
        <div><strong>Receiver's Signature</strong></div>
        <div style="width: 180px;">&nbsp;</div>
      </div>
    </div>
  </div>
</body>
</html>
