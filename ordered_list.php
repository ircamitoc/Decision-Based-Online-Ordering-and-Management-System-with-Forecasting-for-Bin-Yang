<?php include('header.php');
if(!isset($_SESSION['username'])){
  echo '<script> 
      alert("please login");
      window.location = "login.php";
  </script> '; 
}
?>
<!--Buy again page 09/30/2022
    Order history of the user
-->
<section id="product1" class="section-p1  " >
    <div class="row justify-content-start">
        <div class="col-4"><a href="profile.php"><i class="fa fa-arrow-left fa-2xl" style="color:#b06548;" aria-hidden="true"></i></a></div>
        <div class="col-4"><h2 style="color:#b06548;">Buy Again</h2></div>
    </div>
        
        <!-- <div class="pro-container" onclick="window.location.href='sproduct.php';"> -->
        <div class="pro-container "  >
            <?php 
                	$product_list = "SELECT * FROM products_tbl WHERE category = 'coffee'"; //category = category_name
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
                                <img src="admin/assets/img/<?=$product_image?>" alt="">
                                <div class="des">
                                    <span><?= $product ?>(6) <!--how many times purchased--> </span>
                                    <!--boss opinion lang pwede siguro tong rate palitan nlng ng Like tapos heart logo tapos limit 1like per user per product-->
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

    <!-- CALL TO ACTION BANNER -->
    <section id="banner" class="section-m1">
        <h4>Special Coupon Offer!</h4>
        <h2>Up to <span>40% Off</span> Id velit velit est exercitationem esse!</h2>
        <button class="normal">Explore More</button>
    </section>



</body>
<?php include('footer.php');?>