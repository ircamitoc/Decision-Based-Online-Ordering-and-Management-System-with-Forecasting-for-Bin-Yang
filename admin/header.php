
<?php 

    include('db_connection.php'); 


    if($session_access=='admin' && isset($_SESSION['username'])){
        // echo " admin";
       
    }else{
        if($session_access=='staff' && isset($_SESSION['username'])){
            // echo "staff";
            echo "<script>window.location='https://binyang.online/admin/point_of_sales.php' </script>";
        }else{
            if(isset($_SESSION['username']) && $session_access=='Customer'){
                // you are customer;
                echo "<script>window.location='https://binyang.online/' </script>";
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | BIN-YANG</title>
  <link rel="icon" type="image/png" href="../icon.png">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/dashboard.css">
  <!-- <link rel="stylesheet" href="assets/css/custom_css.css"> -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

  <!-- select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- end of select2 -->

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    <style>
        .j-orange{
            background:rgb(212,145,87);
            border:0;
            color:white;
        }


        .j-green{
            background:rgb(66,183,142);
            border:0;
            color:white;
        }


        .j-link{
            color:black;
        }

        .j-active-link{
            color:gray;

        }

        .j-btn:hover{
            background:gray;
            color:white;
        }
    </style>

    <!-- hover button -->
    <style>
        .extra-btn, .swal-button{
            transition: 250ms ease-in-out;
        }
        .extra-btn:hover, .swal-button:hover{
            transform: translateY(-5px)translateX(5px);
        }
    </style>
</head>

<body class=" 
    <?php if(!isset($_SESSION['username'])){?> 
        sidebar-closed sidebar-collapse 
    <?php }?>">

    
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-orange navbar-light">
            <?php if(isset($_SESSION['username'])):?>
            
                <!-- Left navbar links -->
                <ul class="navbar-nav" >
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/admin" class="nav-link">Home</a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
            
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown" >
                        <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge "  id="total_notif" ></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header" id="inside_total_notif"></span>
                        <!-- <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item active">
                            <i class="fas fa-envelope mr-2 "></i>4 new Feedbakcs
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div> -->
                        
                        <div class="dropdown-divider"></div>
                        <a href="inventory.php" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> <span id="inside_body_total_notif"> </span>
                            <!-- <span class="float-right text-muted text-sm">2 days</span> -->
                        </a>

                        <a href="inventory.php" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> <span id="inside_body_total_zero_qty_notif"> </span>
                            <!-- <span class="float-right text-muted text-sm">2 days</span> -->
                        </a>

                        <a href="order_management.php" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> <span id="order_management_notif"> </span>
                            <!-- <span class="float-right text-muted text-sm">2 days</span> -->
                        </a>

                        <a href="order_management.php" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> <span id="order_management_cancel_paid_order_notif"> </span>
                            <!-- <span class="float-right text-muted text-sm">2 days</span> -->
                        </a>


                        <div class="dropdown-divider"></div>
                            <!-- <a href="#" class="dropdown-item dropdown-footer"  >See All Notifications</a> -->
                        </div>
                    </li>
            

                    <li class="nav-item" >
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button" >
                        <i class="fas fa-expand-arrows-alt" ></i>
                        </a>
                    </li>
                </ul>
            <?php endif;?>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" >
            <!-- Brand Logo -->
            <a href="/admin" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">BIN-YANG </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
            <?php if(isset($_SESSION['username'])):?>
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 d-flex">
                    <div class="image">
                        <!-- ACC PROFILE PIC AND NAME -->
                    <img src="<?php echo $user_image;?>" class="img-circle elevation-2" alt="User Image">
                    <!-- <img src="assets/img/default.png" class="img-circle elevation-2" alt="User Image" style="width:35px;height:35px;"> -->
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $session_username ?></a>
                    </div>
                </div>

                <div class="user-panel d-flex">
                    <div class="info">
                        <a href="?logout=1" class="d-block"> Logout</a>
                    </div>
                </div>
            <?php endif;?>


            <!-- Sidebar Menu -->
            <nav class="mt-2" >
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="/admin" class="nav-link " id="Dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="inventory.php" class="nav-link" id="Inventory">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Inventory
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="user_management.php" class="nav-link" id="User_management">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Management
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="order_management.php" class="nav-link" id="Order_management">
                        <i class="nav-icon fas fa-cart-arrow-down"></i>
                        <p>
                            Order Management
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="point_of_sales.php" class="nav-link" >
                        <i class="nav-icon fas fa-cart-arrow-down"></i>
                        <p>
                            Point of Sale
                        </p>
                    </a>
                    <li class="nav-item">
                        <a href="sales_forecast.php" class="nav-link" id="Sales_forecast">
                        <i class="nav-icon fas fa-cloud"></i>
                        <p>
                            Sales Forecast
                        </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Reports
                            <i class="fas fa-angle-left right"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="sales_reports.php" class="nav-link" id="Sales_report">
                                <i class="far fa-chart-bar nav-icon"></i>
                                <p>Sales Reports</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="feedback_reports.php" class="nav-link" id="Feedback_reports">
                                <i class="far fa-comment nav-icon"></i>
                                <p>Feedback Reports
                                    <!-- <span class="badge badge-info right">2</span> -->
                                </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="activity_logs.php" class="nav-link" id="Activity_logs">
                                <i class="far fa-comment nav-icon"></i>
                                <p>Activity Logs
                                    <!-- <span class="badge badge-info right">2</span> -->
                                </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                </li>
                
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>