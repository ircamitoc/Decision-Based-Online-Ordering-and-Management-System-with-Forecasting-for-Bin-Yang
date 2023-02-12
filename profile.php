<?php include('header.php');
if(!isset($_SESSION['username'])){
  echo '<script> 
      alert("please login");
      window.location = "login.php";
  </script> '; 
}
?>

<?php 
        $delivery_fee_query = "SELECT delivery_fee FROM delivery_fee_tbl";
        $delivery_fee_query_run = mysqli_query($con, $delivery_fee_query);
        $delivery_fee_query_row=mysqli_fetch_array($delivery_fee_query_run);
        $delivery_fee = $delivery_fee_query_row['delivery_fee'];
?>

<style>

.card2 {
    /* margin: left; */
    width: 38%;
    max-width: 600px;
    padding: 4vh 0;
    /* box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19); */
    /* border-top: 3px solid rgb(252, 103, 49); */
    /* border-bottom: 3px solid rgb(252, 103, 49); */
    border-left: none;
    border-right: none
}

@media(max-width:768px) {
    .card2 {
        width: 90%
    }
}

.title {
    color: rgb(252, 103, 49);
    font-weight: 600;
    margin-bottom: 2vh;
    padding: 0 8%;
    font-size: initial
}

#details {
    font-weight: 400
}

.info {
    padding: 5% 8%
}

.info .col-5 {
    padding: 0
}

#heading {
    color: grey;
    line-height: 6vh
}

#progressbar {
    margin-bottom: 3vh;
    overflow: hidden;
    color: rgb(252, 103, 49);
    padding-left: 0px;
    margin-top: 3vh
}

#progressbar li {
    list-style-type: none;
    font-size: x-small;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400;
    color: rgb(160, 159, 159)
}

#progressbar #step1:before {
    content: "";
    color: rgb(252, 103, 49);
    width: 5px;
    height: 5px;
    margin-left: 0px !important
}

#progressbar #step2:before {
    content: "";
    color: #fff;
    width: 5px;
    height: 5px;
    margin-left: 32%;
}

#progressbar #step3:before {
    content: "";
    color: #fff;
    width: 5px;
    height: 5px;
    margin-right: 32%;
    /* margin-left: 0px !important */
}

#progressbar #step4:before {
    content: "";
    color: #fff;
    width: 5px;
    height: 5px;
    margin-right: 0px !important
}

#progressbar li:before {
    line-height: 29px;
    display: block;
    font-size: 12px;
    background: #ddd;
    border-radius: 50%;
    margin: auto;
    z-index: -1;
    margin-bottom: 1vh
}

#progressbar li:after {
    content: '';
    height: 2px;
    background: #ddd;
    position: absolute;
    left: 0%;
    right: 0%;
    margin-bottom: 2vh;
    top: 1px;
    z-index: 1
}

.progress-track {
    padding: 0 8%
}

#progressbar li:nth-child(1):after {
    margin: auto
}

#progressbar li:nth-child(2):after {
    margin-right: auto
}

#progressbar li:nth-child(3):after {
    float: left;
    width: 68%
}

#progressbar li:nth-child(4):after {
    margin-left: auto;
    width: 132%
}

#progressbar li.active {
    color: black
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: rgb(252, 103, 49)
}


/* cssfor ratings */
    .checked {
        color: orange;
        transition: .5s;
    }
/* end of css for ratings */
</style>

    <!-- rating css -->
        <style>
            .rate {
                float: left;
                /* height: 46px; */
                padding: 0 10px;
            }
            
            .rate:not(:checked) > input {
                position:absolute;
                top:-9999px;
            }
            .rate:not(:checked) > label {
                float:right;
                width:1em;
                overflow:hidden;
                white-space:nowrap;
                cursor:pointer;
                font-size:20px;
                color:#ccc;
            }
            .rate:not(:checked) > label:before {
                content: '★ ';
            }
            .rate > input:checked ~ label {
                color: #ffc700;    
            }
            .rate:not(:checked) > label:hover,
            .rate:not(:checked) > label:hover ~ label {
                color: #deb217;  
            }
            .rate > input:checked + label:hover,
            .rate > input:checked + label:hover ~ label,
            .rate > input:checked ~ label:hover,
            .rate > input:checked ~ label:hover ~ label,
            .rate > label:hover ~ input:checked ~ label {
                color: #c59b08;
            }
        </style>
    <!--  -->

    <!-- button css -->
    <style>
        .orange button{
            background-color: #ff8a5d;
            color: #fff;
            padding: 12px 20px;
        }

        .orange button:hover{
            background-color: #b06548;
            transform: translate(3px,-2px);
        }

        #orange{
            width: 50%;
            margin-bottom: 30px;
            border: 1px solid #e2e9e1;
            padding: 30px;
        }
    </style>
    <!--  -->

    <!-- css for copt to clipboard toast -->
    <style>
        #copyToClipboard{
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

        #copyToClipboard.show{
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
            z-index:99999;
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

    <!-- end of toast -->



<!--Continuation of profile page of user 09/29/2022-->

<div class="mt-5"></div>


<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
      <div class="container" style="background-color:#fff; color:#b06548;">
        <div class="row">
          <div class="col-sm-3 mt-5 ms-3"><!--left col-->
            <div class="text-center">
                <!-- <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar"> -->
                <img src="admin/assets/img/<?=$client_side_user_image?>" class="avatar img-circle img-thumbnail" alt="avatar" width="150px" height="150px">
                
                <div class="col-sm-10 ms-5 mt-2 d-flex justify-content-center">
                  <h5 style="margin-top:8px;"><?=$session_username?></h5>
                  <ul class="nav nav-pills mb-1" id="pills-tab" role="tablist">
                    <li class="nav-item" >
                      <a class="nav-link" style="color:#b06548;" id="pills-profile-tab" name="profile_button" data-toggle="pill" href="#pills-edit" role="tab" aria-controls="pills-profile" aria-selected="false"><i class="fa-solid fa-pen-to-square"></i></a>
                    </li>
                  </ul>
                </div>
             </div>
          </div><!--/col-3-->
          <div class="col-sm-3 mt-5 ms-3">  
            <div class="tab-content">
              <div class="tab-pane active" id="home">
                            <div class="form-group">
                                <div class="col-xs-6 mt-4">
                                    <label for="name"><h5>Name: <?=$session_full_name?></h5></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6 mt-4">
                                  <label for="email"><h5>Email: <?=$session_email?></h5></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6 mt-4">
                                  <label for="mobile_number"><h5>Mobile#: <?=$session_mobile?></h5></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6 mt-4">
                                    <label for="location"><h5>Address: <?=$session_user_address?></h5></label>
                                </div>
                            </div>
              </div><!--tabpane-->
            </div><!--tab content-->
          </div><!--/col-4-->
            <!-- <div class="col-sm-3 mt-5 ms-3">
                <div class="form-group">
                    <div class="col-xs-6 mt-4">
                        <label for="first_name"><h5>Birthday</h5></label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6 mt-4">
                        <label for="last_name"><h5>Gender</h5></label>
                    </div>
                </div>
            </div> -->
        </div><!--row-->
      </div>
    </div><!--vtabpane-->
    

    <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-edit-tab">
        <!-- edit ko lang par for edit profile function -j -->
        <form class="form" action="process.php" method="post" id="registrationForm" enctype="multipart/form-data">
            <!--Container to edit profile 09/28/2022-->
            <div class="container" style="background-color:#fff; color:#b06548;">
                <div class="row">
                <div class="col-sm-3 mt-5 ms-3"><!--left col-->
                    <div class="text-center">
                        <!-- <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar"> -->
                        <img src="admin/assets/img/<?=$client_side_user_image?>" class="avatar img-circle img-thumbnail" alt="avatar" width="150px" height="150px">
                       
                        <div class="col-sm-10 ms-3 mt-2"><h5><?=$session_username?></h5></div>
                        <div class="col-sm-10 ms-3 mt-2">
                            <input type="file" class="text-center center-block file-upload form-control" id="image" name="image">
                            <input type="hidden" id="get_filename" name="get_filename" value="0">
                            <p id="filename" hidden></p>
                            
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-lg btn-success" id="edit_profile" type="submit" name="edit_profile" disabled><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                    <a style="text-decoration: none; color:white;" href="profile.php" class="btn btn-lg btn-danger"> Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/col-3-->
                <div class="col-sm-4 ms-5 mt-4">   
                    <div class="tab-content">
                    <div class="tab-pane active" id="home">
                            <div class="form-group">
                                <div class="col-xs-6 mt-4">
                                    <label for="first_name"><h5>Name</h5></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name" title="enter your full name." value="<?=$session_full_name?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6 mt-4">
                                    <label for="email"><h5>Email</h5></label>
                                    <input type="email" class="form-control"  id="email" placeholder="Email" title="enter your email." value="<?=$session_email?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6 mt-4">
                                    <label for="mobile_number"><h5>Mobile #</h5></label>
                                    <input type="number" class="form-control" name="mobile_number" id="mobile_number" placeholder="mobile" title="enter your full name." value="<?=$session_mobile?>"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6 mt-4">
                                    <label for="address"><h5>Address</h5></label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" title="enter your address" value="<?=$session_user_address?>">
                                </div>
                            </div>
                    </div><!--tabpane-->
                    </div><!--tab content-->
                </div><!--/col-4-->
                <div class="col mt-4">
                    <!-- <div class="form-group" >
                        <div class="col-xs-6 mt-4">
                            <label for="birthday"><h5>Birthday</h5></label>
                            <input type="date" class="form-control" id="birthday" placeholder="Birthday" title="enter your address">
                        </div>
                    </div> -->
                    <div class="form-group">
                        <!-- <div class="col-xs-6 mt-4" >
                            <label for="gender"><h5>Gender</h5></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="male" value="male">
                            <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="female" value="female">
                            <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="others" value="others">
                            <label class="form-check-label" for="inlineRadio2">Others</label>
                        </div> 
                        <div class="form-group">
                            <div class="col-xs-12">
                                <br>
                                <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                <button  class="btn btn-lg btn-danger" type="button"><i class="glyphicon glyphicon-ok-sign"></i><a style="text-decoration: none; color:white;" href="profile.php">Cancel</a></button>
                            </div>
                        </div> -->
                    </div>
                    </div>
                </div>
                </div><!--row-->
            </div>
        </form><!--form-->
        <!-- end of edit -j -->
    </div>
</div>

    <!-- CART for order status -j-->
    <div class=" m-3">
        <section id="cart" class=" m-3"> <!--section-p1-->

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link "  id="MyPurchase" href="/profile">My Purchase</a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  id="Preparing" href="?Preparing=1">Preparing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  id="OnTheWay" href="?OnTheWay=1">On The Way</a>
            </li>
            <li class="nav-item">
                <a class="nav-link "  id="Delivered" href="?Delivered=1">Delivered</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="Cancelled" href="?Cancelled=1">Cancelled</a>
            </li>
           
        </ul>
        </section>
            <?php 

                if(isset($_GET['Delivered'])==1){
                    $order_list_query = " SELECT * FROM order_tbl WHERE order_status='delivered' AND order_by='$session_username' ORDER BY order_id DESC"; 
                }elseif(isset($_GET['Cancelled'])==1){
                    $order_list_query = " SELECT * FROM order_tbl WHERE order_status='cancelled' AND order_by='$session_username' ORDER BY order_id DESC"; 
                }elseif(isset($_GET['Preparing'])==1){
                    $order_list_query = " SELECT * FROM order_tbl WHERE order_status='preparing' AND order_by='$session_username' ORDER BY order_id DESC"; 
                }elseif(isset($_GET['OnTheWay'])==1){
                    $order_list_query = " SELECT * FROM order_tbl WHERE order_status='delivering' AND order_by='$session_username' ORDER BY order_id DESC"; 
                }
                
                else{
                    $order_list_query = " SELECT * FROM order_tbl WHERE order_status!='on-going' AND order_by='$session_username' ORDER BY order_id DESC"; 
                }
                $order_result_list = $con->query($order_list_query);
                if ($order_result_list->num_rows>0) { //if walang on-going, show
                    $order_count = 1;
                    while ($order_result_list_row = $order_result_list->fetch_assoc()){ 
                        $order_id_display = $order_result_list_row['order_id'];
                        $order_status_display = $order_result_list_row['order_status'];
                        $proof_of_payment_display = $order_result_list_row['proof_of_payment'];

            ?>
            
                <div class="border mt-5" > <!--mx-5 mb-5-->
                    <section id="cart" class="m-3 " ><!--section-p1-->
                        <h3>Order ID: <?= $order_id_display ?></h3>

                            <div class="card2">
                                <div class="tracking">
                                    <div class="title">Tracking Order</div>
                                </div>
                                <div class="progress-track">
                                    <ul id="progressbar">
                                        <input type="hidden"  class="order_id_class" id="order_id<?=$order_id_display?>" value="<?=$order_id_display?>">
                                        <li class="step0 
                                            <?php if($order_status_display=="pending"){ echo "active ";}?> 
                                            <?php if($order_status_display=="preparing"){ echo "active ";}?> 
                                            <?php if($order_status_display=="delivering"){ echo "active ";}?> 
                                            <?php if($order_status_display=="delivered"){ echo "active ";}?> 
                                        " id="step1">Received</li>
                                        <li class="step0 text-center
                                            <?php if($order_status_display=="preparing"){ echo "active ";}?> 
                                            <?php if($order_status_display=="delivering"){ echo "active ";}?> 
                                            <?php if($order_status_display=="delivered"){ echo "active ";}?>
                                        " id="step2">Preparing</li>
                                        <li class="step0 text-center
                                            <?php if($order_status_display=="delivering"){ echo "active ";}?> 
                                            <?php if($order_status_display=="delivered"){ echo "active ";}?>
                                        " id="step3" ><span class="float-end">On the way</span></li>
                                        <li class="step0 text-center
                                            <?php if($order_status_display=="delivered"){ echo "active ";}?>
                                        " id="step4" ><span class="float-end"  >Delivered</span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="table-responsive " style="padding:0px 0 0 0;border:none;">
                                <table width="100%" class=' table table-hover'>
                                    <thead>
                                        <tr>
                                            <td  id="td_rate_header<?=$order_id_display?>" hidden>Rate</td>
                                            <td>Image</td>
                                            <td>Product</td>
                                            <td>ADD ONS</td>
                                            <td>Price</td>
                                            <td>Quantity</td>
                                            <td>Subtotal</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- show order -jcabrieto -->

                                        <?php 
                                            $order_list = " SELECT * 
                                                            FROM order_tbl
                                                            LEFT JOIN availed_product_tbl
                                                            ON order_tbl.order_id = availed_product_tbl.order_id
                                                            WHERE order_status != 'on-going' 
                                                            AND order_by='$session_username' 
                                                            AND availed_product_tbl.order_id=$order_id_display "; 
                                            $result_list = $con->query($order_list);
                                            if ($result_list->num_rows>0) {
                                                $sub_total = 0;
                                                while ($row = $result_list->fetch_assoc()){ 
                                                    if($row['availed_id']!=""){

                                                        $order_id=$row['order_id'];
                                                        $order_by=$row['order_by'];
                                                        $order_amount=$row['order_amount'];
                                                        $order_payment=$row['order_payment'];
                                                        $order_change=$row['order_change'];
                                                        $order_status=$row['order_status'];
                                                        $order_discount=$row['order_discount'];
                                                        $delivery_address=$row['delivery_address'];
                                                        $payment_method=$row['payment_method'];
                                                        $availed_id = $row['availed_id'];
                                                        $availed_product = $row['availed_product'];
                                                        $availed_price = $row['availed_price'];
                                                        $availed_quantity = $row['availed_quantity'];
                                                        $availed_amount = $row['availed_amount'];

                                                        // subtotal
                                                            $sub_total+=$availed_amount; 
                                                        // 

                                                        $get_product_image_query = "SELECT * FROM products_tbl WHERE product='$availed_product' LIMIT 1 ";
                                                        $product_image_result = mysqli_query($db, $get_product_image_query);
                                                        $product_image = mysqli_fetch_assoc($product_image_result);
                                                        $get_product_id = $product_image['product_id'];
                                                        $get_product = $product_image['product'];
                                                        $get_product_image = $product_image['product_image'];
                                                        ?>
                                                        <tr id="table_row<?=$availed_id?>">
                                                        <!-- style="background:rgb(212,145,87);border:0;color:white;" -->
                                                            <td class="td_rate td_rate<?=$order_id?>" id="td_rate_product_id<?=$get_product_id?>" hidden>
                                                                <div id="subtotal" style="border:0;">
                                                                    <!-- <a href="#updateproduct" class="btn btn-primary btn-sm update_product text-left w-100" data-toggle="modal" data-target="#update-modal"><i class="far fa-edit"></i> Update</a></a> -->

                                                                    <button class="normal rate_product j-orangev2" id="rate_product<?=$get_product_id?>"  data-toggle="modal" data-target="#rate-modal">Rate</button> 
                                                                </div> 
                                                            </td>
                                                            <td>
                                                            <?php   if(file_exists("admin/assets/img/$get_product_image")){ ?>
                                                                        <a href="admin/assets/img/<?=$get_product_image?>" target="newTab"><img src="admin/assets/img/<?=$get_product_image?>" alt="" style="width:100px;height:100px;"></a>
                                                            <?php   }else{  ?>
                                                                        <a href="admin/assets/img/default.png" target="newTab"><img src="admin/assets/img/default.png" alt="" style="width:100px;height:100px;"></a>
                                                            <?php   }//end else     ?>
                                                            </td>
                                                            <td id="availed_product<?=$availed_id?>" class="availed_product<?=$availed_id?>"><?= $availed_product ?></td>
                                                            <td id="add_ons">
                                                                <?php 

                                                                $add_ons_total = 0;
                                                                $add_ons_list = "   
                                                                                    SELECT * 
                                                                                    FROM add_ons_tbl
                                                                                    WHERE order_id = $order_id
                                                                                    AND product='$availed_product' 
                                                                                    AND availed_id='$availed_id' 
                                                                                "; 
                                                                $add_ons_result_list = $con->query($add_ons_list);
                                                                if ($add_ons_result_list->num_rows>0) {
                                                                    while ($add_ons_row = $add_ons_result_list->fetch_assoc()){ 
                                                                ?>
                                                                    <?=$add_ons_row['add_ons']."<br>"?>
                                                                <?php 
                                                                        //get addons total
                                                                        $add_ons_total += $add_ons_row['add_ons_price'];
                                                                        $add_ons_price_1 = $add_ons_row['add_ons_price'] / $availed_quantity;
                                                                    }
                                                                }
                                                                $add_ons_display = '';
                                                                if($add_ons_total>0){
                                                                    $add_ons_display = "<br> + ₱$add_ons_price_1 add ons";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td id="availed_price<?=$availed_id?>">₱<?=$availed_price.$add_ons_display?></td>
                                                            <td ><?= $availed_quantity ?></td>
                                                            <td>₱<span id="availed_amount<?=$availed_id?>"><?= number_format($availed_amount+$add_ons_total, 2, ".", ",") ?></span></td>
                                                        </tr>
                                        <?php   
                                                    }//end if
                                                }//end while
                                            } //end if
                                    ?>
                                    </tbody>

                                </table>
                            </div>

                    </section>

                    <section id="cart-add" class=" "> <!--section-p1-->
                        <div id="subtotal" class="table-responsive" style="margin:0;padding:10px 10px;border:none;width:100%;max-width:500px;">

                            <?php 
                                // if($order_status == "pending"){
                                //     $order_status =  $order_status;
                                // }else if($order_status=="preparing"){
                                //     $order_status =  $order_status;
                                // }
                                // else{
                                //     $order_status;
                                // }
                            ?>
                            <h3 id="display_order_status<?=$order_id?>">Order Status: <?= strtoupper($order_status) ?></h3>
                            <table>
                                
                                
                                <?php 
                                    if($payment_method=="Gcash"){
                                        if($proof_of_payment_display==""){
                                            echo "
                                                <tr>
                                                    <td>Proof of Payment Here:<a href='#QR_CODE'  class='QR_CODE' data-trigger='focus' data-bs-placement='top' data-bs-content='Click This QR Code.' data-toggle='modal' data-target='#qr-modal' style=' text-decoration: none;' title='Pay Here.' >[ <i class='fa-solid fa-qrcode'></i> ]</a> </td>
                                                    <form action='process.php' method='POST' enctype='multipart/form-data'>
                                                            <td>
                                                                <input type='hidden' class='' style='width:90px;' name='order_id' value='$order_id_display'>
                                                                <input type='file' class='' style='width:100%;' name='image' accept='image/gif, image/jpeg, image/png' required>
                                                                <button type='submit' name='upload_proof_of_payment' class='normal mt-1' style='padding:10px;'>UPLOAD PAYMENT</button>
                                                            </td>
                                                    </form>
                                                </tr>
                                            ";
                                        }else{
                                            if($order_result_list_row['payment_status']=='pending'){
                                                echo "
                                                    <tr>
                                                        <td><i class='fa-solid fa-circle-info' title='Pending payment status.'></i> Proof of Payment</td>
                                                        <td>
                                                            <a href='admin/assets/img/{$proof_of_payment_display}' target='newTab'><img src='admin/assets/img/{$proof_of_payment_display}' width='50px'></a>
                                                            <form action='process.php' method='POST' enctype='multipart/form-data'>
                                                                <input type='hidden' class='' style='width:90px;' name='order_id' value='$order_id_display'>
                                                                <input type='file' class='' style='width:100%; margin:5px 0;' name='image' accept='image/gif, image/jpeg, image/png' required>
                                                                <button type='submit' name='upload_proof_of_payment' class='normal' style='padding:10px;margin-left:10px;'>UPDATE</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                ";
                                            }else if($order_result_list_row['payment_status']=='approved'){
                                                echo "
                                                <tr>
                                                    <td><i class='fa-solid fa-circle-check text-success' title='Payment Approved.'></i> Proof of Payment</td>
                                                    <td>
                                                        <a href='admin/assets/img/{$proof_of_payment_display}' target='newTab'><img src='admin/assets/img/{$proof_of_payment_display}' width='50px'></a>
                                                    </td>
                                                </tr>
                                            ";
                                            }else if($order_result_list_row['payment_status']=='refunded'){
                                                echo "
                                                <tr>
                                                    <td><i class='fa-solid fa-info bg-secondary rounded text-white p-2' title='Payment refunded.'></i> Proof of Payment: refunded</td>
                                                    <td>
                                                        <a href='admin/assets/img/{$proof_of_payment_display}' target='newTab'><img src='admin/assets/img/{$proof_of_payment_display}' width='50px'></a>
                                                    </td>
                                                </tr>
                                            ";
                                            }
                                            
                                        }
                                        // echo $order_result_list_row['payment_status'];
                                    }
                                ?>
                                <tr>
                                    <td>Payment Method</td>
                                    <td><?= $payment_method?></Strong></td>
                                </tr>

                                <?php if($payment_method=='Gcash' || $payment_method=='Cash-on-Delivery'):?>
                                    <tr>
                                        <td>Sub total</td>
                                        <td>₱<?= number_format($order_amount - $delivery_fee, 2, ".", ",")?></Strong></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Fee</td>
                                        <td>₱<?= $delivery_fee ?></Strong></td>
                                    </tr>
                                <?php else:?>
                                    <tr>
                                        <td>Sub total</td>
                                        <td>₱<?= number_format($availed_amount+$add_ons_total, 2, ".", ",")?></Strong></td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>₱<?= number_format($order_discount, 2, ".", ",")?></Strong></td>
                                    </tr>
                                    <tr>
                                        <td>To Pay</td>
                                        <td>₱<?= number_format($order_amount, 2, ".", ",")?></Strong></td>
                                    </tr>
                                    <tr>
                                        <td>Payment</td>
                                        <td>₱<?= number_format($order_payment, 2, ".", ",")?></Strong></td>
                                    </tr>
                                    <tr>
                                        <td>Change</td>
                                        <td>₱<?= number_format($order_change, 2, ".", ",")?></Strong></td>
                                    </tr>
                                <?php endif;?>
                                
                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td><Strong class="order_amount">₱<?= number_format($order_amount, 2, ".", ",")?></Strong></td>
                                </tr>

                                <tr>
                                    <td>Notes</td>
                                    <td><?= $order_result_list_row['order_message']?></Strong></td>
                                </tr>

                                <tr>
                                    <td>Delivery Address</td>
                                    <td><?= $delivery_address?></Strong></td>
                                </tr>
                            </table>
                            
                            <div id="order_delivered<?=$order_id?>" hidden>
                                <nobr>
                                    <button class="normal order_received m-1" id="order_received<?=$order_id?>" >Receive Order</button>
                                    <!-- <button class="normal rate_product m-1" id="rate_product<?php //echo $order_id?>" >Rate Product</button> -->
                                </nobr>
                            </div>

                            <div id="order<?=$order_id?>" hidden>
                                <nobr>
                                    <button class="normal cancel_order m-1" data-id="<?=$order_id?>" id="cancel_order<?=$order_id?>" >Cancel Order</button>
                                </nobr>
                            </div>
                            
                        </div>
                    </section>
                </div>          
        <?php   
                    }//end while
                }//end if 
                else{
                    echo '<section id="cart" class="section-p1 ">No Purchase History.</section>';
                }
        ?>

    </div> 
    <!-- end of show orders -->

    <!-- Rate modal -->
    <div class="modal fade" id="rate-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Rate Product</h4>
                <!-- <button type="button" >
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <a href="#" class="" data-dismiss="modal" aria-label="Close"><i class="far fa-window-close"></i></a>
                </div>

                <form action="process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="card " >
                            <div class="card-body">
                                <div class="form-group mb-2">
                                    <input type="hidden" class="form-control" id="rate_product_id"  name="rate_product_id" >
                                    <input type="hidden" class="form-control" id="rate_order_id"  name="rate_order_id" >

                                    <input type="text" class="form-control" id="product"  name="product" disabled>
                                </div>

                                <div class="form-group mb-2">
                                    <!-- <label for="exampleInputFile">Upload Image</label><br> -->
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file"  id="image" accept="image/gif, image/jpeg, image/png" name="image" > 
                                            <input type="hidden" id="get_filename" name="get_filename" value="0">
                                            <p id="filename" hidden></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-2">
                                    <textarea class="form-control" name="comment"  cols="30" rows="5" placeholder="Share more thoughts on the product to help the other buyers."></textarea>
                                </div>

                                <!-- <span class="fa fa-star stars text-secondary " id="star1"></span>
                                <span class="fa fa-star stars text-secondary " id="star2"></span>
                                <span class="fa fa-star stars text-secondary " id="star3"></span>
                                <span class="fa fa-star stars text-secondary " id="star4"></span>
                                <span class="fa fa-star stars text-secondary " id="star5"></span> -->
                                <label for="" class="float-start">Product Rating</label>
                                
                                <div class="rate">
                                    <input type="radio" id="star5" name="rate" value="5" />
                                    <label for="star5" title="text">5 stars</label>
                                    <input type="radio" id="star4" name="rate" value="4" />
                                    <label for="star4" title="text">4 stars</label>
                                    <input type="radio" id="star3" name="rate" value="3" />
                                    <label for="star3" title="text">3 stars</label>
                                    <input type="radio" id="star2" name="rate" value="2" />
                                    <label for="star2" title="text">2 stars</label>
                                    <input type="radio" id="star1" name="rate" value="1" />
                                    <label for="star1" title="text">1 star</label>
                                </div>

                                <input type="hidden" name="ratings">
                                

                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <!-- justify-content-between -->
                        <div class="orange" style="border:0;">
                            <button type="button" class="normal " data-dismiss="modal">Cancel</button>
                        </div>
                        <div class="orange" style="border:0;">
                            <button type="submit" class="normal " name="rate_product">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- QR modal -->
    
    <div class="modal fade" id="qr-modal" style='z-index:9999999;'>
        <div id="copyToClipboard">Copied To Clipboard</div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">QR CODE</h4>
                <!-- <button type="button" >
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <a href="#" class="text-dark" style='text-decoration:none;' data-dismiss="modal" aria-label="Close">x</a>
                </div>
                <div class="modal-body">
                    <img src="admin/assets/img/gcash-binyang.png" alt="" class='w-100 mt-2'>
                </div>
                <div class="modal-footer ">
                    <!-- justify-content-between -->
                    <div class="orange" style="border:0;">
                        <button type="button" class="normal " data-dismiss="modal">Close</button>
                        

                        <p id="gcash_number" hidden>09268771097</p>
                        <button class="normal " onclick="copyToClipboard('#gcash_number')"><i class="fa-solid fa-clipboard"></i> Copy to Clipboard</button>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->





<script>
const btn = document.getElementById('pills-profile-tab');

btn.addEventListener('click', () => {
  // 👇️ hide button
  btn.style.display = 'none';


});
</script>
</body>
<?php include('footer.php');?>

<!-- jcabz script -->

<!-- copy to clipboard script -->
<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();

        //toast here
        var x = document.getElementById("copyToClipboard");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

    }
</script>

<script>
    // script to get the current pending orders
    function getdata(){
        $.ajax({
            type: 'post',
            url: 'get_real_time_data.php',
            success: function (response) {
                var obj = JSON.parse(response);

                $('.order_id_class').each(function(index){
                
                    // console.log($(this).val());
                    // console.log(response);
                    // console.log(obj);
                    // console.log(obj.data);
                    obj.data.forEach(element => {
                        // console.log(element[0]); //order_id
                        // console.log(element[1]); //order_status
                    

                        if(element[1]=="pending"){
                            $("#order_id"+element[0]).next().addClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().removeClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().removeClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().next().removeClass("active "); //preparing
                        }
                        
                        if(element[1]=="preparing"){
                            $("#order_id"+element[0]).next().next().addClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().addClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().removeClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().next().removeClass("active "); //preparing
                        }

                        if(element[1]=="delivering"){
                            $("#order_id"+element[0]).next().next().addClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().addClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().addClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().next().removeClass("active "); //preparing
                        }

                        if(element[1]=="delivered"){
                            $("#order_id"+element[0]).next().next().addClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().addClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().addClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().next().addClass("active "); //preparing
                            // alert('order successfully failed');

                            $('#order_delivered'+element[0]).attr('hidden',false);

                            // $('#td_rate_header'+element[0]).attr('hidden',false);
                            // $('.td_rate'+element[0]).attr('hidden',false);
                        }else{
                            $('#order_delivered'+element[0]).attr('hidden',true);

                            // $('#td_rate_header'+element[0]).attr('hidden',true);
                            // $('.td_rate'+element[0]).attr('hidden',true);

                        }

                        

                        if(element[1]=="cancelled" || element[1]=="on-going"){
                            $("#order_id"+element[0]).next().removeClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().removeClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().removeClass("active "); //preparing
                            $("#order_id"+element[0]).next().next().next().next().removeClass("active "); //preparing
                        }


                        $("#display_order_status"+element[0]).text("Order Status: "+element[1].toUpperCase()); //preparing

                        
                    });

                    // console.log(obj.received_data);
                    obj.received_data.forEach(element => {

                        // console.log(element[0]);
                        // console.log(element[1]);
                        if(element[1]=="received"){
                            $('#order_delivered'+element[0]).attr('hidden',true);

                            $('#td_rate_header'+element[0]).attr('hidden',false);
                            $('.td_rate'+element[0]).attr('hidden',false);
                            
                        }else{
                            // console.log('show button'+element[0]);
                            // $('#order_delivered'+element[0]).attr('hidden',false);

                            $('#td_rate_header'+element[0]).attr('hidden',true);
                            $('.td_rate'+element[0]).attr('hidden',true);

                        }
                    });


                    obj.data.forEach(element => {
                        // console.log(element[1]);
                        if(element[1]=="pending"){
                            $('#order'+element[0]).attr('hidden',false);
                        }else{
                            $('#order'+element[0]).attr('hidden',true);
                        }
                    });

                });
                
            }
        });
    }
    setInterval(function () {getdata()}, 1000);

    $('#image').on('change',function(){
        // output raw value of file input
        $('#filename').html($(this).val().replace(/.*(\/|\\)/, '')); 

        // or, manipulate it further with regex etc.
        var filename = $(this).val().replace(/.*(\/|\\)/, '');
        // .. do your magic
        console.log(filename);
        $('#filename').html(filename);
        $('#get_filename').val(filename);
    });

    $('#registrationForm').on('keyup',function(){
       console.log('registrationForm');
        $('#edit_profile').attr('disabled',false);
    });

    $('#registrationForm').on('change',function(){
       console.log('registrationForm: change');
        $('#edit_profile').attr('disabled',false);
    });

    $('.td_rate').on('click',function(e){
        e.preventDefault();
        var id = $(this).attr('id'); //product_id
        var get_id_number = id.match(/\d+/g);
        $('#rate_product_id').val(get_id_number);
        
        var class_id = $(this).attr('class').split(' ').pop();  //get last classname
        var order_id_number = class_id.match(/\d+/g);
        $('#rate_order_id').val(order_id_number);
        // console.log(class_id_number);
        // console.log(get_id_number);
        // console.log($('.availed_product'+get_id_number).text());
        var product = $(this).next().next().text();
        console.log(product);

        $('#product').val(product);
    });

    // $('#star1').on('click',function(e){
    //     e.preventDefault();
    //     console.log('star');
    //     $('#star1').addClass('checked');
    //     $('#star1').removeClass('stars');

    // });

    // $( ".stars" ).mouseenter(function() {
    //     var id = $(this).attr('id'); //star_id
    //     var get_id_number = id.match(/\d+/g);
    //     // console.log(id);
    //     for (let index = 1; index <= get_id_number; index++) {
    //         // console.log(index);  
    //         $('#star'+index).addClass('checked');
    //         $('#star'+index).removeClass('text-secondary');
            
    //     }

    //     // $('.star1, .star2, .star3, .star4, .star5').addClass('checked');
    // });

    // $( ".stars" ).mouseleave(function() {
    //     var id = $(this).attr('id'); //star_id
    //     var get_id_number = id.match(/\d+/g);
    //     // console.log(id);
    //     for (let index = 1; index <= get_id_number; index++) {
    //         console.log(index);  
    //         $('#star'+index).removeClass('checked');
    //         $('#star'+index).addClass('text-secondary');
    //     }
    // });

   
    $('input[name=rate]').on('click',function(e){
        // console.log( $(this).val());
        $('input[name=ratings]').val($(this).val());
    });

    $('.order_received').on('click',function(e){
        console.log("order_received");
        console.log($(this).attr('id'));
        var id = $(this).attr('id');
        var get_order_id_number = id.replace(/[^\d.-]/g, '');
        console.log(get_order_id_number);
        swal({
            title: "Receive order.",
            // text: "Once deleted, you will not be able to recover this product!",
            icon: "info",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                //insert order_status_tbl

                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: {
                        'receiving_order_status' : 'received',
                        'id' : get_order_id_number,
                    },
                    success: function (response) {
                        console.log(response);
                    }
                });
            }
        });
    });

    
    $('.cancel_order').on('click',function(e){
        console.log($(this).data('id'));
        swal({
            title: "Cancel order.",
            // text: "Once deleted, you will not be able to recover this product!",
            icon: "info",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'post',
                    url: 'process.php',
                    data: {
                        'cancel_order_status' : 'cancelled',
                        'id' : $(this).data('id'),
                    },
                    success: function (response) {
                        // console.log(response);
                        var obj = JSON.parse(response);
                        if(obj.system_message=="Cancel order successful."){
                            swal({
                                // title: "Cancel order.",
                                text: obj.system_message,
                                icon: "success",
                                buttons: true,
                                dangerMode: true,
                            })
                        }
                    }
                });
            }
        });
    });

   
    
    
</script>


<script>
    $(document).ready(function(){
        $('.QR_CODE').popover('show');
        $('.popover-header').addClass('bg-info text-white');
        // $('.popover-body').addClass('bg-info text-white');
        $('.popover-body').html("Click This QR Code <a href='#QR_CODE' style='text-decoration:none;'>[ <i class='fa-solid fa-qrcode text-primary QR_CODE hide-qr-popover' data-toggle='modal' data-target='#qr-modal'  ></i> ]</a>.");
        
        $('.fa-qrcode').on('click',function(e){
            $('.QR_CODE').popover('hide');

            // $('.popover-header').addClass('bg-info text-white');
            // $('.popover-body').html("Click This QR Code <a href='#' style='text-decoration:none;'>[ <i class='fa-solid fa-qrcode text-primary QR_CODE hide-qr-popover' data-toggle='modal' data-target='#qr-modal'  ></i> ]</a>.");
        });

        var order_status_Delivered = "<?php echo $_GET['Delivered']; ?>";
        var order_status_OnTheWay = "<?php echo $_GET['OnTheWay']; ?>";
        var order_status_Preparing = "<?php echo $_GET['Preparing']; ?>";
        var order_status_Cancelled = "<?php echo $_GET['Cancelled']; ?>";

        if(order_status_Delivered=="1"){
            $('#Delivered').addClass('active');
        }

        else if(order_status_OnTheWay=="1"){
            $('#OnTheWay').addClass('active');
        }

        else if(order_status_Preparing=="1"){
            $('#Preparing').addClass('active');
        }

        else if(order_status_Cancelled=="1"){
            $('#Cancelled').addClass('active');
        }

        else{
            $('#MyPurchase').addClass('active');
        }


    });
</script>

