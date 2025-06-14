<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin Panel</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
            .noti{
                position: relative;
                margin: 0px;
                padding: 0px;
                width: 40px;
                height: 40px;
                border-radius: 20px;
                background : #D0D0D0;
                margin: 10px;
            }
            .ico{
                width:20px;
                height: 20px;
                margin : 10px;
            }
         
            .notification{
                background: #787878;
                padding: 0px;
                margin: 0px;
                border-radius: 50px;
                color: white;
                display:none;
                position: absolute;
                font-weight: bold;
                font-size: 16px;
                margin-left : -5px;
                width : 15px;
            }

            .notification-container {
                position: relative;
            }

        </style>
    
    <script src="js/lib/jquery/jquery.min.js"></script>

</head>

<body class="fix-header" >
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
                        <!-- Logo icon -->
                        
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <!-- <span><img src="images/1234.png" alt="homepage" class="dark-logo" /></span> -->
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
   
   <div class="scroll-sidebar">

       <nav class="sidebar-nav">
           <ul id="sidebarnav">
               <li class="nav-devider"></li>
               <li class="nav-label">Home</li>
               <li> <a href="dashboard.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a>
               </li>
               <li class="nav-label">Log</li>
               <li> <a href="invoice.php" aria-expanded="false"><i class="fa fa-archive f-s-20 color-warning"></i><span class="hide-menu">Invoice</span></a>
                            
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"> <span><i
                                        class="fa fa-user f-s-20 "></i></span><span
                                    class="hide-menu">Customers</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="add_customer.php">Add Customer</a></li>
                                <li><a href="view_customer.php">View Customer</a></li>
                                <li><a href="manage_customer.php">Manage Customer</a></li>
                            </ul>
                        </li>
                        
           </ul>
       </nav>
   
   </div>
  
</div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper" style="height:1200px;">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3> </div>
               
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                     <div class="row">

                     <div class="col-md-4">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-archive f-s-40 color-warning" aria-hidden="true"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?php $sql="select * from invoice";
												$result=mysqli_query($db,$sql); 
													$rws=mysqli_num_rows($result);
													
													echo $rws;?></h2>
                                    <p class="m-b-0">Invoice</p>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-4">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-user f-s-40 color-danger"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h2><?php $sql="select * from customer";
												$result=mysqli_query($db,$sql); 
													$rws=mysqli_num_rows($result);
													
													echo $rws;?></h2>
                                    <p class="m-b-0">Customer</p>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <!-- <footer class="footer"> © 2021 All rights reserved. </footer> -->
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>

				
					<script>
                        document.addEventListener("DOMContentLoaded", function () {
                        // Request notification permission
                        if (Notification.permission !== "granted") {
                            Notification.requestPermission().then(permission => {
                                console.log("Notification Permission:", permission);
                            });
                        }

                        function checkLowStock() {
                            fetch("low_stock.php") // Fetch low-stock products
                            .then(response => response.json())
                            .then(products => {
                                console.log("Low Stock Products:", products); // Debugging

                                if (products.length > 0) {
                                    let message = products.map(product => 
                                        `${product.Product_name} (${product.Product_Quantity} left)`
                                    ).join("\n");

                                    showNotification(message);

                                    
                                }
                            })
                            .catch(error => console.error("Fetch Error:", error));
                        }

                        function showNotification(message) {
                            if (Notification.permission === "granted") {
                                new Notification("Low Stock Alert!", {
                                    body: message,
                                    icon: "warning_icon.png" // Change to a valid image URL
                                });
                            }
                        }

                        // Initial check when the page loads
                        checkLowStock();
                    });

                        </script>

					
					
					
					
					
					
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <!-- <footer class="footer"> © 2021 All rights reserved. </footer> -->
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>

    <script src="js/script_notification.js"></script>

</body>

</html>
