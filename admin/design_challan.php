<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Half-Top A4 Delivery Challan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      padding: 0;
      font-size: 13px;
      background: #f9f9f9;
    }

    .page {
      width: 210mm;
      height: 297mm;
      margin: 0 auto;
      padding-top: 10mm;
      box-sizing: border-box;
    }

    .challan-box {
      width: 100%;
      height: 148.5mm;
      padding: 12px;
      border: 2px solid #7bb7d3;
      box-sizing: border-box;
      background: #fff;
    }

    .invoice-row {
      display: flex;
      width: 100%;
    }

    .invoice-cell {
      padding: 4px 6px;
      border: 1px solid #000;
      font-size: 12px;
    }

    .header-row .invoice-cell {
      font-weight: bold;
      background-color: #f0f0f0;
    }

    .invoice-container {
      height: 140px;
      overflow: hidden;
      border: 1px solid #000;
      border-top: none;
    }

    .text-small {
      font-size: 11px;
    }

    @media print {
      @page {
        size: A4 portrait;
        margin: 0;
      }

      body {
        margin: 0;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
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
      <div class="d-flex align-items-start">
  <img src="image.jpeg" alt="Logo" style="max-width: 80px; height: auto; margin-right: 10px;">
  <div>
    <h6 class="fw-bold mb-1">RAMESHWAR CREATION</h6>
    <div>PLOT NO. 87-88, SHIVA PARK SOCIETY, NEAR SEWAGE PLANT, BEHIND</div>
    <div>TORRENT POWER VARACHHA ROAD, Surat, 395010, Gujarat</div>
    <div>Contact: 9824778263 | 9898161095</div>
  </div>
</div>

      <div class="d-flex justify-content-between align-items-center pt-1 mt-1 fw-bold">
  <div class="text-primary">DELIVERY CHALLAN</div>
  <div class="text-center flex-grow-1">GSTIN: 24AISPG9881B1ZZ</div>
  <div class="text-danger text-end">ORIGINAL</div>
</div>

      <!-- Party & Challan Info -->
      <div class="row mt-2 border-top border-2">
        <div class="col-7 border-end">
          <div><strong>Name:</strong> <?= htmlspecialchars($challan['Customer_name']) ?></div>
          <div><strong>Address:</strong> <?= htmlspecialchars($challan['Customer_name']) ?></div>
        </div>
        <div class="col-5">
          <div class="d-flex flex-column" style="font-size: 13px;">
  <div class="d-flex">
    <div style="width: 90px;"><strong>Challan No.:</strong></div>
    <div><?= htmlspecialchars($challan['challan_no']) ?></div>
  </div>
  <div class="d-flex">
    <div style="width: 90px;"><strong>Date:</strong></div>
    <div><?= date('d-m-Y', strtotime($challan['challan_date'])) ?></div>
  </div>
  <div class="d-flex">
    <div style="width: 90px;"><strong>P.O. No.:</strong></div>
    <div><?= htmlspecialchars($challan['po_no']) ?></div>
  </div>
  <div class="d-flex">
    <div style="width: 90px;"><strong>P.O. Date:</strong></div>
    <div>><?= $challan['po_date'] ? date('d-m-Y', strtotime($challan['po_date'])) : '' ?></div>
  </div>
</div>

        </div>
      </div>

      <!-- Invoice Grid -->
        <div class="invoice-grid" ><!--invoice-cell text-center footer-row -->
            <div class="invoice-row header-row border-top border-black border-2">
            <div class="invoice-cell border-2" style="width: 5%;">Sr. No.</div>
            <div class="invoice-cell border-2 fs-6" style="width: 40%;">Particulars</div>
            <div class="invoice-cell border-2 fs-6" style="width: 15%;">Qty</div>
            <div class="invoice-cell border-2 fs-6" style="width: 15%;">Rate</div>
            <div class="invoice-cell border-2 fs-6" style="width: 20%;">Remark</div>
            </div>
            <!-- <div class="product-details" > -->
            <div class="invoice-container border-2" style="height: 560px; overflow: hidden;">
        <?php foreach ($items as $i => $item): ?>
            <div class="invoice-row " style="display: flex; width: 100%;"> <!-- Each row is full width -->
                <div class="invoice-cell border-2" style="width: 5%;"><?= $i + 1 ?></div>
                <div class="invoice-cell border-2" style="width: 40%;"><?= nl2br(htmlspecialchars($item['particulars'])) ?></div>
                <div class="invoice-cell border-2" style="width: 15%;"><?= htmlspecialchars($item['qty']) ?></div>
                <div class="invoice-cell border-2" style="width: 15%;"><?= $item['rate'] != 0 ? number_format($item['rate'], 2) : '' ?></div>
                <div class="invoice-cell border-2" style="width: 20%;"><?= nl2br(htmlspecialchars($item['particulars'])) ?></div>
            </div>
        <!-- </div> -->
        <?php endforeach; ?>
        <?php
        // 🔁 Fill empty rows up to a max (e.g., 15 rows)
        $filled = count($items);
        $max_rows = 15;
        $remaining = $max_rows - $filled;
        for ($j = 0; $j < $remaining; $j++):
    ?>
        <div class="invoice-row" style="display: flex; width: 100%;">
        <div class="invoice-cell border-2" style="width: 5%;">&nbsp;</div>
        <div class="invoice-cell border-2" style="width: 40%;">&nbsp;</div>
        <div class="invoice-cell border-2" style="width: 15%;">&nbsp;</div>
        <div class="invoice-cell border-2" style="width: 15%;">&nbsp;</div>
        <div class="invoice-cell border-2" style="width: 20%;">&nbsp;</div>
        </div>
    <?php endfor; ?>
    </div>

      
     <!-- Footer Single Line -->
<div class="d-flex justify-content-between align-items-center px-3 py-2 mt-2" style=" font-size: 14px;">
  <div><strong>Subject to SURAT Jurisdiction</strong></div>
  <div style=" font-size: 18px;"><strong>For, Rameshwar Creation</strong></div>
</div>

<!-- Signature Row -->
<div class="d-flex justify-content-between mt-5 px-3" style=" font-size: 14px;">
  <div><strong>Receiver's Signature</strong></div>
  <div style="width: 180px;">&nbsp;</div> <!-- Signature placeholder -->
</div>
 

</body>
</html>
