<?php include('header.php');?>

 <!-- CATEGORY Cheese cake --> 
 <section id="product1" class="section-p1" style="margin-top:60px;">
        <h2>Coffee</h2>
        <!-- <div class="pro-container" onclick="window.location.href='sproduct.php';"> -->
        <div class="pro-container "  >
            <?php 
                	$product_list = "SELECT * FROM products_tbl WHERE category = 'cheesecake'"; //category = category_name
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
                                <a href="sproduct.php?id=<?=$product_id?>"><i class="fa-solid fa-cart-shopping cart"></i></a>
                            </div>
                            <?php 
                        }//end while
                    } //end if
            ?>
        </div>
    </section>
        <section id="product1" class="section-p1">
                    <h3>Featured Products</h3>
                    <div class="pro-container">
                        <div class="row justify-content-center">
                            <div class="col-3">
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
                            <div class="col-3">
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
                            <div class="col-3">
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
                        
                            <div class="col-3">
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
                            <div class="col-3">
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

                            <div class="col-3">
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
                            <a href="menu.php" style="color:#b06548; text-decoration:none;">Back to Main Menu</a>
                    </div>
                   
                </section>
      
            
    
</body>

<?php include('footer.php');?>