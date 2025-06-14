<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice Grid Layout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    font-family: Arial, sans-serif;
    font-size: 14px;
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
</style>
</head>
<body>

<div class="container mt-4 p-0">
  <!-- Header -->
  <div class="invoice-grid">
    <div class="invoice-row header-row">
      <div class="invoice-cell" style="width: 5%;">Sr. No.</div>
      <div class="invoice-cell" style="width: 35%;">Product</div>
      <div class="invoice-cell" style="width: 10%;">Qty</div>
      <div class="invoice-cell" style="width: 10%;">Rate</div>
      <div class="invoice-cell" style="width: 15%;">Amount</div>
      <div class="invoice-cell" style="width: 10%;">Discounts</div>
      <div class="invoice-cell" style="width: 15%;">Net Amount</div>
    </div>

    <!-- Product Row -->
    <div class="invoice-row">
      <div class="invoice-cell" style="width: 5%;">1</div>
      <div class="invoice-cell left-align" style="width: 35%;">
        D. NO. 81047 C PALLU<br>
        PINK - 118<br>
        YELLOW - 122<br>
        FIROJI - 119<br>
        GREY - 118
      </div>
      <div class="invoice-cell" style="width: 10%;">477</div>
      <div class="invoice-cell" style="width: 10%;">700.00</div>
      <div class="invoice-cell" style="width: 15%;">333,900.00</div>
      <div class="invoice-cell" style="width: 10%;">5.0%</div>
      <div class="invoice-cell" style="width: 15%;">317205.00</div>
    </div>

    <div class="invoice-row">
  <div class="invoice-cell" style="width: 5%;">2</div>
  <div class="invoice-cell" style="width: 35%;"></div>
  <div class="invoice-cell" style="width: 10%;"></div>
  <div class="invoice-cell" style="width: 10%;"></div>
  <div class="invoice-cell" style="width: 15%;"></div>
  <div class="invoice-cell" style="width: 10%;"></div>
  <div class="invoice-cell" style="width: 15%;"></div>
</div>
<div class="invoice-row">
  <div class="invoice-cell" style="width: 5%;">3</div>
  <div class="invoice-cell" style="width: 35%;"></div>
  <div class="invoice-cell" style="width: 10%;"></div>
  <div class="invoice-cell" style="width: 10%;"></div>
  <div class="invoice-cell" style="width: 15%;"></div>
  <div class="invoice-cell" style="width: 10%;"></div>
  <div class="invoice-cell" style="width: 15%;"></div>
</div>

    <!-- Totals Row -->
    <div class="invoice-row footer-row">
      <div class="invoice-cell text-end pe-2" style="width: 40%;" colspan="2">Total</div>
      <div class="invoice-cell" style="width: 10%;">477.00</div>
      <div class="invoice-cell" style="width: 10%;">700.00</div>
      <div class="invoice-cell" style="width: 15%;">333,900.00</div>
      <div class="invoice-cell" style="width: 10%;"></div>
      <div class="invoice-cell" style="width: 15%;">317205.00</div>
    </div>

    <!-- Footer Info -->
    <div class="invoice-row">
      <div class="invoice-cell left-align" style="width: 60%;">Total Amount in words</div>
      <div class="invoice-cell text-center footer-row" style="width: 20%;">HSN\SAC CODE - 998821</div>
      <div class="invoice-cell text-center" style="width: 10%;">Amount</div>
      <div class="invoice-cell text-center" style="width: 10%;">317205</div>
    </div>
  </div>
</div>

</body>
</html>
