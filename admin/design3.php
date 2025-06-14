<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice Footer Section</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .bordered {
      border: 1px solid black;
    }
    .cell {
      padding: 6px 10px;
      border-right: 1px solid black;
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
  </style>
</head>
<body>

<div class="container p-0 mt-4 bordered">

  <div class="d-flex bordered" style="border-left: none; border-right: none;">

  <!-- Amount in Words Box -->
  <div class="flex-fill d-flex justify-content-center align-items-center fw-bold" style="border: 1px solid black; height: 282px;">
    Rupees Three Lakh ThirtyThree Thousand SixtyFive Only
  </div>

  <!-- Tax & Totals Summary Box -->
  <div style="width: 300px;">
    <div class="d-flex bordered">
      <div class="cell fw-bold" style="width: 50%;">CGST</div>
      <div class="cell" style="width: 25%;">2.5%</div>
      <div class="cell" style="width: 25%;">7930.125</div>
    </div>
    <div class="d-flex bordered">
      <div class="cell fw-bold" style="width: 50%;">SGST</div>
      <div class="cell" style="width: 25%;">2.5%</div>
      <div class="cell" style="width: 25%;">7930.125</div>
    </div>
    <div class="d-flex bordered">
      <div class="cell bg-red" style="width: 50%;">IGST NOT APPLY</div>
      <div class="cell" style="width: 25%;">5.0%</div>
      <div class="cell" style="width: 25%;"></div>
    </div>
    <div class="d-flex bordered">
      <div class="cell fw-bold" style="width: 75%;">TOTAL AMOUNT</div>
      <div class="cell" style="width: 25%;">333065.25</div>
    </div>
    <div class="d-flex bordered">
      <div class="cell fw-bold" style="width: 75%;">ROUND OFF</div>
      <div class="cell" style="width: 25%;">0.25</div>
    </div>
    <div class="d-flex bordered">
      <div class="cell fw-bold" style="width: 75%;">Net Amount</div>
      <div class="cell" style="width: 25%;">333065.00</div>
    </div>
  </div>
</div>

  <!-- Bank Details -->
  <div class="bg-light-blue text-center fw-bold py-1" style="border-top: 1px solid black;">
    BANK DETAILS
  </div>
  <div class="row g-0">
    <div class="col-6 bordered">
      <div class="d-flex">
        <div class="cell" style="width: 30%;">Bank Name</div>
        <div class="cell flex-fill"></div>
      </div>
      <div class="d-flex">
        <div class="cell" style="width: 30%;">Bak A\C:</div>
        <div class="cell flex-fill"></div>
      </div>
      <div class="d-flex">
        <div class="cell" style="width: 30%;">Bank IFSC:</div>
        <div class="cell flex-fill"></div>
      </div>
    </div>
    <div class="col-6 d-flex justify-content-end align-items-end px-3 py-4">
      <div class="text-end">Sign .....</div>
    </div>
  </div>

  <!-- Terms -->
  <div class="p-2" style="border-top: 1px solid black;">
    Terms & Condition : Subject to our home Jurisdiction.
  </div>
</div>

</body>
</html>
