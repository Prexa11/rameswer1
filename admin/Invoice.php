<?php

// Database connection
$conn = new mysqli("localhost", "root", "", "rameshwar");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$customers = [];
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
  $customers[] = $row;
}

if (isset($_POST['submit_invoice'])) {
  // Get form data safely
  $invoice_no = isset($_POST['invoice_no']) ? $_POST['invoice_no'] : '';
  $invoice_date = isset($_POST['invoice_date']) ? $_POST['invoice_date'] : '';
  $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : '';
  $sale_type = isset($_POST['sale_type']) ? $_POST['sale_type'] : '';
  $hsn_code = isset($_POST['hsn_code']) ? $_POST['hsn_code'] : '';
  $cgst = isset($_POST['cgst']) && $_POST['cgst'] !== "NOT APPLY" ? floatval($_POST['cgst']) : 0;
  $sgst = isset($_POST['sgst']) && $_POST['sgst'] !== "NOT APPLY" ? floatval($_POST['sgst']) : 0;
  $igst = isset($_POST['igst']) && $_POST['igst'] !== "NOT APPLY" ? floatval($_POST['igst']) : 0;
  $total_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0;
  $round_off = isset($_POST['round_off']) ? floatval($_POST['round_off']) : 0;
  $final_amount = isset($_POST['final_amount']) ? floatval($_POST['final_amount']) : 0;
  $amount_in_words = isset($_POST['amount_in_words']) ? $_POST['amount_in_words'] : '';
  $cgst_rate = isset($_POST['cgst_rate']) ? floatval($_POST['cgst_rate']) : 0;
  $sgst_rate = isset($_POST['sgst_rate']) ? floatval($_POST['sgst_rate']) : 0;
$igst_rate = isset($_POST['igst_rate']) ? floatval($_POST['igst_rate']) : 0;


  // Validate customer exists
  $check = $conn->query("SELECT * FROM customer WHERE Customer_ID = '$customer_id'");
  if (!$customer_id || $check->num_rows == 0) {
    die("❌ Error: Invalid or missing customer ID");
  }

  // Insert invoice
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

    $product_names = isset($_POST['product_name']) ? $_POST['product_name'] : [];
    $qtys = isset($_POST['qty']) ? $_POST['qty'] : [];
    $rates = isset($_POST['rate']) ? $_POST['rate'] : [];
    $amounts = isset($_POST['amount']) ? $_POST['amount'] : [];
    $discounts = isset($_POST['discount']) ? $_POST['discount'] : [];
    $net_amounts = isset($_POST['net_amount']) ? $_POST['net_amount'] : [];

    for ($i = 0; $i < count($product_names); $i++) {
      if (trim($product_names[$i]) === '') continue;

      $pname = $product_names[$i];
      $qty = $qtys[$i];
      $rate = $rates[$i];
      $amount = $amounts[$i];
      $discount = $discounts[$i];
      $net = $net_amounts[$i];

      $insert_item = "INSERT INTO invoice_items (invoice_id, product_name, qty, rate, amount, discount, net_amount)
      VALUES ('$invoice_id', '$pname', '$qty', '$rate', '$amount', '$discount', '$net')";
      $conn->query($insert_item);
    }

    // ✅ Redirect to try.php with invoice_id
  header("Location: try.php?invoice_id=$invoice_id");
  exit();
  } else {
    echo "<h3>❌ Error inserting invoice: " . $conn->error . "</h3>";
  }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Admin Panel</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    
<![endif]-->
   
    <script src="js/lib/jquery/jquery.min.js"></script>
    
</head>

<body class="fix-header">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
         <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                       
                        <!-- Logo text -->
                        <span><h3 class="dark-logo"><i class="fa fa-globe" aria-hidden="true"></i> Rameshwar</h3></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                     
                       
                    </ul>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">

                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/users/5.jpg" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                   <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                   <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a  href="dashboard.php"   ><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></a>
                            
                        </li>
                        <li class="nav-label">Log</li>
                        <li> <a href="invoice.php" aria-expanded="false"><i class="fa fa-archive f-s-20 color-warning"></i><span class="hide-menu">Invoice</span></a>
                            
                        </li>
                        <li> <a href="challan.php" aria-expanded="false"><i class="fa fa-archive f-s-20 color-warning"></i><span class="hide-menu">Challan</span></a>
                            
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"> <span><i
                                        class="fa fa-user f-s-20 "></i></span><span
                                    class="hide-menu">Customers</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="add_customer.php">Add Customer</a></li>
                                <li><a href="view_customer.php">View Customer</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper" style="height:1200px;">
            <!-- Bread crumb -->
            <!-- <div class="row page-titles">
                <div class="col-md-5 align-self-center"> 
                    <h3 class="text-primary">Dashboard</h3> </div> 
               
            </div> -->
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <br><br>
                <div class="form-actions">
                     <button class="btn btn-success btn-lg btn-block" 
                     onclick="window.open('create_invoice.php', '_blank')" >Create Invoice</button>
                </div>
                <br>
                <div class="form-actions">
                     <button class="btn btn-info btn-lg btn-block" 
                     onclick="window.open('view_invoice.php', '_blank')" >View Invoice</button>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

</body>

</html>