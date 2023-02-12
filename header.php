<?php 
    include('admin/db_connection.php');

    $order_list = " SELECT *, COUNT(*) AS availed_count
                    FROM order_tbl
                    LEFT JOIN availed_product_tbl
                    ON order_tbl.order_id = availed_product_tbl.order_id
                    WHERE order_status = 'on-going' 
                    AND order_by='$session_username' "; 
    $result_list = $con->query($order_list);
    if ($result_list->num_rows>0) {
        while ($row = $result_list->fetch_assoc()){ 
            if($row['availed_id']!=""){
                $availed_count = $row['availed_count'];
            }
        }
    }

    if($availed_count==""){
        $hide_availed_count = "hidden";
    }

    //get image
    $sql = "SELECT * FROM users_tbl WHERE username='$session_username' LIMIT 1";
    $query=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($query);

    $client_side_user_image = $row[5];
    if($row[5]==""){
        $client_side_user_image="defaultv2.png";
    }else{
        if (!file_exists('admin/assets/img/'.$row[5])) {
            $client_side_user_image="defaultv2.png";
        }else{
            $client_side_user_image = $row[5];
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIN YANG</title>
    <link rel="icon" type="image/png" href="icon.png">

     <!-- edited css  ayaw gumana -j-->
     <!-- <link rel="stylesheet" href="admin/assets/css/custom_css.css"> -->
    <!--  -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/700816c2b5.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   
</head>
<style>
li a:hover {
background-color:#f08c0a;

}
#navbarMenu{
   flex:right;
}
</style>


    <!-- j-style for nav-->
    <style>

        .nav-link{
            color:gray;
            font-weight: 650;
        }
        .nav-link:hover{
            background:#b06548;
            color:white;
        }

        .main-text-des{
            color:#b06548;
        }

        .main-bg-des{
            background-color:#b06548;
        }

        
    </style>
<body>
    <!-- HEADER -->
    <nav class="navbar fixed-top navbar-expand-sm navbar-light bg-light ">
            <a href="/" data-aos="fade-right" data-aos-duration="1000"><img src="img/logo.png" class="logo px-5" alt="" id="logobinyang"></a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse  justify-content-end" id="navbarMenu" >
            <ul class="navbar-nav " style="margin-left:50px;margin-right:50px;">
                <li class="nav-item" data-aos="fade-left" data-aos-duration="1000">
                    <a href="/" id="Home" class="nav-link rounded" >Home</a>
                </li>
                <li class="nav-item" data-aos="fade-left" data-aos-duration="1500" >
                    <a href="menuV3.php" id="Menu" class="nav-link rounded">Menu</a>
                </li>
                <li class="nav-item" data-aos="fade-left" data-aos-duration="2000">
                    <a href="contact.php" id="Contact" class="nav-link rounded">Contact</a>
                </li>
                <?php if(isset($_SESSION['username'])):?>
                    <!-- <li><a href="profile.php" id="Profile">Profile: </a></li> -->
                    <li data-aos="fade-left" data-aos-duration="2500"><a href="?logout=1" id="Logout" class="nav-link rounded">Logout</a></li>
                    <li data-aos="fade-left" data-aos-duration="3000"><a href="profile.php" id="Profile" class="nav-link rounded"><img src="admin/assets/img/<?=$client_side_user_image?>" width="30px" height="30px" style="border-radius:50%;"></a></li>
                <?php else:?>
                    <li data-aos="fade-left" data-aos-duration="2500"><a href="login.php" id="Login" class="nav-link rounded">Login</a></li>
                <?php endif;?>
                <li id="lg-bag" class="nav-item"  data-aos="fade-left" data-aos-duration="3000">
                    <a  href="cart.php" id="Cart" class="nav-link position-relative rounded">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger hide_availed_count" <?= $hide_availed_count ?> >
                            <span id="availed_count" ><?= $availed_count ?></span>
                            <!-- <span class="visually-hidden">unread messages</span> -->
                        </span>

                    </a>
                </li>
                <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
                <div id="mobile">
                    <a href="cart.php" class="position-relative">
                        <i class="fa-solid fa-bag-shopping"></i> 
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <span id="availed_count" ><?= $availed_count ?></span>
                            <!-- <span class="visually-hidden">unread messages</span> -->
                        </span>
                    </a>
                    <i id="bar" class="fa-solid fa-ellipsis-vertical"></i>
                </div>
            </ul>
        </div>
        
    </nav>
    <!--
    <section id="header">
        <a href="/"><img src="img/logo.png" class ="logo" alt=""></a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="mt-2">
            <ul id="navbar">
                <li><a href="/" id="Home">Home</a></li>
                <li><a href="menu.php" id="Menu">Menu</a></li>
                <li><a href="menuV2.php" id="Menu">Menu</a></li>
                <li><a href="contact.php" id="Contact">Contact</a></li>
                
                <?//php if(isset($_SESSION['username'])):?>
                    <li><a href="?logout=1" id="Logout">Logout</a></li>
                    <li><a href="profile.php" id="Profile"><img src="admin/assets/img/<?//=$client_side_user_image?>" width="40px" height="40px" style="border-radius:50%;"></a></li>
                <?//php else:?>
                    <li><a href="login.php" id="Login">Login</a></li>
                <?//php endif;?>
                <li id="lg-bag" class="position-relative">
                    <a  href="cart.php" id="Cart" >
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger hide_availed_count" <?//= $hide_availed_count ?>>
                            <span id="availed_count" ><?//= $availed_count ?></span>
                        </span>
                    </a>
                </li>
                <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.php" class="position-relative">
                <i class="fa-solid fa-bag-shopping"></i> 
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <span id="availed_count" ><?//= $availed_count ?></span>
                </span>
            </a>
            <i id="bar" class="fa-solid fa-ellipsis-vertical"></i>
        </div>
    </section>
                -->