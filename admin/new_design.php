<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invoice</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  .invoice-box {
        border: 2px solid black;
        margin-top: 20px;
        }
  .company-logo {
    max-width: 100px;
    height: auto;
  }
  .bordered td,
  .bordered th {
    border: 1px solid black !important;
  }
  .section-title {
    font-weight: bold;
    text-decoration: underline;
  }
  /* .inner-border {
    border: 1px solid black;
    padding: 10px;
  } */

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
<div class="text-end my-3 me-3 no-print">
  <button class="btn btn-primary" onclick="window.print()">🖨️ Print Invoice</button>
</div>
<div class="container invoice-box p-0" >
  <div class="row g-0 border align-items-center">
            <div class="col-md-9 p-2 d-flex">
                <div>
                    <img src="images.jpg" alt="Logo" class="company-logo" style="max-width: 100px; height: auto;">
                </div>
            <div class="ps-3">
                <h2 class="mb-1">RAMESHWAR CREATION</h2>
                <div>PLOT NO. 87-88, SHIVA PARK SOCIETY, NEAR SEWAGE PLANT, BEHIND</div>
                <div>TORRENT POWER VARACHHA ROAD, Surat, 395010, Gujarat</div>
                <div>Contact: 9824778263 | 9898161095</div>
            </div>
        </div>
        <div class="col-md-3 p-2">
            <div class="d-flex px-2 pt-2 mb-2">
                <div class="text-start w-50 fw-bold">GSTIN:</div>
                <div class="text-end w-50">24AISPG9881B1ZZ</div>
            </div>
        </div>
    </div>

<!-- Invoice Title -->
<div class="d-flex justify-content-between align-items-start border-top border-black border-2">
  <div class="p-2">
    <div class="fw-bold">Billed To:</div>
    <div><strong>Neel Store</strong></div>
    ABC <br>
    GSTIN: 1234567890
  </div>

  <div class="text-center border-start border-black border-2 p-0" style="min-width: 250px;">
    <div class="fw-bold border-bottom border-black border-2" style="font-size: 28px;">Invoice</div>
    <div class="d-flex justify-content-between px-2 pt-2 mb-1">
      <div class="fw-bold">Number:</div>
      <div>1234</div>
    </div>
    <div class="d-flex justify-content-between px-2 pt-2 mb-1">
      <div class="fw-bold">Date:</div>
      <div>01-06-2025</div>
    </div>
  </div>
</div>

</div>

</body>
</html>
