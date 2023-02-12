
<?php 

include('db_connection.php'); 

    if($_SESSION['username']){

        if($session_access=='admin' && isset($_SESSION['username'])){
            // echo " admin";
        
        }else{
            if($session_access=='staff'){
                // echo "<script>window.location='https://binyang.online/admin/point_of_sales.php' </script>";
            }else{
                if(isset($_SESSION['username']) && $session_access=='Customer'){
                    echo "<script>window.location='https://binyang.online/' </script>";
                }

            }
        }
    }else{
        echo "<script>window.location='https://binyang.online/admin/login' </script>";
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

  <link rel="stylesheet" href="../style.css">


  <script src="https://kit.fontawesome.com/700816c2b5.js" crossorigin="anonymous"></script>



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

    <!-- style for inc/dec button -->
    <style>
        .wrapper2{
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FFF;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);

        }
        .wrapper2 span{
            width: 100%;
            /* text-align: center; */
            cursor: pointer;
            user-select: none;
            transition: 250ms ease-in-out;
        }
        .wrapper2 span:hover{
            font-size:22px;
        }
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        }

        .Remove_product{
            transition: 250ms ease-in-out;
        }
        .Remove_product:hover{
            font-size:30px;
        }
    </style>

    <style>
        #added_to_cart, #cancel_cart, #cancel_cart_id {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
        }

        #added_to_cart.show ,#cancel_cart.show, #cancel_cart_id.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
        from {bottom: 0; opacity: 0;} 
        to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
        from {bottom: 30px; opacity: 1;} 
        to {bottom: 0; opacity: 0;}
        }

        @keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
        }
    </style>

    <!-- swal -->
    <style>
        .swal-text {
            text-align:center
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

    <!-- cancel_availed_id -->

    <style>
        .cancel_availed_id{
            transition: 250ms ease-in-out;
        }
        .cancel_availed_id:hover{
            font-size: 20px;
        }
    </style>
    
</head>

<body class=" sidebar-mini 
    <?php if(!isset($_SESSION['username'])){?> 
        sidebar-closed sidebar-collapse 
    <?php }?>" 
       
    >

    

    
    <div class="wrapper"   >
        <div id="added_to_cart">Added to List</div>
        <div id="cancel_cart">Void Transaction</div>
        <div id="cancel_cart_id">Void Transaction</div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-orange navbar-light elevation-3" >
            
            <?php if(isset($_SESSION['username'])):?>
            
                <!-- Left navbar links -->
                <ul class="navbar-nav" hidden>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block" >
                        <a href="index.php" class="nav-link" hidden>Home</a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto" hidden>
            
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
                        <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer"  >See All Notifications</a>
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
        <aside class="main-sidebar  sidebar-dark-primary elevation-1 sidebar-no-expand "  >
            <!-- Brand Logo -->
            <a href="/admin" class="brand-link" >
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
                            <a href="?logout=1" class="d-block">Logout</a>
                        </div>
                    </div>
                <?php endif;?>


                <!-- Sidebar Menu -->
                    <nav class="mt-2" hidden>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="index.php" class="nav-link " id="Dashboard">
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
                            <a href="salesforecast.html" class="nav-link">
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
                                <a href="feedbackreports.html" class="nav-link">
                                <i class="far fa-comment nav-icon"></i>
                                <p>Feedback Reports
                                    <span class="badge badge-info right">2</span>
                                </p>
                                </a>
                            </li>
                            </ul>
                        </li>
                        
                        </ul>
                    </nav>
                <!-- /.sidebar-menu -->

                
                <!-- Sidebar Menu -->
                    <nav class="mt-2 " > 
                        <ul class="nav nav-pills nav-sidebar  mb-5" data-widget="treeview" role="menu" data-accordion="false" >
                            <li class="nav-item ">
                                <div class="card nav-link active" >
                                    <div class="">
                                        <a href="#cancel_product_order" class="float-right text-dark" id="cancel_pos_cart" title="Cancel transaction">x</a>
                                        <!-- <span class=" float-left" id="total_cart_product_count">Total Items: </span><br> -->
                                        <!-- <span class=" float-left" id="total_cart_product_amount">Sub total: </span><br>
                                        <span class=" float-left" id="total_cart_product_amount">Tax: </span><br> -->
                                        

                                        <!-- <input type="text" id="sub_total" value="0"><br> -->
                                        <input type="hidden" id="total_cart_product_amount_value_hidden" value="0">
                                        <label class="" id="total_cart_product_amount">Total: </label><br>

                                        <label for="">SENIOR/PWD ID</label>
                                        <input type="checkbox" class='check-input mr-1' id="senior" >
                                        <input type="hidden" id="senior_id_discount" value="0" class='cart_details' >
                                        <input type="text" id="senior_id_number" class='form-control cart_details' placeholder='Enter Senior/PWD ID' maxlength = "12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); " hidden>
                                        <br>

                                        <label for="" id="discount_label">Discount</label>
                                        <input type="number" id="order_discount" value="0" class="form-control cart_details mb-2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" disabled>

                                        <label for="">Payment<span class='text-danger'>*</span></label>
                                        <input type="number" id="order_payment" value="0" class="form-control cart_details mb-2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        
                                        <label for="">Change</label>
                                        <input type="number" id="order_change" value="0" class="form-control cart_details mb-2" disabled>
                                        
                                        <label for="">Notes:</label>
                                        <textarea id="notes" id="" cols="30" rows="2" class="form-control mb-2" oninput="this.value = this.value.replace(/[^0-9.a-zA-Z ]/g, '').replace(/(\..*)\./g, '$1');"></textarea>

                                        

                                        <button type="submit" class="btn btn-success btn-sm float-right w-100 p-3 extra-btn" id="checkout_pos" >Checkout</button>
                                    </div>
                                </div>
                            </li>
                        </ul> 
                        <div id="POS_CART"  style="max-height:40vh; overflow: visible;" class="mb-5">
                            
                        </div>

                    </nav>
                <!-- /.sidebar-menu -->

            </div>
            <!-- /.sidebar -->
        </aside>


       

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header" hidden>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="m-0">Point of Sales</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Point of Sales</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header" hidden>
                                    <input type="text"  id="search"  placeholder="Search..." class="form-control mb-2" style="width:400px;" >
                                    <span id="result"></span>
                                </div>

                                <?php 
                                    $category_list = "SELECT * FROM category_tbl WHERE is_active=1 ";
                                    $categroy_result_list = $con->query($category_list);
                                    if ($categroy_result_list->num_rows>0) {
                                        $category_array_list_checker_for_add_ons_modal_display = [];
                                        while ($category_row = $categroy_result_list->fetch_assoc()){ 
                                            $category = $category_row['category'];

                                        ?>

                                            <section id="product1" class="section-p1  " >
                                                <h2 class='' ><?= $category ?></h2>
                                                <div class="pro-container d-flex justify-content-center"  >
                                                    <?php 
                                                        $product_array_list_checker_for_count = [];
                                                        $product_list = "SELECT * FROM products_tbl WHERE category='$category' AND product_quantity>0 AND is_active=1"; //category = category_name
                                                        $product_list_result = $con->query($product_list);
                                                        if ($product_list_result->num_rows>0) {
                                                            while ($product_list_row = $product_list_result->fetch_assoc()){ 
                                                                array_push($product_array_list_checker_for_count,substr($product_list_row['product'], 0, -4)); //store displayed product
                                                            }
                                                        }
                                                        $product_array_list_count = array_count_values($product_array_list_checker_for_count);
                                                        // print_r($product_array_list_count);
                                                        $product_array_list_checker = [];
                                                        $product_list = "
                                                            SELECT * 
                                                            FROM products_tbl  WHERE category='$category'  
                                                            AND product_quantity>0 
                                                            $condition 
                                                            AND is_active=1
                                                        "; //category = category_name
                                                        // echo $product_list;
                                                        $result_list = $con->query($product_list);
                                                        if ($result_list->num_rows>0) {
                                                            while ($row = $result_list->fetch_assoc()){ 

                                                                $product_id=$row['product_id'];
                                                                $product_quantity=$row['product_quantity'];
                                                                $product_price = $row['product_price'];
                                                                $category = $row['category'];

                                                                if($row['product']==""){
                                                                    $product = "Lorem, ipsum dolor.";
                                                                }else{
                                                                    $product = $row['product'];
                                                                }

                                                                if(strpos($row['product_image'], '.') !== false){
                                                                    $product_image = $row['product_image'];
                                                                }else{
                                                                    $product_image = "default.png";
                                                                }
                                                                // echo $animate_duration;
                                                                // echo "product_array_list_count: ";
                                                                // echo $product_array_list_count[substr($row['product'], 0, -4)];

                                                                if(!in_array(substr($row['product'], 0, -4),$product_array_list_checker)){
                                                                    if($product_array_list_count[substr($row['product'], 0, -4)]>=2){
                                                                        ?>
                                                                        <div class="pro m-1"   >
                                                                            <div class="des">
                                                                                <span><?= substr($row['product'], 0, -4)?>  </span><br>
                                                                                <span>Quantity: <?= $product_quantity ?> </span>
                                                                                <h4>₱<?= $row['product_price'] ?></h4>
                                                                            </div>
                                                                                <input type="hidden" value="<?= $row['category'] ?>">
                                                                                <input type="hidden" value="<?= $product ?>">
                                                                                <a href="#add_to_cart" class="normal mt-5 " id="add_to_cart_sizes" data-toggle="modal" data-target="#display-product-sizes-modal"><i class="fas fa-plus cart"></i></a>
                                                                        </div>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <div class="pro m-1"   >
                                                                            <div class="des" >
                                                                                <span><?= $row['product']?>  </span><br>
                                                                                <span>Quantity: <?= $product_quantity ?> </span>
                                                                                <h4>₱<?= $row['product_price'] ?></h4>
                                                                            </div>
                                                                            
                                                                            <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                                                                            <input type="hidden" value="<?=$row['product']?>" id="product">
                                                                            <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                                                                            <?php 
                                                                                $add_hypen_for_add_ons_modal =  str_replace(" ", "-", $category);
                                                                            ?>
                                                                            <a href="#add_to_cart" class="normal" id="add_to_cart_p1" data-toggle='modal' data-target='#<?=$add_hypen_for_add_ons_modal?>-add-ons-modal'><i class="fas fa-plus cart"></i></a>
                                                                        </div>
                                                                        <?php 
                                                                    }//end else
                                                                }//end else

                                                                if(substr($row['product'], -1)==")") {
                                                                    array_push($product_array_list_checker,substr($row['product'], 0, -4));
                                                                }else{
                                                                    array_push($product_array_list_checker,$row['product']);
                                                                }
                                                                // echo "product_array_list_checker:";
                                                                // print_r($product_array_list_checker);
                                                                if(!in_array($category,$category_array_list_checker_for_add_ons_modal_display)){
                                                                    array_push($category_array_list_checker_for_add_ons_modal_display,$category);
                                                                    $add_hypen_for_add_ons_modal =  str_replace(" ", "-", $category);
                                                                    ?>
                                                                        <!--  add-ons modal -->
                                                                        <div class="modal fade" id="<?=$add_hypen_for_add_ons_modal?>-add-ons-modal">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header j-orange">
                                                                                        <h4 class="modal-title text-white"><?=$category?> - ADD ONS</h4>
                                                                                    <a href="#" class=" btn btn-close" style='text-decoration:none;' data-dismiss="modal" aria-label="Close"></a>
                                                                                    </div>

                                                                                    <div class="modal-body">
                                                                                            <?php 
                                                                                                $add_ons_list = "
                                                                                                    SELECT * 
                                                                                                    FROM add_ons_list_tbl 
                                                                                                    WHERE add_ons_category='$category'  
                                                                                                    AND add_ons_quantity>0 
                                                                                                    AND is_active=1
                                                                                                "; //category = category_name
                                                                                                $result_add_ons_list = $con->query($add_ons_list);
                                                                                                if ($result_add_ons_list->num_rows>0) {
                                                                                                    while ($add_ons_row = $result_add_ons_list->fetch_assoc()){ 
                                                                                                        // echo $add_ons_row['add_ons'] ."<br>";
                                                                                                        $add_ons_category =  $add_ons_row['add_ons_category'];
                                                                                                        ?>
                                                                                                            <div class="form-check d-flex justify-content-start">
                                                                                                                <input class="form-check-input add_ons" type="radio" id="<?=$add_ons_row['add_ons']?><?=$add_ons_row['add_ons_category']?>" value="<?=$add_ons_row['add_ons_list_id']?>"   name="<?=$add_hypen_for_add_ons_modal?>">
                                                                                                                <label class="form-check-label " for="<?=$add_ons_row['add_ons']?><?=$add_ons_row['add_ons_category']?>">
                                                                                                                    <?=$add_ons_row['add_ons']?> ₱<?=$add_ons_row['add_ons_price']?> 
                                                                                                                </label>
                                                                                                            </div>
                                                                                                        <?php
                                                                                                    }
                                                                                                }
                                                                                            ?>
                                                                                            
                                                                                            <div class="form-check d-flex justify-content-start">
                                                                                                <input class="form-check-input no_add_ons " type="radio" value="no_add_ons" id="<?=$add_ons_category?>" name="<?=$add_hypen_for_add_ons_modal?>" checked >
                                                                                                <label class="form-check-label float-start" for="<?=$add_ons_category?>">
                                                                                                    No add ons 
                                                                                                </label>
                                                                                            </div>


                                                                                    </div>
                                                                                    <div class="modal-footer ">
                                                                                        <label for="">Quantity</label>
                                                                                        <input class="form-control w-50 " type="number" value="1" class="order_quantity p-2"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                                                                        <div id="subtotal" class="d-flex justify-content-center " style="border:0;margin:0;padding:0;">
                                                                                            <button type="button" class="normal mx-1" data-dismiss="modal" >Cancel</button>
                                                                                            <input type="hidden" value="" id="product_id_modal" class="product_id_modal">
                                                                                            <input type="hidden" value="" id="product_modal" class="product_modal">
                                                                                            <input type="hidden" value="" id="product_price_modal">
                                                                                            <!-- <a href="#coffee_add_ons_modal" id="add_to_cart" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-cart-shopping cart"></i> Add to Cart</a> -->
                                                                                            <button class="normal cartv2" id="add_to_cart" data-dismiss="modal">Add&nbsp;to&nbsp;Cart</button> 
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /.modal-content -->
                                                                            </div>
                                                                            <!-- /.modal-dialog -->
                                                                        </div>
                                                                        <!-- /.modal -->

                                                                    <?php
                                                                }//end if category_array_list_checker_for_add_ons_modal_display
                                                            }//end while
                                                        } //end if
                                                    ?>
                                                </div>
                                            </section>

                                        <?php
                                        }//end of while
                                    } // end of if

                                    // print_r($category_array_list_checker_for_add_ons_modal_display);
                                
                                ?>
                                
                            </div>
                        <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
        </div>

    </div>
    <!-- /.content-wrapper -->
    

    <!-- unique display per product -->
    <div class="modal fade" id="display-product-sizes-modal"   data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title text-white">Select Size</h4>
                <!-- <button type="button" >
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <a href="#" class=" btn btn-close close-size" style='text-decoration:none;' data-dismiss="modal" aria-label="Close">x</a>
                </div>

                <div class="modal-body " style="margin:0;padding:0;">
                    <section id="product1" class="section-p1  " style="margin:0;padding:0;">
                        <div class="pro-container d-flex justify-content-center"  id="sizes-body" style="margin:0;padding:0;">
                           
                        </div>
                    </section>
                </div>

                <div class="modal-footer " hidden >
                    <!-- justify-content-between -->
                    <div class="j-orange pro" style="border:0;">
                        <div id="subtotal" class="d-flex justify-content-start" style="border:0;margin:0;padding:0;">
                            <div id="sizes-footer">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

<!-- Main Footer -->
<footer class="main-footer" hidden>
    <strong>Copyright &copy; 2022 <a href="#">BIN-YANG Coffee & Tea</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0.0
    </div>
</footer>


</div>

    




<!-- !!!!!!!!!!!!!!!! -->
<!-- SCRIPTS! -->
<!-- !!!!!!!!!!!!!!!! -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<!-- <script src="plugins/chart.js/Chart.min.js"></script> -->

<!-- <script src="dist/js/pages/dashboard3.js"></script> -->
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>
<!-- swal -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery.session@1.0.0/jquery.session.min.js" ></script>

<script>

    // ======================

    function increaseValue(id_value) {
        var value = parseInt(document.getElementById(id_value).value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        document.getElementById(id_value).value = value;
    }

    function decreaseValue(id_value) {
        // alert(id_value);
        var value = parseInt(document.getElementById(id_value).value, 10);
        value = isNaN(value) ? 0 : value;
        // value < 1 ? value = 1 : ''; // TO LIMIT UNTIL 0 VALUE
        value--;
        if(value<0){
            value=0;
        }
        document.getElementById(id_value).value = value;
    }

    

    $(document).ready(function () {

        //add_to_cart_p1
        $(document).on('click','#add_to_cart_p1', function  (e) {
            var product_id = $(this).prev().prev().prev().val();
            var product = $(this).prev().prev().val();
            var product_price = $(this).prev().val();

            // console.log(product_id);
            // console.log(product);
            // console.log(product_price);

            $('.product_id_modal').val(product_id);
            $('.product_modal').val(product);
            $('.product_price_modal').val(product_price);

            $('#display-product-sizes-modal').modal('hide');
            $('#sizes-body').html('');
        });

        console.log($(location).attr('pathname').match(/([^\/]*)\/*$/)[1]);
        var page_location = $(location).attr('pathname').match(/([^\/]*)\/*$/)[1];
        // if(page_location=="index.php"){
        //     console.log('index')
        //     $('#Dashboard').addClass( "active" );
        // }
        // if(page_location=="inventory.php"){
        //     console.log('inventory')
        //     $('#Inventory').addClass( "active" );
        // }
        // if(page_location=="user_management.php"){
        //     console.log('user_management')
        //     $('#User_management').addClass( "active" );
        // }
        // if(page_location=="order_management.php"){
        //     console.log('order_management')
        //     $('#Order_management').addClass( "active" );
        // }
        
        // if(page_location=="sales_reports.php"){
        //     console.log('sales_reports')
        //     $('#Sales_report').addClass( "active" );
        // }

        // script to get the currentnotif
        function getdata(){
            $.ajax({
            type: 'post',
            url: 'get_order_count.php',
            success: function (response) {
                // console.log(response);
                // $('#pending_order').text(response);

                var obj = JSON.parse(response);
                $('#total_notif').text(obj.total_notif);
                $('#inside_total_notif').text(obj.total_notif+" Notifications");
                $('#inside_body_total_notif').text(obj.total_notif+" products are required to restock.");
                // console.log(obj.check_stocks_data);
                
            }
            });
        }

        setInterval(function () {getdata()}, 1000);


        
        var cart_values = [];
        


        $("#search").keyup(function(){  //for on input search.
            $.ajax({
                type: 'post',
                url: 'point_of_sales_process.php',
                data: {
                    'search': $('#search').val()
                },
                success:function(result){
                    console.log('Search');
                    // console.log($('#search').val());
                    // console.log(result);
                    if(result!=""){
                        $("#result").html(
                            `<section class="content" style="z-index:9999">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header j-orange">
                                                    Search Results
                                                </div>
                                                <section id="product1" class="  " >
                                                    <div class="pro-container "  >
                                                        <div class="row d-flex justify-content-center ">`
                                                            + result+
                                                        `</div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            `
                        );
                    }else{
                        $("#result").html("");
                    }
                    
                }
            });
        });


        // $('.cart').on('click',function(){
        $(document).on('click','.cartv2', function  (e) {
            var product_id = $(this).prev().prev().prev().val();
            var product = $(this).prev().prev().val();
            var product_quantity = $(this).parent().prev().val();
            // console.log("product_quantity "+product_quantity);
          
            var add_ons=$('.add_ons:radio:checked').val();
            // console.log('add_ons:' + add_ons);
            
            cart_values.push(product_id);
            $('#POS_CART').append(addToCart(product_id,add_ons,cart_values.length));

            //toast here
            var x = document.getElementById("added_to_cart");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            
            
            $('#total_cart_product_count').html("Total Items: "+cart_values.length);
            // console.log(cart_values);

            function addToCart(id,add_ons,cart_length){

                $.ajax({
                    type: 'post',
                    url: 'get_product_details.php',
                    data: {
                        'id' : id,
                        'add_ons' : add_ons,
                    },
                    success: function (response) {
                        // console.log(response);

                        var obj = JSON.parse(response);
                        var product_id = obj.product_id;
                        var product = obj.product;
                        var price = obj.price;
                        var add_ons_price = obj.add_ons_price;
                        var add_ons_name = obj.add_ons_name;

                        var add_ons_total = add_ons_price * product_quantity;
                        var product_total = price * product_quantity;
                        var total_product_with_addons = add_ons_total + product_total;

                        if(add_ons!=null){
                            $('#availed_add_ons_details'+product_id+'-'+cart_length).append(
                                '<hr> Add-ons: <br>'
                            );

                            $('#availed_add_ons_details'+product_id+'-'+cart_length).append(
                                '<span >₱'+add_ons_price+'</span>'+
                                '<span >'+add_ons_name+'</span><br>'+
                                '<span  class="availed_add_ons_id availed_add_ons_id'+product_id+'-'+cart_length+'" hidden >'+add_ons+'</span>'
                            );
                        }
                        

                        $('#availed_add_ons_details'+product_id+'-'+cart_length).append(
                            '<hr> Quantity: <span class="availed_product_quantity" id="availed_product_quantity'+id+'-'+cart_length+'">'+product_quantity+'</span><br>'+
                            'Sub Total: ₱<span class="availed_add_ons" >'+total_product_with_addons+'</span><br>'
                        );
                       
                        // end of add_ons

                       
                        $('#availed_product_id'+product_id+'-'+cart_length).html(product);
                        $('#availed_price_id'+product_id+'-'+cart_length).text("₱"+price);
                        var total_cart_product_amount = $('#total_cart_product_amount_value_hidden').val();
                        total_cart_product_amount = parseFloat(total_cart_product_amount)+parseFloat(total_product_with_addons); 
                        $('#total_cart_product_amount').text("Total: "+total_cart_product_amount.toFixed(2));
                        $('#total_cart_product_amount_value_hidden').val(total_cart_product_amount);

                        total_cart_product_amount -=parseFloat($('#order_discount').val());
                        change = parseFloat($('#order_payment').val()) - parseFloat(total_cart_product_amount);
                        if($('#order_payment').val()!=0){
                            $('#order_change').val(change);
                        }
                        // $('#total_notif').text(obj.product);
                        // $('#inside_total_notif').text(obj.total_notif+" Notifications");
                        // $('#inside_body_total_notif').text(obj.total_notif+" products are required to restock.");
                        // console.log(obj.check_stocks_data);

                      
                        $('.no_add_ons').prop('checked', true);
                    }
                });


                $('#display-product-sizes-modal').modal('hide');
                $('#sizes-body').html('');

                return `
                    <ul class="nav nav-pills nav-sidebar  ul_avaled_id`+id+'-'+cart_length+` mb-1" data-widget="treeview" role="menu" data-accordion="false" style="max-height:60vh; overflow: visible;" id="">
                        <li class="nav-item ">
                            <div class="card nav-link active" >
                                <div style="" >
                                    <a href="#cancel_availed_id" class="float-right text-dark cancel_availed_id availed_id`+id+'-'+cart_length+`"  >x</a>
                                    <p class=" float-left text-white availed_product_id" id="availed_product_id`+id+'-'+cart_length+`"></p>
                                    <p class=" float-left text-white availed_price_id w-100" id="availed_price_id`+id+'-'+cart_length+`"></p>
                                    <p class=" float-left text-white availed_add_ons_details  mt-2" id="availed_add_ons_details`+id+'-'+cart_length+`"></p>
                                </div>
                                <div class="" hidden>
                                    <div class="wrapper2" >
                                        <span class="minus text-danger d-flex justify-content-center" id="decrease_quantity" onclick="decreaseValue('availed_quantity`+id+`')">-</span>
                                        <input type="number" value="1" class="form-control num availed_quantity_class availed_quantity`+id+`" style="width:60px;text-align:center;padding:0;height:30px" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(/\..*)/\./g, '$1');">
                                        <span class="plus text-success d-flex justify-content-center" id="increase_quantity" onclick="increaseValue('availed_quantity`+id+`')">+</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                `;
            }
        });

        $('#cancel_pos_cart').on('click',function(){
            console.log('cancel_pos_cart');
            cart_values = [];
            $('#total_cart_product_count').html("Total Items: ");
            $('#POS_CART').html('');

            $('#total_cart_product_amount').text("Total: ");
            $('#total_cart_product_amount_value_hidden').val(0);

            total_amount = 0;
            $('.availed_price_id').each(function(){
                // console.log($(this).text());
                total_amount +=parseFloat($(this).text().substr(1));
            });
            // console.log(total_amount);
            if(total_amount==0){
                total_amount="";
            }
            $('#total_cart_product_amount').text("Total: "+total_amount);

            $('#order_discount').val(0);
            $('#order_payment').val(0);
            $('#order_change').val(0);
            $('#notes').val('');

            
             //open buttons
            $('.cart').prop('hidden', false); 
            $('.wrapper2').css('pointer-events', 'auto');
            $('#senior').css('pointer-events', 'auto');
            $('#senior').prop('checked',false);
            $('#senior_id_number').attr('hidden', true);

            //toast here
            var x = document.getElementById("cancel_cart");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

        });

        $(document).on('click','.cancel_availed_id', function(){

            var get_availed_id = $(this).attr('class').split(' ').pop();
            console.log(get_availed_id);
            var get_availed_id_number = get_availed_id.replace(/[^\d.-]/g, '');
            var filteredArray = cart_values.filter(e => e !== get_availed_id_number);
            cart_values = filteredArray;
            
            var cart_total = '';
            if(cart_values.length>0){
                cart_total = cart_values.length;
            }
            $('.ul_avaled_id'+get_availed_id_number).html('');

            total_amount = 0;
            $('.availed_add_ons').each(function(){
                total_amount +=parseFloat($(this).text());
            });

            console.log("total_amount" + total_amount);
            
            total_amount -=parseFloat($('#order_discount').val());
            change = parseFloat($('#order_payment').val()) - parseFloat(total_amount);
            if($('#order_payment').val()!=0){
                $('#order_change').val(change);
            }

            if(cart_values.length==0){
                $('#order_discount').val(0);
                $('#order_payment').val(0);
                $('#order_change').val(0);
                total_amount=0;
            }

            // console.log(total_amount);
            $('#total_cart_product_amount').text("Total: "+total_amount.toFixed(2));
            $('#total_cart_product_amount_value_hidden').val(total_amount);
           
            //toast here
            var x = document.getElementById("cancel_cart_id");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        });

        // $('.cancel_availed_id').on('click',function(){

        // });

        // $(document).on('click','#increase_quantity', function  (e) {
        //     console.log('increase_quantity');
        //     get_availed_id = $(this).prev().attr('id');
        //     var get_availed_id_number = get_availed_id.replace(/[^\d.-]/g, '');

        //     $.ajax({
        //         type: 'post',
        //         url: 'get_product_details.php',
        //         data: {
        //             'id' : get_availed_id_number,
        //         },
        //         success: function (response) {
                  
        //             var obj = JSON.parse(response);
        //             var product_id = obj.product_id;
        //             var product = obj.product;
        //             var price = obj.price;
        //             var quantity = obj.quantity;

        //             // console.log("quantity: "+quantity );
        //             // console.log('#availed_quantity'+get_availed_id_number);
        //             // $('#availed_quantity'+get_availed_id_number).val(parseInt($('#availed_quantity'+get_availed_id_number).val())+50)
        //             if(parseInt($('#availed_quantity'+get_availed_id_number).val())>parseInt(quantity)){
        //                 // console.log("You've reached the maximum quantity: "+quantity);
        //                 $('#availed_quantity'+get_availed_id_number).val(quantity);
        //                 swal({
        //                     title: "You've reached the maximum quantity: "+quantity,
        //                     // text: "Once deleted, you will not be able to recover this user!",
        //                     icon: "info",
        //                     buttons: "OK",
        //                     dangerMode: true,
        //                 });
        //             }
                  
        //             var new_amount = parseFloat(price) * parseFloat($('#availed_quantity'+get_availed_id_number).val());
        //             $('#availed_price_id'+get_availed_id_number).text('₱'+new_amount);

        //             total_amount = 0;
        //             $('.availed_price_id').each(function(){
        //                 total_amount +=parseFloat($(this).text().substr(1));
        //             });
        //             total_amount -=parseFloat($('#order_discount').val());
        //             change = parseFloat($('#order_payment').val()) - parseFloat(total_amount);
        //             if($('#order_payment').val()!=0){
        //                 $('#order_change').val(change.toFixed(2));
        //             }
        //             $('#total_cart_product_amount').text("Total: "+total_amount.toFixed(2));
        //             $('#total_cart_product_amount_value_hidden').val(total_amount);
        //         }
        //     });

        // });

        // $(document).on('click','#decrease_quantity', function  (e) {
        //     console.log('decrease_quantity');
        //     get_availed_id = $(this).next().attr('id');
        //     var get_availed_id_number = get_availed_id.replace(/[^\d.-]/g, '');
        //     $.ajax({
        //         type: 'post',
        //         url: 'get_product_details.php',
        //         data: {
        //             'id' : get_availed_id_number,
        //         },
        //         success: function (response) {
                  
        //             var obj = JSON.parse(response);
        //             var product_id = obj.product_id;
        //             var product = obj.product;
        //             var price = obj.price;


        //             var new_amount = parseFloat(price) * parseFloat($('#availed_quantity'+get_availed_id_number).val());
        //             $('#availed_price_id'+get_availed_id_number).text('₱'+new_amount);
                   

        //             total_amount = 0;
        //             $('.availed_price_id').each(function(){
        //                 total_amount +=parseFloat($(this).text().substr(1));
        //             });

        //             total_amount -=parseFloat($('#order_discount').val());
        //             change = parseFloat($('#order_payment').val()) - parseFloat(total_amount);
        //             if($('#order_payment').val()!=0){
        //                 $('#order_change').val(change.toFixed(2));
        //             }

        //             $('#total_cart_product_amount').text("Total: "+total_amount.toFixed(2));
        //             $('#total_cart_product_amount_value_hidden').val(total_amount);
        //         }
        //     });
        // });

        $(document).on('keyup','.availed_quantity_class, .cart_details', function  (e) {
            console.log('keyup_quantity');
            get_availed_id = $(this).attr('id');
            var get_availed_id_number = get_availed_id.replace(/[^\d.-]/g, '');
            // console.log(get_availed_id);
            // console.log(get_availed_id_number);
            
            $.ajax({
                type: 'post',
                url: 'get_product_details.php',
                data: {
                    'id' : get_availed_id_number,
                },
                success: function (response) {
                  
                    var obj = JSON.parse(response);
                    var product_id = obj.product_id;
                    var product = obj.product;
                    var price = obj.price;
                    var quantity = obj.quantity;

                    // console.log("quantity: "+quantity );
                    // console.log('#availed_quantity'+get_availed_id_number);
                    // $('#availed_quantity'+get_availed_id_number).val(parseInt($('#availed_quantity'+get_availed_id_number).val())+50)
                    if(parseInt($('#availed_quantity'+get_availed_id_number).val())>parseInt(quantity)){
                        // console.log("You've reached the maximum quantity: "+quantity);
                        $('#availed_quantity'+get_availed_id_number).val(quantity);
                        swal({
                            title: "You've reached the maximum quantity: "+quantity,
                            // text: "Once deleted, you will not be able to recover this user!",
                            icon: "info",
                            buttons: "OK",
                            dangerMode: true,
                        });
                    }

                    
                    var new_amount = parseFloat(price) * parseFloat($('#availed_quantity'+get_availed_id_number).val());
                    $('#availed_price_id'+get_availed_id_number).text('₱'+new_amount);

                    var total_amount = 0;
                    var change = 0;
                    $('.availed_add_ons').each(function(){
                        total_amount +=parseFloat($(this).text());
                    });

                    $('.availed_add_ons_price').each(function(){
                        total_amount +=parseFloat($(this).text().substr(1));
                    });

                    total_amount -=parseFloat($('#order_discount').val());
                    change = parseFloat($('#order_payment').val()) - parseFloat(total_amount);
                    if($('#order_payment').val()!=0){
                        $('#order_change').val(change.toFixed(2));
                    }

                    

                    $('#total_cart_product_amount').text("Total: "+total_amount.toFixed(2));
                    $('#total_cart_product_amount_value_hidden').val(total_amount);

                }
            });
        });

        // console.log("session_check_1 "+$.session.get('order_id'));
        // $.session.remove('inserted_order_id');

        $(document).on('click','#checkout_pos', function  (e) {
            console.log('checkout_pos');

            if(cart_values.length === 0){
                swal({
                    title: "List is empty.",
                    // text: "Once deleted, you will not be able to recover this user!",
                    icon: "info",
                    buttons: "OK",
                    dangerMode: true,
                });
            }else{
                var to_pay = $('#total_cart_product_amount_value_hidden').val();
                var paid = $('#order_payment').val();

                if(parseFloat(to_pay)>parseFloat(paid) ){
                    swal({
                        title: "Please pay the right amount.",
                        // text: "Once deleted, you will not be able to recover this user!",
                        icon: "info",
                        buttons: "OK",
                        dangerMode: true,
                    });
                }else{
                    swal({
                    title: "Checkout Order",
                    icon: "info",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        // var insert_order_id_count = 1;

                        var senior_id_number = $('#senior_id_number').val();
                        var order_discount = $('#order_discount').val();
                        var order_amount = $('#total_cart_product_amount_value_hidden').val();
                        var order_payment = $('#order_payment').val();
                        var order_change = $('#order_change').val();
                        var notes = $('#notes').val();
                        $.ajax({
                            type: 'post',
                            url: 'point_of_sales_process.php',
                            data: {
                                'insert_order_tbl' :1,
                                'senior_id_number' : senior_id_number,
                                'order_discount': order_discount,
                                'order_amount': order_amount,
                                'order_payment': order_payment,
                                'order_change': order_change,
                                'notes': notes,
                            },
                            success: function (response) {
                                var obj = JSON.parse(response);
                                $('#order_id_session').val(obj.inserted_order_id);
                                var order_id = obj.inserted_order_id;
                              
                                $('.availed_price_id').each(function(){ //to get id langs na nasa cart

                                    var get_availed_id = $(this).attr('id');
                                    console.log("get_availed_id "+get_availed_id);
                                    var get_availed_id_number = get_availed_id.replace(/[^\d.-]/g, '');
                                    console.log("get_availed_id_number "+get_availed_id_number);
                                    var product = $('#availed_product_id'+get_availed_id_number).text();
                                    console.log("product: "+product);
                                    // var availed_quantity = $('#availed_quantity'+get_availed_id_number).val();
                                    var availed_quantity = $('#availed_product_quantity'+get_availed_id_number).text();
                                    console.log("availed_quantity "+ availed_quantity);
                                    
                                    // ito na yung mga data, ipasok na sa ajax>php process>kunin details>insert sa order_table>insert saa availed
                                    $.ajax({
                                        type: 'post',
                                        url: 'point_of_sales_process.php',
                                        data: {
                                            'insert_point_of_sales' :1,
                                            'product_id'            :get_availed_id_number,
                                            'availed_product'       :product,
                                            'availed_quantity'      :availed_quantity,
                                            'inserted_order_id'     :order_id,
                                        },
                                        success: function (response) {
                                            console.log(response);
                                            var obj = JSON.parse(response);
                                            console.log("order_id: "+ obj.inserted_order_id);
                                            console.log("inserted_availed_id: "+ obj.inserted_availed_id);

                                            var inserted_availed_id = obj.inserted_availed_id;
                                            var get_availed_add_ons_id = $('.availed_add_ons_id'+get_availed_id_number).text();
                                            console.log('get_availed_add_ons_id: '+get_availed_add_ons_id);
                                                
                                            $.ajax({
                                                type: 'post',
                                                url: 'point_of_sales_process.php',
                                                data: {
                                                    'get_add_ons_details' : 1,
                                                    'add_ons' : get_availed_add_ons_id,
                                                },success: function (response) {
                                                    console.log(response);
                                                    var obj = JSON.parse(response);
                                                    console.log("add_ons_name: "+ obj.add_ons_name);
                                                    console.log("add_ons_price: "+ obj.add_ons_price);
                                                    var get_availed_add_ons = obj.add_ons_name;
                                                    var availed_add_ons_price = obj.add_ons_price;
                                                    $.ajax({
                                                        type: 'post',
                                                        url: 'point_of_sales_process.php',
                                                        data: {
                                                            'insert_add_ons' :1,
                                                            'product_id'            :get_availed_id_number,
                                                            'availed_product'       :product,
                                                            'inserted_order_id'     :order_id,
                                                            'inserted_availed_id'   :inserted_availed_id,
                                                            'availed_add_ons'       :get_availed_add_ons,
                                                            'availed_add_ons_price' :availed_add_ons_price,
                                                            'availed_quantity' :availed_quantity,
                                                        },
                                                        success: function (response) {
                                                            console.log(response);
                                                            var obj = JSON.parse(response);
                                                            console.log("add_ons_id: "+ obj.inserted_add_ons_id);
                                                        }
                                                    });
                                                }
                                            });
                                            
                                            
                                        }
                                    });

                                });

                                setTimeout(function(){
                                    window.open("https://binyang.online/admin/assets/fpdf184/export_pdf?order_id="+order_id);
                                }, 1000);
                                
                            }
                        });

                        swal({
                            title: "Order Has Been Placed.",
                            // text: "Once deleted, you will not be able to recover this product!",
                            icon: "success",
                            buttons: "OK",
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            // if (willDelete) {
                                //reset
                                cart_values = [];
                                $('#POS_CART').html('');
                                $('#total_cart_product_amount').text("Total: ");
                                $('#total_cart_product_amount_value_hidden').val(0);

                                $('#order_discount').val(0);
                                $('#order_payment').val(0);
                                $('#order_change').val(0);
                                $('#notes').val('');

                                window.location="";
                               
                            // }
                        });

                    } 
                    else {
                        // $("#availed_quantity"+get_availed_id_number).val(0);
                    }
                });
                }

                
 
            }


        });

        $(document).on('click','#senior', function  (e) {
            // e.preventDefault();
            console.log('senior');
            swal({
                title: "Notice!",
                text: "Make sure your cart is final to apply the 20% discount.",
                icon: "info",
                // buttons: true,
                buttons:["Cancel", "Yes, it is final."],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    if($(this).is(':checked')){
                        console.log('senior');
                        $('#senior_id_number').attr('hidden', false);
                        $('#discount_label').text("20% Discount");
                        var total_amount = $('#total_cart_product_amount_value_hidden').val();
                        console.log(total_amount);
                        var discount = 0.20; //20%
                        var discount_value = total_amount * discount ;
                        discount_value = discount_value.toFixed(2);
                        console.log(discount_value);
                        total_amount -=discount_value;
                        console.log(total_amount);

                        var payment = $('#order_payment').val();
                        var change =  payment - total_amount;
                        change = change.toFixed(2);
                        console.log(change);
                        $('#order_change').val(change);
                        $('#order_discount').val(discount_value);
                        $('#total_cart_product_amount_value_hidden').val(total_amount);
                        $('#total_cart_product_amount').text("Total: "+total_amount.toFixed(2));


                        //hide buttons
                        $('.cart').prop('hidden', true); 
                        $('.wrapper2').css('pointer-events', 'none');
                        $('#senior').css('pointer-events', 'none');
                        $('.cancel_availed_id').prop('hidden', true);
                        // $('#increase_quantity').prop('hidden', true); 
                        // $('#descrease_quantity').prop('hidden', true); 
                    }else{
                        console.log('not senior');
                    
                        $('#senior_id_number').attr('hidden', true);
                        $('#senior_id_number').val('');
                        $('#order_discount').val(0);
                        $('#discount_label').text("Discount");

                        window.location='';

                    }
                }else{
                    console.log('cancel');
                    $('#senior').prop('checked',false);
                }
            });
            
        });

        

        // $('#senior').on('click', function  () {
        //     console.log('seniorv2');
        //     if($(this).is(':checked')){
        //         //hide buttons
        //         // $('.cart').prop('hidden', true); 
        //         // $('.minus').css("display", "none");
        //         // $('.availed_quantity_class').prev().hide();

        //     }
        // });

        // $("#senior").click(function() {
        //     console.log('seniorv3');
        //     if($(this).is(':checked')){
        //         //hide buttons
        //         // $('.cart').prop('hidden', true); 
        //         // $('.wrapper2').css("display", "none");
        //         // $('.availed_quantity_class').prev().hide();
        //     }
        // });

        $(document).on('click','.no_add_ons', function  (e) {

            $('.add_ons').prop('checked', false); // Unchecks it

        });

        $(document).on('click','.add_ons', function  (e) {

            $('.no_add_ons').prop('checked', false); // Unchecks it

        });


        $(document).on('click','#add_to_cart_sizes', function  (e) {

            console.log("add_to_cart_sizes");
            // console.log($(this).prev().val());

            var category = $(this).prev().prev().val();
            var product = $(this).prev().val();
            product = product.slice(0, -4);
            // console.log(product);
            // console.log("category: " +category);
            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'get_products' : 1,
                    'product' : product,
                    'category' : category,
                },
                success: function (response) {
                    console.log(response); //for debug
                    var obj = JSON.parse(response);

                    obj.get_products.forEach(element => {
                        var get_product_id = element[0];
                        var get_product_name = element[1];
                        var get_product_price = element[2];
                        var get_product_image = element[3];
                        var get_product_category = element[4];
                        console.log('product: ' + get_product_name);

                        category =  category.replace(/\s+/g, '-');

                        if(obj.check_with_add_ons==1){
                            $('#sizes-body').append(
                                `
                                    <div class="pro m-4">
                                        <div class="des">
                                            <span>`+get_product_name+` </span>
                                            <h4>₱`+get_product_price+`</h4>
                                        </div>
                                        <div class="mt-3">
                                            <input type="hidden" value="`+get_product_id+`" id="product_id" class="product_id">
                                            <input type="hidden" value="`+get_product_name+`" id="product">
                                            <input type="hidden" value="`+get_product_price+`" id="product_price">
                                            <a href="#add_to_cart" class="normal " id="add_to_cart_p1"  data-toggle="modal" data-target="#`+category+`-add-ons-modal"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        </div>
                                    </div>
                                `
                            );
                        }else{
                            $('#sizes-body').append(
                                `
                                    <div class="pro m-4">
                                        <div class="des">
                                            <span>`+get_product_name+` </span>
                                            <h4>₱`+get_product_price+`</h4>
                                        </div>
                                        <label for="order_quantity" class="float-start">Quantity</label>
                                        <input class="form-control w-100" type="number" value="1" id="order_quantity" class="order_quantity p-2" style="width:50px;" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        <div class='mt-5 pt-3'>          
                                            <input type="hidden" value="`+get_product_id+`" id="product_id" class="product_id">
                                            <input type="hidden" value="`+get_product_name+`" id="product">
                                            <input type="hidden" value="`+get_product_price+`" id="product_price">
                                            <a href="#add_to_cart" class="normal cartv2"  ><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        </div>         
                                    </div>
                                `
                            );
                        }
                    });

                    
                }
            });
        });

        $(document).on('click','.close-size', function  (e) {
            $('#sizes-body').html('');
        });

    });
</script>

</html>