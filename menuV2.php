<?php include('header.php');?>

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


    <!-- page HEADER -->
    <!-- <div id="carouselExampleIndicators" class="carousel slide  d-flex justify-content-center" data-bs-ride="true"  >
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" style="height:200px;width:100%">
            <div class="carousel-item active">
            <img src="admin/assets/img/featured_items.png" class="d-block w-100" alt="..." style="height:200px;width:200px">
            </div>
            <div class="carousel-item">
            <img src="admin/assets/img/featured_items2.png" class="d-block w-100" alt="..." style="height:200px;width:200px">
            </div>
            <div class="carousel-item">
            <img src="admin/assets/img/featured_items3.jfif" class="d-block w-100" alt="..." style="height:200px;width:200px">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div> -->
        

        <!-- CATEGORY1 --> 
        <div style="margin-top:100px;"></div>
    <section id="product1" class="section-p1  " >
        <div id="added_to_cart">Added to Cart</div>

        <h2 class='' id="coffee_section">Coffee</h2>
        <div class="pro-container d-flex justify-content-center"  >
            <?php 
                $product_array_list_checker_for_count = [];
                $product_list = "SELECT * FROM products_tbl WHERE category = 'coffee' AND product_quantity>0 AND is_active=1"; //category = category_name
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 
                        array_push($product_array_list_checker_for_count,$row['product']); //store displayed product
                    }
                }
                $product_array_list_count = array_count_values($product_array_list_checker_for_count);
            

                $product_array_list_checker = [];
                $product_list = "
                    SELECT * 
                    FROM products_tbl  WHERE category = 'coffee'  
                    AND product_quantity>0 
                    $condition 
                    AND is_active=1
                "; //category = category_name
                // echo $product_list;
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    // $animate_duration = 2000;
                    while ($row = $result_list->fetch_assoc()){ 

                        $product_id=$row['product_id'];
                        
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

                        if(!in_array($row['product'],$product_array_list_checker)){
                            if($product_array_list_count[$row['product']]>=2){
                                ?>
                                <div class="pro m-1"   >
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span><?= $row['product']?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'coffee' 
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
                                    </div>
                                        <input type="hidden" value="<?= $row['category'] ?>">
                                        <input type="hidden" value="<?= $product ?>">
                                        <?php if(!isset($_SESSION['username'])):?>
                                            <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php else:?>
                                            <a href="#add_to_cart" class="normal" id="add_to_cart_sizes" data-bs-toggle="modal" data-bs-target='#display-product-sizes-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php endif;?>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="pro m-1"   >
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des" >
                                        <span><?= $row['product'] ?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'coffee' 
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
                                    
                                    <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                                    <input type="hidden" value="<?=$row['product']?>" id="product">
                                    <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                                    <?php if(!isset($_SESSION['username'])):?>
                                        <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php else:?>
                                        <a href="#add_to_cart" class="normal" id="add_to_cart_p1" data-toggle='modal' data-target='#coffee-add-ons-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php endif;?>
                                </div>
                            
                                <?php 
                            }//end else
                        }//end else

                        array_push($product_array_list_checker,substr($row['product'], 0, -3));
                        // $animate_duration+=500;
                    }//end while
                } //end if

                // print_r($product_array_list_checker);
            ?>
        </div>

    </section>

    <section id="product1" class="section-p1  " >
        <h2 class='' id="noncoffee_section">Non-Coffee</h2>
        <div class="pro-container d-flex justify-content-center"  >
            <?php 
                $product_array_list_checker_for_count = [];
                $product_list = "SELECT * FROM products_tbl WHERE category = 'noncoffee' AND product_quantity>0 AND is_active=1"; //category = category_name
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 
                        array_push($product_array_list_checker_for_count,$row['product']); //store displayed product
                    }
                }
                $product_array_list_count = array_count_values($product_array_list_checker_for_count);
            

                $product_array_list_checker = [];
                $product_list = "
                    SELECT * 
                    FROM products_tbl  WHERE category = 'noncoffee'  
                    AND product_quantity>0 
                    $condition 
                    AND is_active=1
                "; //category = category_name
                // echo $product_list;
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 

                        $product_id=$row['product_id'];
                        
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

                        if(!in_array($row['product'],$product_array_list_checker)){
                            if($product_array_list_count[$row['product']]>=2){
                                ?>
                                <div class="pro m-1">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span><?= $row['product']?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'noncoffee' 
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
                                    </div>
                                        <input type="hidden" value="<?= $row['category'] ?>">
                                        <input type="hidden" value="<?= $product ?>">
                                        <?php if(!isset($_SESSION['username'])):?>
                                            <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php else:?>
                                            <a href="#add_to_cart" class="normal" id="add_to_cart_sizes" data-bs-toggle="modal" data-bs-target='#display-product-sizes-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php endif;?>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="pro m-1">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span><?= $row['product'] ?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'noncoffee' 
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
                                    
                                    <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                                    <input type="hidden" value="<?=$row['product']?>" id="product">
                                    <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                                    <?php if(!isset($_SESSION['username'])):?>
                                        <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php else:?>
                                        <a href="#add_to_cart" class="normal" id="add_to_cart_p1" data-toggle='modal' data-target='#coffee-add-ons-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php endif;?>
                                </div>

                                
                            
                                <?php 
                            }//end else
                        }//end else

                        array_push($product_array_list_checker,substr($row['product'], 0, -3));

                    }//end while
                } //end if

                // print_r($product_array_list_checker);
            ?>
        </div>

    </section>
    

    <!-- CATEGORY2 -->
    <section id="product1" class="section-p1">
        <h2 id="milktea_section">Milk Tea</h2></span>
        <div class="pro-container d-flex justify-content-center"  >
            <?php 
                $product_array_list_checker_for_count = [];
                $product_list = "SELECT * FROM products_tbl WHERE category = 'milktea' AND product_quantity>0 AND is_active=1"; //category = category_name
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 
                        array_push($product_array_list_checker_for_count,substr($row['product'], 0, -3)); //store displayed product
                    }
                }
                $product_array_list_count = array_count_values($product_array_list_checker_for_count);
            
                // -----------------------------
                // $trimmed_product=[];
                // $distinct_product = "SELECT DISTINCT(SUBSTRING(product,  1,  CHAR_LENGTH(product) - 4)) AS trimmed_product FROM products_tbl WHERE category = 'milktea' AND product_quantity>0 AND is_active=1 ";
                // $result_list = $con->query($distinct_product);
                // if ($result_list->num_rows>0) {
                //     while ($row = $result_list->fetch_assoc()){ 
                //         array_push($trimmed_product, $row['trimmed_product']); //distinct product
                //     }
                // }

                $product_array_list_checker = [];
                $product_list = "
                    SELECT * 
                    FROM products_tbl  WHERE category = 'milktea'  
                    AND product_quantity>0 
                    $condition 
                    AND is_active=1
                "; //category = category_name
                // echo $product_list;
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 

                        $product_id=$row['product_id'];
                        
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

                        if(!in_array(substr($row['product'], 0, -3),$product_array_list_checker)){
                            if($product_array_list_count[substr($row['product'], 0, -3)]>=2){
                                ?>
                                <div class="pro m-1">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span><?= substr($row['product'], 0, -3)?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'milktea' 
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
                                    </div>
                                        <input type="hidden" value="<?= $row['category'] ?>">
                                        <input type="hidden" value="<?= $product ?>">
                                        <?php if(!isset($_SESSION['username'])):?>
                                            <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php else:?>
                                            <a href="#add_to_cart" class="normal" id="add_to_cart_sizes" data-bs-toggle="modal" data-bs-target='#display-product-sizes-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php endif;?>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="pro m-1">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span><?= substr($row['product'], 0, -3) ?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'milktea' 
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
                                    
                                    <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                                    <input type="hidden" value="<?=$row['product']?>" id="product">
                                    <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                                    <?php if(!isset($_SESSION['username'])):?>
                                        <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php else:?>
                                        <a href="#add_to_cart" class="normal" id="add_to_cart_p1" data-toggle='modal' data-target='#milktea-add-ons-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php endif;?>
                                </div>
                            
                                <?php 
                            }//end else
                        }//end else

                        array_push($product_array_list_checker,substr($row['product'], 0, -3));

                    }//end while
                } //end if

                // print_r($product_array_list_checker);
            ?>
        </div>
    </section>

    <!-- CALL TO ACTION BANNER -->
    <section id="banner" class="section-m1" hidden>
        <h4>Special Coupon Offer!</h4>
        <h2>Up to <span>40% Off</span> Id velit velit est exercitationem esse!</h2>
        <button class="normal">Explore More</button>
    </section>

    <!-- CATEGORY3 -->
    <section id="product1" class="section-p1" hidden>
        <h2 id="creamcheese_section">Cream Cheese Series</h2></span>
        <!-- <div class="pro-container" onclick="window.location.href='sproduct.php';"> -->
        <div class="pro-container" >
            <div class="row d-flex justify-content-center ">
                <?php 
                    $product_list = "SELECT * FROM products_tbl WHERE category = 'creamcheese' AND product_quantity>0 AND is_active=1"; //category = category_name
                    $result_list = $con->query($product_list);
                    if ($result_list->num_rows>0) {
                        while ($row = $result_list->fetch_assoc()){ 

                            $product_id=$row['product_id'];
                            
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
                            ?>
                            
                            <div class="pro">
                                <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                <div class="des">
                                    <span><?= $product ?> </span>
                                    <div class="star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <h4>₱<?= $row['product_price'] ?></h4>
                                </div>
                                <a href="sproduct.php?id=<?=$product_id?>" hidden><i class="fa-solid fa-cart-shopping cart"></i></a>
                                
                                <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                                <input type="hidden" value="<?=$row['product']?>" id="product">
                                <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                                <?php if(!isset($_SESSION['username'])):?>
                                    <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                <?php else:?>
                                    <a href="#add_to_cart" class="normal" id="add_to_cart"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                <?php endif;?>
                            </div>
                            <?php 
                        }//end while
                    } //end if
                ?>
            </div>
        </div>
        <!-- <a href="cream_cheese.php" style="color:#b06548; text-decoration:none;">See More Cream Cheese Series</a> -->

    </section>

    <!-- CATEGORY4 -->
    <section id="product1" class="section-p1">
        <h2 id="cheesecake_section">Cheese Cake Series</h2></span>
        <div class="pro-container d-flex justify-content-center"  >
            <?php 
                $product_array_list_checker_for_count = [];
                $product_list = "SELECT * FROM products_tbl WHERE category = 'cheesecake' AND product_quantity>0 AND is_active=1"; //category = category_name
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 
                        array_push($product_array_list_checker_for_count,substr($row['product'], 0, -3)); //store displayed product
                    }
                }
                $product_array_list_count = array_count_values($product_array_list_checker_for_count);
            

                $product_array_list_checker = [];
                $product_list = "
                    SELECT * 
                    FROM products_tbl  WHERE category = 'cheesecake'  
                    AND product_quantity>0 
                    $condition 
                    AND is_active=1
                "; //category = category_name
                // echo $product_list;
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 

                        $product_id=$row['product_id'];
                        
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

                        if(!in_array(substr($row['product'], 0, -3),$product_array_list_checker)){
                            if($product_array_list_count[substr($row['product'], 0, -3)]>=2){
                                ?>
                                <div class="pro m-1">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span><?= substr($row['product'], 0, -3)?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'cheesecake' 
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
                                    </div>
                                        <input type="hidden" value="<?= $row['category'] ?>">
                                        <input type="hidden" value="<?= $product ?>">
                                        <?php if(!isset($_SESSION['username'])):?>
                                            <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php else:?>
                                            <a href="#add_to_cart" class="normal" id="add_to_cart_sizes" data-bs-toggle="modal" data-bs-target='#display-product-sizes-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php endif;?>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="pro m-1">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span><?= substr($row['product'], 0, -3) ?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'cheesecake' 
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
                                    
                                    <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                                    <input type="hidden" value="<?=$row['product']?>" id="product">
                                    <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                                    <?php if(!isset($_SESSION['username'])):?>
                                        <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php else:?>
                                        <a href="#add_to_cart" class="normal" id="add_to_cart" ><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php endif;?>
                                </div>
                            
                                <?php 
                            }//end else
                        }//end else

                        array_push($product_array_list_checker,substr($row['product'], 0, -3));

                    }//end while
                } //end if

                // print_r($product_array_list_checker);
            ?>
        </div>
    </section>

    <!-- CATEGORY5 -->
    <section id="product1" class="section-p1">
        <h2 id="fruittea_section">Fruit Tea</h2>
        <div class="pro-container d-flex justify-content-center"  >
            <?php 
                $product_array_list_checker_for_count = [];
                $product_list = "SELECT * FROM products_tbl WHERE category = 'fruittea' AND product_quantity>0 AND is_active=1"; //category = category_name
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 
                        array_push($product_array_list_checker_for_count,$row['product']); //store displayed product
                    }
                }
                $product_array_list_count = array_count_values($product_array_list_checker_for_count);
            

                $product_array_list_checker = [];
                $product_list = "
                    SELECT * 
                    FROM products_tbl  WHERE category = 'fruittea'  
                    AND product_quantity>0 
                    $condition 
                    AND is_active=1
                "; //category = category_name
                // echo $product_list;
                $result_list = $con->query($product_list);
                if ($result_list->num_rows>0) {
                    while ($row = $result_list->fetch_assoc()){ 

                        $product_id=$row['product_id'];
                        
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

                        if(!in_array($row['product'],$product_array_list_checker)){
                            if($product_array_list_count[$row['product']]>=2){
                                ?>
                                <div class="pro m-1">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span><?= $row['product']?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'fruittea' 
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
                                    </div>
                                        <input type="hidden" value="<?= $row['category'] ?>">
                                        <input type="hidden" value="<?= $product ?>">
                                        <?php if(!isset($_SESSION['username'])):?>
                                            <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php else:?>
                                            <a href="#add_to_cart" class="normal" id="add_to_cart_sizes" data-bs-toggle="modal" data-bs-target='#display-product-sizes-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        <?php endif;?>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="pro m-1">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span><?= $row['product'] ?> </span>
                                        <?php
                                            $get_product_name_for_ratings = substr($row['product'], 0, -3);
                                            $get_product_average_ratings_query = "
                                                SELECT AVG(ratings) as average_ratings
                                                FROM products_tbl
                                                LEFT JOIN rates_tbl
                                                ON products_tbl.product_id = rates_tbl.product_id
                                                WHERE category = 'fruittea' 
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
                                    
                                    <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                                    <input type="hidden" value="<?=$row['product']?>" id="product">
                                    <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                                    <?php if(!isset($_SESSION['username'])):?>
                                        <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php else:?>
                                        <a href="#add_to_cart" class="normal" id="add_to_cart_p1" data-toggle='modal' data-target='#fruit-tea-add-ons-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    <?php endif;?>
                                </div>
                            
                                <?php 
                            }//end else
                        }//end else

                        array_push($product_array_list_checker,substr($row['product'], 0, -3));

                    }//end while
                } //end if

                // print_r($product_array_list_checker);
            ?>
        </div>
    </section>

    <!--
    <section id="pagination" class="section-p1">
        <a class="active" href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="fa-solid fa-angle-right"></i></i></a>
    </section> -->


    <!-- unique display per product -->
    <div class="modal fade" id="display-product-sizes-modal"   data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Select Size</h4>
                <!-- <button type="button" >
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <a href="#" class=" btn btn-close close-size" style='text-decoration:none;' data-bs-dismiss="modal" aria-label="Close"></a>
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


    <!-- coffee add-ons modal -->
    <div class="modal fade" id="coffee-add-ons-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h5 class="modal-title ">COFFEE / NON COFFEE - ADD ONS</h5>
                <!-- <button type="button" >
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <a href="#" class=" btn btn-close" style='text-decoration:none;' data-dismiss="modal" aria-label="Close"></a>
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
                        <div id="subtotal" class="d-flex justify-content-start" style="border:0;margin:0;padding:0;">
                            <button type="button" class="normal mx-1" data-dismiss="modal" style="">Cancel</button>
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
                        <div id="subtotal" class="d-flex justify-content-start" style="border:0;margin:0;padding:0;">
                            <button type="button" class="normal mx-1" data-dismiss="modal" style="">Cancel</button>
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


    
    
</body>

<?php include('footer.php');?>

<script>

    $(document).ready(function () {

        //add_to_cart_p1
        $(document).on('click','#add_to_cart_p1', function  (e) {
            var product_id = $(this).prev().prev().prev().val();
            var product = $(this).prev().prev().val();
            var product_quantity = 1;

            $('.product_id_modal').val(product_id);
            $('.product_modal').val(product);

            $('#display-product-sizes-modal').modal('hide');
            $('#sizes-body').html('');
        });



        $(document).on('click','#add_to_cart', function  (e) {
            e.preventDefault();
            console.log('add_to_cart');
            var product_id = $(this).prev().prev().prev().val();
            var product = $(this).prev().prev().val();
            var product_quantity = 1;
            // console.log(product_id);
            // console.log(product);
            // console.log(product_quantity);

            // var add_ons_array = [];
            var add_ons='';
            $('.add_ons:checkbox:checked').each(function (e) {
                console.log(this.value);
                // add_ons_array.push(this.value);
                add_ons +=this.value+',';
            });
            // console.log(add_ons_array);
            add_ons = add_ons.slice(0, -1);
            console.log(add_ons);

            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'add_to_cart' : 1,
                    'product_id' : product_id,
                    'product' : product,
                    'product_quantity' : product_quantity,
                    'add_ons': add_ons
                },
                success: function (response) {
                    // console.log(response); //for debug
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

                        //uncheck checkboxes
                        $('.add_ons').prop('checked', false); // Unchecks it
                        // console.log('add_ons');

                        //toast here
                        var x = document.getElementById("added_to_cart");
                        x.className = "show";
                        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

                        $('#availed_count').text(obj.availed_count);
                        $('.hide_availed_count').attr('hidden',false);

                        // $('#display-product-sizes-modal').modal('hide');
                        // $('#sizes-body').html('');

                        // console.log("show add_to_cart");
                        // console.log(response);
                        // console.log("availed_count: "+obj.availed_count);

                    }
                }
            });
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


        $(document).on('click','#add_to_cart_sizes', function  (e) {

            console.log("add_to_cart_sizes");
            // console.log($(this).prev().val());

            var category = $(this).prev().prev().val();
            var product = $(this).prev().val();
            product = product.slice(0, -3);
            // console.log(product);
            // console.log(product);
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
                        console.log('image: '+element[3]);

                        if(get_product_category=='cheesecake'){
                            $('#sizes-body').append(
                                `
                                <div class="pro m-4">
                                    <img src="admin/assets/img/`+element[3]+`" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span>`+get_product_name+` </span>
                                        <h4>₱`+get_product_price+`</h4>
                                    </div>
                                        <input type="hidden" value="`+get_product_id+`" id="product_id" class="product_id">
                                        <input type="hidden" value="`+get_product_name+`" id="product">
                                        <input type="hidden" value="`+get_product_price+`" id="product_price">
                                        <a href="#add_to_cart" class="normal " id="add_to_cart"  ><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                                `
                            );
                        }else{
                            $('#sizes-body').append(
                                `
                                <div class="pro m-4">
                                    <img src="admin/assets/img/`+element[3]+`" alt="" style="width:100%;height:200px;">
                                    <div class="des">
                                        <span>`+get_product_name+` </span>
                                        <h4>₱`+get_product_price+`</h4>
                                    </div>
                                        <input type="hidden" value="`+get_product_id+`" id="product_id" class="product_id">
                                        <input type="hidden" value="`+get_product_name+`" id="product">
                                        <input type="hidden" value="`+get_product_price+`" id="product_price">
                                        <a href="#add_to_cart" class="normal " id="add_to_cart_p1"  data-toggle="modal" data-target="#`+category+`-add-ons-modal"><i class="fa-solid fa-cart-shopping cart"></i></a>
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



    