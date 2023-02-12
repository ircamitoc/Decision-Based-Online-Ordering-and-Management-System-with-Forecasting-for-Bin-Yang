<?php include('header.php');?>

    <!-- page HEADER -->
    <section id="banner">
        <h3>#StayHome</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
    </section>
    <!-- CATEGORY 1 FEATURED PRODUCTS-->
        <div class="row" style="text-align:center;">
            <div class="col-6" id="fproducts">
                <section id="product1" class="section-p1">
                    <h3>Featured Products</h3>
                    <div class="pro-container">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>

                        <div class="w-100"></div> <!-- force break line-->
                        
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                        
                        <div class="w-100"></div> <!-- force break line-->

                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                    </div>
                </section>
            </div>
            <!-- End of FEATURED PRODUCTS-->
            <div class="col-6" id="product_col">
            <!-- CATEGORY1 --> 
            <section id="product1" class="section-p1">
                <h3 id="coffee_section">Coffee</h3>
                <!-- <div class="pro-container" onclick="window.location.href='sproduct.php';"> -->
                <div class="pro-container">
                    <?php 
                            $product_list = "SELECT * FROM products_tbl WHERE category = 'coffee' LIMIT 9" ; //category = category_name
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
                                        <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                        <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    </div>
                                    <?php 
                                }//end while
                            } //end if
                    ?>
                </div>
                <a href="coffee.php" style="color:#b06548; text-decoration:none;">See More Coffee</a>

            </section>
            </div>
        </div>
        <!-- END OF COFFEE  MENU -->
    <!-- CATEGORY 2 FEATURED PRODUCTS-->
    <div class="row" style="text-align:center;">
            <div class="col-6" id="fproducts">
                <section id="product1" class="section-p1">
                    <h3>Featured Products</h3>
                    <div class="pro-container">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>

                        <div class="w-100"></div> <!-- force break line-->
                        
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                        
                        <div class="w-100"></div> <!-- force break line-->

                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                    </div>
                </section>
            </div>
            <!-- End of FEATURED PRODUCTS-->
            <div class="col-6" id="product_col">
            <!-- CATEGORY2 --> 
            <section id="product1" class="section-p1">
                <h3 id="milktea_section">Milk Tea</h3>
                <span>M - medium</span><br><span>L - large</span>
                <!-- <div class="pro-container" onclick="window.location.href='sproduct.php';"> -->
                <div class="pro-container">
                    <?php 
                            $product_list = "SELECT * FROM products_tbl WHERE category = 'milktea' LIMIT 9" ; //category = category_name
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
                                        <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                        <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    </div>
                                    <?php 
                                }//end while
                            } //end if
                    ?>
                </div>
                <a href="milk_tea.php" style="color:#b06548; text-decoration:none;">See More Milk Tea</a>

            </section>
            </div>
        </div>
    
    <!-- CALL TO ACTION BANNER -->
    <section id="banner" class="section-m1">
        <h4>Special Coupon Offer!</h4>
        <h3>Up to <span>40% Off</span> Id velit velit est exercitationem esse!</h3>
        <button class="normal">Explore More</button>
    </section>
    <!-- CATEGORY 3 FEATURED PRODUCTS-->
    <div class="row" style="text-align:center;">
            <div class="col-6" id="fproducts">
                <section id="product1" class="section-p1">
                    <h3>Featured Products</h3>
                    <div class="pro-container">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>

                        <div class="w-100"></div> <!-- force break line-->
                        
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                        
                        <div class="w-100"></div> <!-- force break line-->

                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                    </div>
                </section>
            </div>
            <!-- End of FEATURED PRODUCTS-->
            <div class="col-6" id="product_col">
            <!-- CATEGORY3 --> 
            <section id="product1" class="section-p1">
                <h3 id="creamcheese_section">Cream Cheese Series</h3>
                <span>M - medium</span><br><span>L - large</span>
                <!-- <div class="pro-container" onclick="window.location.href='sproduct.php';"> -->
                <div class="pro-container">
                    <?php 
                            $product_list = "SELECT * FROM products_tbl WHERE category = 'creamcheese' LIMIT 9" ; //category = category_name
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
                                        <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                        <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    </div>
                                    <?php 
                                }//end while
                            } //end if
                    ?>
                </div>
                <a href="cream_cheese.php" style="color:#b06548; text-decoration:none;">See More Cream Cheese</a>

            </section>
            </div>
        </div>
        <!-- END OF Cream Cheese  MENU -->
    
    <!-- CATEGORY 4 FEATURED PRODUCTS-->
    <div class="row" style="text-align:center;">
            <div class="col-6" id="fproducts">
                <section id="product1" class="section-p1">
                    <h3>Featured Products</h3>
                    <div class="pro-container">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>

                        <div class="w-100"></div> <!-- force break line-->
                        
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                        
                        <div class="w-100"></div> <!-- force break line-->

                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                    </div>
                </section>
            </div>
            <!-- End of FEATURED PRODUCTS-->
            <div class="col-6" id="product_col">
            <!-- CATEGORY4 --> 
            <section id="product1" class="section-p1">
                <h3 id="cheesecake_section">Cheese Cake Series</h3>
                <span>M - medium</span><br><span>L - large</span>
                <!-- <div class="pro-container" onclick="window.location.href='sproduct.php';"> -->
                <div class="pro-container">
                    <?php 
                            $product_list = "SELECT * FROM products_tbl WHERE category = 'cheesecake' LIMIT 9" ; //category = category_name
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
                                        <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                        <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    </div>
                                    <?php 
                                }//end while
                            } //end if
                    ?>
                </div>
                <a href="cheese_cake.php" style="color:#b06548; text-decoration:none;">See More Cheese Cake</a>

            </section>
            </div>
        </div>
        <!-- END OF Cheese Cake  MENU -->                     
   
    <!-- CATEGORY 5 FEATURED PRODUCTS-->
    <div class="row" style="text-align:center;">
            <div class="col-6" id="fproducts">
                <section id="product1" class="section-p1">
                    <h3>Featured Products</h3>
                    <div class="pro-container">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>

                        <div class="w-100"></div> <!-- force break line-->
                        
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                        
                        <div class="w-100"></div> <!-- force break line-->

                            <div class="col-4">
                                <div class="pro">
                                    <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                    <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                </div>
                            </div>
                    </div>
                </section>
            </div>
            <!-- End of FEATURED PRODUCTS-->
            <div class="col-6" id="product_col">
            <!-- CATEGORY5 --> 
            <section id="product1" class="section-p1">
                <h3 id="fruittea_section">Fruit Tea</h3>
                <!-- <div class="pro-container" onclick="window.location.href='sproduct.php';"> -->
                <div class="pro-container">
                    <?php 
                            $product_list = "SELECT * FROM products_tbl WHERE category = 'fruittea' LIMIT 9" ; //category = category_name
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
                                        <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:140px;">
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
                                        <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                    </div>
                                    <?php 
                                }//end while
                            } //end if
                    ?>
                </div>
                <a href="fruit_tea.php" style="color:#b06548; text-decoration:none;">See More Fruit Tea</a>

            </section>
            </div>
        </div>
        <!-- END OF Fruit Tea  MENU -->
    

    <!--
    <section id="pagination" class="section-p1">
        <a class="active" href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="fa-solid fa-angle-right"></i></i></a>
    </section> -->
    
</body>

<?php include('footer.php');?>



    