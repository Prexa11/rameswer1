<!DOCTYPE html>
<html lang="en">
<?php
session_start();
error_reporting(0);
include("connection/connect.php");

?>
<?php
    if(isset($_POST['submit']))
    {

    $update_c_name=$_POST['update_c_name'];
    $update_c_address=$_POST['update_c_address'];
    $update_c_gst_in=$_POST['update_c_gst_in'];

    $sql1 = "Update customer set Customer_name = '$update_c_name',  
            Customer_address = '$update_c_address', 
            GST_in = '$update_c_gst_in'
            where Customer_ID = '$_GET[customer_upd]' ";

        $result2 = mysqli_query($db, $sql1);

        if ($result2) {
            echo "<script>alert('Update sucessfully')</script>";
            echo "<script>window.location.href='view_customer.php'</script>";
        }
  
  }
?>
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
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"> <span><i
                                        class="fa fa-user f-s-20 "></i></span><span
                                    class="hide-menu">Customers</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="add_customer.php">Add Customer</a></li>
                                <li><a href="view_customer.php">View Customer</a></li>
                            </ul>
                        
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
                     <div class="row">
                   
                   
					
					 <div class="container-fluid">
                <!-- Start Page Content -->
                  
								
								
					    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Update Customer</h4>
                            </div>
                            <div class="card-body">
                                <form action='' method='post'  enctype="multipart/form-data">
                                    <div class="form-body">
                                       
                                        <hr>
                                        <?php
                                            $sql = "Select * from customer where Customer_ID   = '$_GET[customer_upd]'";
                                            $result = mysqli_query($db, $sql);
                            
                                            if ($result) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_array($result)) {
                            //                            print_r($row['userName']);
                                                        
                                        ?>
                                        
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Customer Name</label>
                                                    <input type="text" name="update_c_name" class="form-control" value="<?php echo $row['Customer_name']; ?>">
                                                </div> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Customer Address</label>
                                                    <input type="text" name="update_c_address" class="form-control" value="<?php echo $row['Customer_address']; ?>">
                                                </div> 
                                            </div>
                                        </div>
                                        <!--/span-->
                                            
                                        <!--/span-->
                                        
                                        <!--/row-->
										<div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">GST IN</label>
                                                    <input type="text" name="update_c_gst_in" class="form-control" value="<?php echo $row['GST_in']; ?>">
                                                </div>
                                            </div>

                                        </div>
                                        <!--/row-->
                                        
                                             
                                            
                                            <?php } } } ?>
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-success" value="Save"> 
                                        <a href="view_customer.php" class="btn btn-inverse">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
					
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