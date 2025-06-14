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

        <!-- Image popup -->
        <style>
            .popup {
                position: fixed;
                z-index: 999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8);
                display: none;
            }
            .popup-content {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }
            .close-btn {
                position: absolute;
                top: 20px;
                right: 20px;
                font-size: 30px;
                color: white;
                cursor: pointer;
            }
            /* Style ONLY for these two buttons in the popup */
            a.popup-btn {
                color: white !important; /* White link and icon */
                font-size: 20px;
                text-decoration: none; /* Removes underline */
                margin-top: 5px;
                display: inline-block; /* Ensures margin works properly */
            }

            /* Mouse hover effect for the buttons */
            a.popup-btn:hover {
                color: #ccc !important; /* Slight grey on hover */
            }

            /* Active (when clicked) */
            a.popup-btn:active {
                color: white !important;
            }

            /* Icon-specific styling */
            a.popup-btn i {
                color: white !important; /* Icon stays white */
                font-size: 20px;
                margin-top: 5px;
                display: inline-block;
            }

                        
        </style>

        
    
    <script src="js/lib/jquery/jquery.min.js"></script>
   
</head>

<body class="fix-header fix-sidebar">
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
                        <li> <a  href="dashboard.php" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></a>
                            
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
                        </li>
                                                 
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    
               
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        
                       
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All Customer</h4>
                             
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Customer Id</th>
                                                <th>Customer Name</th>		
                                                <th>Customer Address</th>
                                                <th>GST In</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
											
                                        <?php
                                                $sql="SELECT * FROM Customer";
                                                $query=mysqli_query($db,$sql);
                                                
                                                if(!mysqli_num_rows($query) > 0 ) {
                                                    echo '<td colspan="11"><center>No Customer Data!</center></td>';
                                                } else {                
                                                    while($rows = mysqli_fetch_array($query)) {
    echo '<tr>
        <td>' . $rows['Customer_ID'] . '</td>
        <td>' . $rows['Customer_name'] . '</td>
        <td>' . $rows['Customer_address'] . '</td>
        <td>' . $rows['GST_in'] . '</td>
        <td>
            <a href="update_customer.php?customer_upd=' . $rows['Customer_ID'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5">
                <i class="fa fa-edit"></i>
            </a>
        </td>
    </tr>';
}
// <a href="delete_customer.php?customer_del=' . $rows['Customer_ID'] . '" onclick="return confirmDelete();" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10">
//                 <i class="fa fa-trash-o" style="font-size:16px"></i>
//             </a>

                                                    }   
                                                
                                            ?>     
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						 </div>
                      
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
			
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    
    <!-- Popup Modal HTML -->
    <div id="img_popup" class="popup" style="display:none;">
        <div class="popup-header">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            &nbsp;
            <a id="newTabLink" href="#" target="_blank" class="popup-btn" title="Open in New Tab">
                <i class="fa fa-file" aria-hidden="true"></i>
            </a> &nbsp;
            <a id="downloadLink" href="#" download class="popup-btn" title="Download Image">
                <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
            </a>
        </div>
        <div class="popup-content">
            <img id="popupImage" src="" style="max-width: 80%; max-height: 80%; border-radius: 8px;">
        </div>
    </div>

    <script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this customer?");
}
</script>

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


    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
</body>

</html>