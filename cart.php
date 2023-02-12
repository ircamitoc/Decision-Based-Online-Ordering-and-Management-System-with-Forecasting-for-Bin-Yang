<?php 
    include('header.php');

    if(!isset($_SESSION['username'])){
        echo '<script> 
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
        .wrapper{
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FFF;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }
        .wrapper span{
            width: 100%;
            /* text-align: center; */
            cursor: pointer;
            user-select: none;
            transition: 250ms ease-in-out;
        }
        .wrapper span:hover{
            font-size:30px;
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

    <!-- add to cart -->
    <style>
        #added_to_cart{
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

        #added_to_cart.show{
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


     <!-- page HEADER -->
     <section id="page-header" class="cart-header mt-5">
        <h2>CART</h2>
        <p>Every product delivered to you.</p>
    </section>

    <!-- CART -->
    <section id="cart" class="m-3 "><!--section-p1-->
        <div class="table-responsive pb-5" style="padding:0px 0 0 0;border:none; ">
            <table width="100%" class=' table table-hover' >
                <thead>
                    <tr>
                        <td><a href="#Remove_all_product_to_cart" class="Remove_all_products text-danger"><i class="fa-regular fa-circle-xmark" ></i></a> Remove</td>
                        <td>Image</td>
                        <td>Product</td>
                        <td>Add ons</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Subtotal</td>
                    </tr>
                </thead>

                <tbody >
                    <!-- show order -jcabrieto -->

                    <?php 
                        $order_list = " SELECT * 
                                        FROM order_tbl
                                        LEFT JOIN availed_product_tbl
                                        ON order_tbl.order_id = availed_product_tbl.order_id
                                        -- RIGHT JOIN products_tbl
                                        -- ON  availed_product_tbl.availed_product = products_tbl.product
                                        WHERE order_status = 'on-going' 
                                        AND order_by='$session_username' "; 
                        $result_list = $con->query($order_list);
                        if ($result_list->num_rows>0) {
                            while ($row = $result_list->fetch_assoc()){ 
                                if($row['availed_id']!=""){

                                    $order_id=$row['order_id'];
                                    $order_by=$row['order_by'];
                                    $order_amount=$row['order_amount'];
                                    $order_status=$row['order_status'];
                                    $availed_id = $row['availed_id'];
                                    $availed_product = $row['availed_product'];
                                    $availed_price = $row['availed_price'];
                                    $availed_quantity = $row['availed_quantity'];
                                    $availed_amount = $row['availed_amount'];
                                    
                                    $get_product_image_query = "SELECT * FROM products_tbl WHERE product='$availed_product' LIMIT 1 ";
                                    $product_image_result = mysqli_query($db, $get_product_image_query);
                                    $product_image = mysqli_fetch_assoc($product_image_result);
                                    $get_product_id = $product_image['product_id'];
                                    $get_product = $product_image['product'];
                                    $get_product_quantity = $product_image['product_quantity'];
                                    $get_product_image = $product_image['product_image'];
                                    ?>
                                    <tr id="table_row<?=$availed_id?>" >
                                        <td><a href="#Remove_product" id="availed_id<?=$availed_id?>" class="Remove_product"><i class="fa-regular fa-circle-xmark"></i></a></td>
                                        <td>
                                        <?php   if(file_exists("admin/assets/img/$get_product_image")){ ?>
                                                    <a href="admin/assets/img/<?=$get_product_image?>" target="newTab"><img src="admin/assets/img/<?=$get_product_image?>" alt="" ></a>
                                        <?php   }else{  ?>
                                                    <a href="admin/assets/img/default.png" target="newTab"><img src="admin/assets/img/default.png" alt=""></a>
                                        <?php   }//end else     ?>
                                        </td>
                                        <td id="availed_product<?=$availed_id?>"><?= $availed_product ?></td>

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
                                                $add_ons_price_1 = 0;
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
                                                // $add_ons_display = "<br> + ₱$add_ons_total add ons";
                                                $add_ons_display = "<br> + ₱$add_ons_price_1 add ons";
                                            }
                                            
                                            ?>
                                        </td>

                                        <td id="availed_price<?=$availed_id?>">₱<?=$availed_price.$add_ons_display?> </td>
                                        <td >
                                            <?=$availed_quantity?>
                                        </td>
                                        <td>₱<span id="availed_amount<?=$availed_id?>"><?= number_format($availed_amount+$add_ons_total, 2, ".", ",") ?></span></td>
                                        <td hidden>
                                            <div class="wrapper" >
                                            <!-- <span class="num">01</span>  -->
                                                <input type="hidden" value="<?=$get_product_id?>" id="availed_product_id<?=$availed_id?>">
                                                <input type="hidden" value="<?=$get_product?>" id="availed_product_name<?=$availed_id?>">
                                                <span class="minus text-danger" id="decrease_quantity" onclick="decreaseValue('availed_quantity<?=$availed_id?>')">-</span>
                                                <input type="number" max="<?=$get_product_quantity?>" value="<?=$availed_quantity?>" id="availed_quantity<?=$availed_id?>" class="form-control num availed_quantity_class" style="width:60px;text-align:center;padding:0;height:50px" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                <span class="plus text-success" id="increase_quantity" onclick="increaseValue('availed_quantity<?=$availed_id?>')">+</span>
                                            </div>
                                        </td>
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


    <!-- coffee add-ons modal -->
    <div class="modal fade" id="coffee-add-ons-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">COFFEE - ADD ONS</h4>
                <!-- <button type="button" >
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <a href="#cart-add" class=" btn btn-close" style='text-decoration:none;' data-dismiss="modal" aria-label="Close"></a>
                </div>

                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="ExtraShot" id="ExtraShot">
                        <label class="form-check-label" for="ExtraShot">
                            ₱20 Extra Shot 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="Vanilla" id="Vanilla" >
                        <label class="form-check-label " for="Vanilla">
                            ₱20 Vanilla 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="Hazelnut" id="Hazelnut" >
                        <label class="form-check-label " for="Hazelnut">
                            ₱20 Hazelnut 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="Caramel" id="Caramel" >
                        <label class="form-check-label" for="Caramel">
                            ₱20 Caramel 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input add_ons " type="checkbox" value="ColdFoam" id="ColdFoam" >
                        <label class="form-check-label" for="ColdFoam">
                            ₱20 Cold Foam 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input no_add_ons" type="checkbox" value="no_add_ons" id="no_add_ons" checked >
                        <label class="form-check-label" for="no_add_ons">
                            No add ons 
                        </label>
                    </div>
                </div>
                <div class="modal-footer ">
                    <!-- justify-content-between -->
                    <div class="j-orange pro" style="border:0;">
                        <div id="subtotal" class="d-flex justify-content-start close-coffee-modal" style="border:0;margin:0;padding:0;">
                            <button type="button" class="normal mx-1 " data-dismiss="modal" style="">Cancel</button>
                            <input type="hidden" value="" id="product_id_modal" class="product_id_modal">
                            <input type="hidden" value="" id="product_modal" class="product_modal">
                            <input type="hidden" value="" id="product_price_modal">
                            <!-- <a href="#coffee_add_ons_modal" id="add_to_cart" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-cart-shopping cart"></i> Add to Cart</a> -->
                            <button class="normal " id="add_to_cart" data-dismiss="modal">Add&nbsp;to&nbsp;Cart</button> 
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- MILK TEA add-ons modal -->
    <div class="modal fade" id="milktea-add-ons-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">MILK TEA - ADD ONS</h4>
                <!-- <button type="button" >
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <a href="#" class=" btn btn-close" style='text-decoration:none;' data-dismiss="modal" aria-label="Close"></a>
                </div>

                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="Cheesecake" id="Cheesecake">
                        <label class="form-check-label" for="Cheesecake">
                            ₱20 Cheesecake 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="Pearl" id="Pearl" >
                        <label class="form-check-label " for="Pearl">
                            ₱15 Pearl 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="Crystal" id="Crystal" >
                        <label class="form-check-label " for="Crystal">
                            ₱15 Crystal 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="Oreo" id="Oreo" >
                        <label class="form-check-label" for="Oreo">
                            ₱15 Oreo 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="PoppingBoba" id="PoppingBoba" >
                        <label class="form-check-label" for="PoppingBoba">
                            ₱15 Popping Boba 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input no_add_ons" type="checkbox" value="no_add_ons" id="no_add_ons2" checked>
                        <label class="form-check-label" for="no_add_ons2">
                            No add ons 
                        </label>
                    </div>
                </div>
                <div class="modal-footer ">
                    <!-- justify-content-between -->
                    <div class="j-orange pro" style="border:0;">
                        <div id="subtotal" class="d-flex justify-content-start" style="border:0;margin:0;padding:0;">
                            <button type="button" class="normal mx-1" data-dismiss="modal" >Cancel</button>
                            <input type="hidden" value="" id="product_id_modal" class="product_id_modal">
                            <input type="hidden" value="" id="product_modal" class="product_modal">
                            <input type="hidden" value="" id="product_price_modal">
                            <!-- <a href="#coffee_add_ons_modal" id="add_to_cart" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-cart-shopping cart"></i> Add to Cart</a> -->
                            <button class="normal " id="add_to_cart" data-dismiss="modal">Add&nbsp;to&nbsp;Cart</button> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!-- fruit tea add-ons modal -->
    <div class="modal fade" id="fruit-tea-add-ons-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">FRUIT TEA - ADD ONS</h4>
                <!-- <button type="button" >
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <a href="#" class=" btn btn-close" style='text-decoration:none;' data-dismiss="modal" aria-label="Close"></a>
                </div>

                <div class="modal-body">
                    
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="FruitJelly" id="FruitJelly" >
                        <label class="form-check-label" for="FruitJelly">
                            ₱15 Fruit Jelly 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input add_ons" type="checkbox" value="PoppingBoba" id="PoppingBoba2" >
                        <label class="form-check-label" for="PoppingBoba2">
                            ₱15 Popping Boba 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input no_add_ons" type="checkbox" value="no_add_ons" id="no_add_ons3" checked >
                        <label class="form-check-label" for="no_add_ons3">
                            No add ons 
                        </label>
                    </div>
                </div>
                <div class="modal-footer ">
                    <!-- justify-content-between -->
                    <div class="j-orange pro" style="border:0;">
                        <div id="subtotal" class="d-flex justify-content-start close-fruittea-modal" style="border:0;margin:0;padding:0;">
                            <button type="button" class="normal mx-1 " data-dismiss="modal" >Cancel</button>
                            <input type="hidden" value="" id="product_id_modal" class="product_id_modal">
                            <input type="hidden" value="" id="product_modal" class="product_modal">
                            <input type="hidden" value="" id="product_price_modal">
                            <!-- <a href="#coffee_add_ons_modal" id="add_to_cart" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-cart-shopping cart"></i> Add to Cart</a> -->
                            <button class="normal " id="add_to_cart" data-dismiss="modal">Add&nbsp;to&nbsp;Cart</button> 
                        </div>
                    </div>                   

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    


    <!-- end of show order -jcabrieto -->
              

    <!-- COUPON SECTION -->
    <section id="cart-add" class=""><!--section-p1 row-->
        <div id="subtotal" class="table-responsive" style="margin:10px;padding:10px 10px;width:100%;max-width:1000px;">
            <!-- <div id="coupon" >
                <h3>Apply Coupon</h3>
                <div>
                    <input type="text" placeholder="Enter Your Coupon">
                    <button class="normal">Apply</button>
                </div>
            </div> -->
            <h3>Cart Totals</h3>
            <table>
                <tr>
                    <td>Cart Subtotal</td>
                    <td class="order_amount">₱
                        <?php
                        if($order_amount - $delivery_fee<0){
                            $order_amount_subtotal=0;
                        }else{
                            $order_amount_subtotal = $order_amount - $delivery_fee;
                        }
                            echo number_format($order_amount_subtotal, 2, ".", ",")
                        ?>
                    </td>
                </tr>
                <tr>
                    
                    <td>Delivery Fee</td>
                    <td>₱<?=$delivery_fee?></td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><Strong class="order_amount_total">₱<?= number_format($order_amount, 2, ".", ",")?></Strong></td>
                </tr>
            </table>
            <?php 
                if($availed_id!=''):?>
                                <button class="normal" onclick="window.location.href='checkout.php';">Proceed to checkout </button>

            <?php endif;?>
        </div>
    </section>

    <section id="product1" class="section-p1  " >
        <div id="added_to_cart">Added to Cart</div>

        <h2>Best Sellers</h2>
        <div class="pro-container d-flex justify-content-evenly"  >
            <?php 
                $product_list = "
                    SELECT *,SUM(availed_quantity) as total_sales 
                    FROM `products_tbl`
                    LEFT JOIN availed_product_tbl
                    ON products_tbl.product = availed_product_tbl.availed_product
                    LEFT JOIN  order_tbl
                    ON availed_product_tbl.order_id = order_tbl.order_id
                    WHERE order_tbl.order_status='delivered'
                    AND order_payment>0
                    GROUP BY product
                    ORDER BY total_sales DESC
                    LIMIT 3
                " ; 
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 
                        $category = $row['category'];
            ?>
                        <div class="pro">
                            <img src="admin/assets/img/<?=$row['product_image']?>" alt="" style="width:100%;height:200px;">
                            <div class="des">
                                <span><?= $row['product'] ?> </span>
                                <?php
                                    $get_product_name_for_ratings = substr($row['product'], 0, -4);
                                    $get_product_average_ratings_query = "
                                        SELECT AVG(ratings) as average_ratings
                                        FROM products_tbl
                                        LEFT JOIN rates_tbl
                                        ON products_tbl.product_id = rates_tbl.product_id
                                        WHERE category = '$category' 
                                        AND product LIKE '%$get_product_name_for_ratings%' ";
                                    $result_list_for_average_ratings = $con->query($get_product_average_ratings_query);
                                    $average_ratings_row = $result_list_for_average_ratings->fetch_assoc();
                                    $average_ratings_for_this_product = $average_ratings_row['average_ratings'];
                                ?> 
        
                                <div class="star">
                                    <?php
                                        if($average_ratings_for_this_product==5){
                                            // echo 5;
                                        }else{
                                            // echo number_format($average_ratings_for_this_product, 2, ".", "");
                                        }
                                        $round_average_rating = round($average_ratings_for_this_product);
                                        $star_count = 0;
                                        for ($i=1; $i <=$round_average_rating; $i++) { 
                                        echo '<i class="fa-solid fa-star"></i>';
                                            $star_count++;
                                        }
                                        if($star_count<5){
                                            for ($star_count; $star_count <5 ; $star_count++) { 
                                                echo '<i class="fa-solid fa-star text-secondary"></i>';
                                            }
                                        }
                                    ?>
                                    
                                </div>
                                <h4>₱<?= $row['product_price'] ?></h4>
                            </div>
                            <a href="sproduct.php?id=<?=$row['product_id']?>" hidden><i class="fa-solid fa-cart-shopping cart"></i></a>

                            <input type="hidden" value="<?=$row['category']?>" id="category_value" class="category_value">
                            <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                            <input type="hidden" value="<?=$row['product']?>" id="product">
                            <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                            <?php if(!isset($_SESSION['username'])):?>
                                <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                            <?php else:?>
                                <?php 
                                    $add_hypen_for_add_ons_modal =  str_replace(" ", "-", $category);
                                ?>
                                <a href="#add_to_cart" class="normal" id="add_to_cart_p1" data-toggle="modal" data-target="<?=$add_hypen_for_add_ons_modal?>-add-ons-modal"><i class="fa-solid fa-cart-shopping cart"></i></a>
                            <?php endif;?>
                        </div>

                <?php   
                    } // end of while loop
                } //end if
                ?>
        </div>

        <h2 class="mt-5">Highest Rated</h2>
        <div class="pro-container d-flex justify-content-evenly"  >
            <?php 
                $product_list = "
                    SELECT *,AVG(ratings) as avg_ratings 
                    FROM `products_tbl`
                    LEFT JOIN rates_tbl
                    ON products_tbl.product_id = rates_tbl.product_id
                    GROUP BY product
                    ORDER BY avg_ratings DESC
                    LIMIT 3
                " ; 
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 
                        $category = $row['category'];
            ?>
                        <div class="pro">
                            <img src="admin/assets/img/<?=$row['product_image']?>" alt="" style="width:100%;height:200px;">
                            <div class="des">
                                <span><?= $row['product'] ?> </span>
                                <?php
                                    $get_product_name_for_ratings = substr($row['product'], 0, -4);
                                    $get_product_average_ratings_query = "
                                        SELECT AVG(ratings) as average_ratings
                                        FROM products_tbl
                                        LEFT JOIN rates_tbl
                                        ON products_tbl.product_id = rates_tbl.product_id
                                        WHERE category = '$category' 
                                        AND product LIKE '%$get_product_name_for_ratings%' ";
                                    $result_list_for_average_ratings = $con->query($get_product_average_ratings_query);
                                    $average_ratings_row = $result_list_for_average_ratings->fetch_assoc();
                                    $average_ratings_for_this_product = $average_ratings_row['average_ratings'];
                                ?> 
        
                                <div class="star">
                                    <?php
                                        if($average_ratings_for_this_product==5){
                                            // echo 5;
                                        }else{
                                            // echo number_format($average_ratings_for_this_product, 2, ".", "");
                                        }
                                        $round_average_rating = round($average_ratings_for_this_product);
                                        $star_count = 0;
                                        for ($i=1; $i <=$round_average_rating; $i++) { 
                                        echo '<i class="fa-solid fa-star"></i>';
                                            $star_count++;
                                        }
                                        if($star_count<5){
                                            for ($star_count; $star_count <5 ; $star_count++) { 
                                                echo '<i class="fa-solid fa-star text-secondary"></i>';
                                            }
                                        }
                                    ?>
                                    
                                </div>
                                <h4>₱<?= $row['product_price'] ?></h4>
                            </div>
                            <a href="sproduct.php?id=<?=$row['product_id']?>" hidden><i class="fa-solid fa-cart-shopping cart"></i></a>

                            <input type="hidden" value="<?=$row['category']?>" id="category_value" class="category_value">
                            <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                            <input type="hidden" value="<?=$row['product']?>" id="product">
                            <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                            <?php if(!isset($_SESSION['username'])):?>
                                <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                            <?php else:?>
                                <?php 
                                    $add_hypen_for_add_ons_modal =  str_replace(" ", "-", $category);
                                ?>
                                <a href="#add_to_cart" class="normal" id="add_to_cart_p1" data-toggle="modal" data-target="<?=$add_hypen_for_add_ons_modal?>-add-ons-modal"><i class="fa-solid fa-cart-shopping cart"></i></a>
                            <?php endif;?>
                        </div>

                <?php   
                    } // end of while loop
                } //end if
                ?>
        </div>
    </section>


    <?php 
    $categroy_list = "SELECT DISTINCT(category) FROM category_tbl WHERE is_active=1 ";
    $categroy_result_list = $con->query($categroy_list);
    if ($categroy_result_list->num_rows>0) {
        while ($category_row = $categroy_result_list->fetch_assoc()){ 
            $add_ons_modal_category =  $category_row['category'];

            $add_hypen_for_add_ons_modal =  str_replace(" ", "-", $add_ons_modal_category);

            ?>
                <!-- add-ons modal -->
                <div class="modal fade" id="<?=$add_hypen_for_add_ons_modal?>-add-ons-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header j-orange">
                                <h4 class="modal-title "><?= $add_ons_modal_category ?> - ADD ONS</h4>
                                <a href="#closed_modal" class=" btn btn-close" style='text-decoration:none;' data-dismiss="modal" aria-label="Close"></a>
                            </div>

                            <div class="modal-body">
                                
                                <?php 
                                    $add_hypen_for_add_ons_modal =  str_replace(" ", "-", $add_ons_modal_category);
                                    $add_ons_list = "
                                        SELECT * 
                                        FROM add_ons_list_tbl 
                                        WHERE add_ons_category='$add_ons_modal_category'  
                                        AND add_ons_quantity>0 
                                        AND is_active=1
                                    ";
                                    $result_add_ons_list = $con->query($add_ons_list);
                                    if ($result_add_ons_list->num_rows>0) {
                                        while ($add_ons_row = $result_add_ons_list->fetch_assoc()){ 
                                            $add_ons_category =  $add_ons_row['add_ons_category'];
                                            ?>
                                                <div class="form-check">
                                                    <input class="form-check-input add_ons" type="radio" id="<?=$add_ons_row['add_ons']?><?=$add_ons_row['add_ons_category']?>" value="<?=$add_ons_row['add_ons_list_id']?>"   name="<?=$add_hypen_for_add_ons_modal?>">
                                                    <label class="form-check-label float-start" for="<?=$add_ons_row['add_ons']?><?=$add_ons_row['add_ons_category']?>">
                                                        <?=$add_ons_row['add_ons']?> ₱<?=$add_ons_row['add_ons_price']?> 
                                                    </label>
                                                </div>
                                            <?php
                                        }
                                    }
                                ?>
                                <div class="form-check">
                                    <input class="form-check-input no_add_ons " type="radio" value="no_add_ons" id="<?=$add_ons_category?>" name="<?=$add_hypen_for_add_ons_modal?>" checked >
                                    <label class="form-check-label float-start" for="<?=$add_ons_category?>">
                                        No add ons 
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer ">
                                <!-- justify-content-between -->
                                <label for="">Quantity</label>
                                <input class="form-control w-50 " type="number" value="1" class="order_quantity p-2"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                <div id="subtotal" class="d-flex justify-content-start close-fruittea-modal" style="border:0;margin:0;padding:0;">
                                    <button type="button" class="normal mx-1 close_modal " data-dismiss="modal" >Cancel</button>
                                    <input type="hidden" value="" id="product_id_modal" class="product_id_modal">
                                    <input type="hidden" value="" id="product_modal" class="product_modal">
                                    <input type="hidden" value="" id="product_price_modal">
                                    <button class="normal " id="add_to_cart" data-dismiss="modal">Add&nbsp;to&nbsp;Cart</button> 
                                </div>

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            <?php
        }
    }
    ?>

</body>
<?php include('footer.php');?>

<script>

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
        document.getElementById(id_value).value = value;
    }

    $(document).ready(function () {
        $(document).on('click','#increase_quantity', function  (e) {
            var get_input_quantity_id = $(this).prev().attr('id');
            // console.log("get_input_quantity_id: "+$("#"+get_input_quantity_id).val());
            var get_availed_product_id = $(this).prev().prev().prev().prev().attr('id');
            // console.log("get_availed_product_id: "+$("#"+get_availed_product_id).val());
            var get_availed_product = $(this).prev().prev().prev().attr('id');
            // console.log("get_availed_product: "+$("#"+get_availed_product).val());

            var get_availed_id_number = get_input_quantity_id.replace(/[^\d.-]/g, '');
            // console.log("get_availed_id_number: "+get_availed_id_number);

            var product_id = $("#"+get_availed_product_id).val();
            var product = $("#"+get_availed_product).val();
            // var product_quantity = $("#"+get_input_quantity_id).val();
            var product_quantity = 1;


            var max_product_quantity = $('#availed_quantity'+get_availed_id_number).attr('max');

            if(parseInt($('#availed_quantity'+get_availed_id_number).val()) > parseInt(max_product_quantity)){
                swal({
                    title: "You've reached the maximum quantity",
                    // text: "Once deleted, you will not be able to recover this user!",
                    icon: "info",
                    buttons: "OK",
                    dangerMode: true,
                });
                $('#availed_quantity'+get_availed_id_number).val(max_product_quantity);
            }else{
                $.ajax({
                    method: "POST",
                    url: "process.php",
                    data: {
                        'add_to_cart' : 1,
                        'product_id' : product_id,
                        'product' : product,
                        'product_quantity' : product_quantity
                    },
                    success: function (response) {
                        // console.log(response); //for debug


                        if(response=="invalid input"){
                            console.log(response);

                            swal({
                                title: "Invalid Input.",
                                // text: "Once deleted, you will not be able to recover this user!",
                                icon: "warning",
                                buttons: "OK",
                                dangerMode: true,
                            });
                        }else{
                        
                            // $('#availed_count').text(response);

                            var obj = JSON.parse(response);
                            // console.log(response)
                            
                            $('#availed_count').val(obj.availed_count); // set notif count
                            $('#availed_amount'+get_availed_id_number).text(obj.subtotal);
                            $('.order_amount').text("₱"+obj.order_amount);

                        }
                    
                    }
                });
            }
            
        });
        
        $(document).on('click','#decrease_quantity', function  (e) {
            
            var get_input_quantity_id = $(this).next().attr('id');
            var get_availed_id_number = get_input_quantity_id.replace(/[^\d.-]/g, '');
            // console.log("#availed_quantity"+get_availed_id_number);
            // console.log($("#availed_quantity"+get_availed_id_number).val());
            if($("#availed_quantity"+get_availed_id_number).val()<0){
                
                $( this ).attr('disabled',true);
                

                $("#availed_quantity"+get_availed_id_number).val(0);
        
                swal({
                    title: "Remove Order",
                    // text: "Once deleted, you will not be able to recover this product!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "POST",
                            url: "process.php",
                            data: {
                                'Remove_product' : 1,
                                'availed_id' : get_availed_id_number,
                            },
                            success: function (response) {
                                // console.log(response); //for debug
                                var obj = JSON.parse(response);
                                // $('#availed_count').val(obj.Remove_product); // set notif count
                                // $('#availed_amount'+get_availed_id_number).text(obj.availed_id);
                                $('.order_amount').text("₱"+obj.new_availed_amount);
                                $('#availed_count').text(obj.availed_count);
                                if(obj.availed_count=="0"){
                                    $('.hide_availed_count').attr('hidden',true);
                                }

                            }
                        });
                        $("#table_row"+get_availed_id_number).hide();
                    } 
                    else {
                        // swal("Your imaginary file is safe!");
                        $("#availed_quantity"+get_availed_id_number).val(0);
                    }
                });
                   

                $("#availed_quantity"+get_availed_id_number).val(0);
            }else{
                $( this ).attr('disabled',false);

                if($("#availed_quantity"+get_availed_id_number).val()>=0){
                    

                    var get_input_quantity_id = $(this).next().attr('id');
                    // console.log("get_input_quantity_id: "+$("#"+get_input_quantity_id).val());
                    var get_availed_product_id = $(this).prev().prev().attr('id');
                    // console.log("get_availed_product_id: "+$("#"+get_availed_product_id).val());
                    var get_availed_product = $(this).prev().attr('id');
                    // console.log("get_availed_product: "+$("#"+get_availed_product).val());

                    var get_availed_id_number = get_input_quantity_id.replace(/[^\d.-]/g, '');
                    // console.log("get_availed_id_number: "+get_availed_id_number);

                    var product_id = $("#"+get_availed_product_id).val();
                    var product = $("#"+get_availed_product).val();
                    // var product_quantity = $("#"+get_input_quantity_id).val();
                    var product_quantity = -1;
                    // console.log("product_quantity: "+product_quantity);

                    $.ajax({
                        method: "POST",
                        url: "process.php",
                        data: {
                            'add_to_cart' : 1,
                            'product_id' : product_id,
                            'product' : product,
                            'product_quantity' : product_quantity
                        },
                        success: function (response) {
                            // console.log(response); //for debug


                            if(response=="invalid input"){
                                console.log(response);

                                swal({
                                    title: "Invalid Input.",
                                    // text: "Once deleted, you will not be able to recover this user!",
                                    icon: "warning",
                                    buttons: "OK",
                                    dangerMode: true,
                                });
                            }else{
                            
                                // $('#availed_count').text(response);

                                var obj = JSON.parse(response);
                                // console.log(response)
                                
                                $('#availed_count').val(obj.availed_count); // set notif count
                                $('#availed_amount'+get_availed_id_number).text(obj.subtotal);
                                $('.order_amount').text("₱"+obj.order_amount);

                            }
                        
                        }
                    });
                }else{
                    console.log('remove');
                }
            }
            
        });

        //update details on quantity change
        $(document).on('change','.availed_quantity_class', function  (e) {
            console.log('availed_quantity_class');

            var get_input_quantity_id = $(this).attr('id');
            // console.log("get_input_quantity_id: "+$("#"+get_input_quantity_id).val());
            var get_availed_product_id = $(this).prev().prev().prev().attr('id');
            // console.log("get_availed_product_id: "+$("#"+get_availed_product_id).val());
            var get_availed_product = $(this).prev().prev().attr('id');
            // console.log("get_availed_product: "+$("#"+get_availed_product).val());

            var get_availed_id_number = get_input_quantity_id.replace(/[^\d.-]/g, '');
            // console.log("get_availed_id_number: "+get_availed_id_number);

            var product_id = $("#"+get_availed_product_id).val();
            var product = $("#"+get_availed_product).val();
            var product_quantity = $("#"+get_input_quantity_id).val();
            // var product_quantity = -1;
            // console.log("product_id: "+product_id);
            // console.log("product: "+product);
            // console.log("product_quantity: "+product_quantity);

            var max_product_quantity = $('#availed_quantity'+get_availed_id_number).attr('max');
            if(parseInt($('#availed_quantity'+get_availed_id_number).val()) > parseInt(max_product_quantity)){
               

                swal({
                    title: "You've reached the maximum quantity",
                    // text: "Once deleted, you will not be able to recover this product!",
                    icon: "info",
                    buttons: "OK",
                    dangerMode: false,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        window.location = 'cart.php'
                    }
                });
            }else{

                $.ajax({
                    method: "POST",
                    url: "process.php",
                    data: {
                        'add_to_cart' : 1,
                        'update_quantity' : 1,
                        'product_id' : product_id,
                        'product' : product,
                        'product_quantity' : product_quantity
                    },
                    success: function (response) {
                        // console.log(response); //for debug


                        if(response=="invalid input"){
                            console.log(response);

                            swal({
                                title: "Invalid Input.",
                                // text: "Once deleted, you will not be able to recover this user!",
                                icon: "warning",
                                buttons: "OK",
                                dangerMode: true,
                            });
                        }else{
                        
                            // $('#availed_count').text(response);

                            var obj = JSON.parse(response);
                            $('#availed_count').val(obj.availed_count); // set notif count
                            $('#availed_amount'+get_availed_id_number).text(obj.subtotal);
                            $('.order_amount').text("₱"+obj.order_amount);

                        }
                    
                    }
                });
            }
        });

        $(document).on('click','.Remove_product', function  (e) {

            var get_availed_id_number = $(this).attr('id').replace(/[^\d.-]/g, '');
            console.log(get_availed_id_number);

            swal({
                title: "Remove Order",
                // text: "Once deleted, you will not be able to recover this product!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: "POST",
                        url: "process.php",
                        data: {
                            'Remove_product' : 1,
                            'availed_id' : get_availed_id_number,
                        },
                        success: function (response) {
                            // console.log(response); //for debug
                            var obj = JSON.parse(response);
                            // $('#availed_count').val(obj.Remove_product); // set notif count
                            // $('#availed_amount'+get_availed_id_number).text(obj.availed_id);
                            var new_availed_amount = parseFloat(obj.new_availed_amount) - parseFloat(75);
                            $('.order_amount').text("₱"+new_availed_amount);
                            $('.order_amount_total').text("₱"+obj.new_availed_amount);
                            $('#availed_count').text(obj.availed_count);
                            if(obj.availed_count=="0"){
                                $('.hide_availed_count').attr('hidden',true);
                            }
                        }
                    });
                    $("#table_row"+get_availed_id_number).hide();
                } 
                
            });
            
        });


        $(document).on('click','.Remove_all_products', function  (e) {

            console.log('Remove_all_products');

            swal({
                title: "Remove All Product",
                // text: "Once deleted, you will not be able to recover this product!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: "POST",
                        url: "process.php",
                        data: {
                            'Remove_All_Product' : 1,
                        },
                        success: function (response) {
                            console.log(response); //for debug
                            window.location="menuV3.php";
                        }
                    });
                   
                } 
                
            });
        });


        $(document).on('click','#add_to_cart', function  (e) {
            e.preventDefault();
            console.log('add_to_cart');
            var product_id = $(this).prev().prev().prev().val();
            var product = $(this).prev().prev().val();
            var product_quantity = $(this).parent().prev().val();
            // var product_quantity = 1;
            // console.log(product_id);
            console.log(product_quantity);

            // var add_ons='';
            // $('.add_ons:checkbox:checked').each(function (e) {
            //     console.log(this.value);
            //     // add_ons_array.push(this.value);
            //     add_ons +=this.value+',';
            // });
            // add_ons = add_ons.slice(0, -1);
            // console.log(add_ons);

            var add_ons=$('.add_ons:radio:checked').val();
            console.log(product_id);
            console.log(product);
            console.log(product_quantity);
            console.log(add_ons);
            
            if(product_quantity>=1){
                $.ajax({
                    method: "POST",
                    url: "process.php",
                    data: {
                        'add_to_cart' : 1,
                        'product_id' : product_id,
                        'product' : product,
                        'product_quantity' : product_quantity,
                        'add_ons': add_ons,
                    },
                    success: function (response) {
                        console.log(response); //for debug
                        var obj = JSON.parse(response);

                        if(obj.system_msg=="invalid input"){
                            // console.log(response);

                            swal({
                                title: "Invalid Input.",
                                icon: "warning",
                                buttons: "OK",
                                dangerMode: true,
                            });
                        }else{

                            $('.add_ons').prop('checked', false); // Unchecks it

                            //toast here
                            var x = document.getElementById("added_to_cart");
                            x.className = "show";
                            setTimeout(function(){ x.className = x.className.replace("show", ""); window.location=''; }, 3000);

                            $('#availed_count').text(obj.availed_count);
                            $('.hide_availed_count').attr('hidden',false);
                            // console.log("show add_to_cart");
                            // console.log(response);
                            // console.log("availed_count: "+obj.availed_count);

                        }
                    }
                });
            }else{
                swal({
                    title: "Invalid Input.",
                    icon: "warning",
                    buttons: "OK",
                    dangerMode: true,
                });
            }
        });

        $(document).on('click','#add_to_cart_login', function  (e) {
            swal({
                title: "Please login to place your order.",
                // text: "Once deleted, you will not be able to recover this product!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    window.location="login.php";
                } 
                else {
                    //continue browesing
                }
            });
        });

        $(document).on('click','.no_add_ons', function  (e) {

        $('.add_ons').prop('checked', false); // Unchecks it

        });
        $(document).on('click','.add_ons', function  (e) {

        $('.no_add_ons').prop('checked', false); // Unchecks it

        });

        $(document).on('click','.btn-close, .close_modal', function  (e) {
            $('.modal').modal('hide');
        });

        $(document).on('click','#add_to_cart_p1', function  (e) {
            var product_id = $(this).prev().prev().prev().val();
            var product = $(this).prev().prev().val();
            var category = $(this).prev().prev().prev().prev().val();
            // console.log(product_id);
            // console.log(product);
            // console.log(category);
            category =  category.replace(/\s+/g, '-');

            $('.product_id_modal').val(product_id);
            $('.product_modal').val(product);
            $('#'+category+'-add-ons-modal').modal('show');
           
        });


    }); // end of jqdoc
</script>
