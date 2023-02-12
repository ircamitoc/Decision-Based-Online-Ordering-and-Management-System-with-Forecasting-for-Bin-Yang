
<?php include('header.php');?>
<?php 
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $product_list = "SELECT * FROM products_tbl WHERE product_id=$id AND is_active=1";
        $result = $con->query($product_list);
        $row = $result->fetch_assoc();
        $product_quantity=$row['product_quantity'];
    }
?>
    
    <!-- DETAILS -->
    <section id="prodetails" class="section-p1">
    <div class="single-pro-image">
        <img src="admin/assets/img/<?= $row['product_image'] ?>" width="100%" id="MainImg" alt="">
    </div>
    
    <div class="single-pro-details">
        <h3><?= strtoupper($row['category']) ?></h3>
        <h3><?= $row['product']?></h3>
        <h4>₱<?= $row['product_price'] ?></h4>
        
        <!-- <form action="process.php" method="POST"> -->
            <input type="hidden" value="<?=$row['product_id']?>" id="product_id">
            <input type="hidden" value="<?=$row['product']?>" id="product">
            <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
            <input type="number" value="1" name="quantity" id="quantity" class="form-control mb-2" style="width:80px;" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" max="<?=$product_quantity?>">
            <h5 id="total_price"></h5>
            <?php if(!isset($_SESSION['username'])):?>
                <button type="submit" name="add_to_cart"  class="normal" id="add_to_cart_login" >Add To Cart </button>
            <?php else:?>
                <button type="submit" name="add_to_cart"  class="normal" id="add_to_cart" >Add To Cart</button>
            <?php endif;?>
        <!-- </form> -->

        
    </div>
    </section>

   


    <!-- FEATURED MENU -->
    <section id="product1" class="section-p1">
    <h2>Related Products</h2>
        
        <div class="pro-container" onclick="window.location.href='sproduct.html';">
    <?php 
                    $category = $row['category'];
                	$product_list = "SELECT * FROM products_tbl WHERE product_id!=$id AND category = '$category' ORDER BY RAND() LIMIT 4" ; //category = category_name
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
                    <span><?= $product ?></span>
                    <div class="star">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <h4>₱<?= $row['product_price'] ?></h4>
                </div>
                <a href="#"><i class="fa-solid fa-cart-shopping cart"></i></a>
            </div>

            <?php 
                        }//end while
                    } //end if
            ?>
        </div>
    </section>

   
 

</body>

<?php include('footer.php');?>

   
    <!-- SWITCHING IMAGES -->
    <script>
        

        var MainImg = document.getElementById("MainImg");
        var smallimg = document.getElementsByClassName("small-img");

        smallimg[0].onclick = function(){
            MainImg.src = smallimg[0].src;
        }

        smallimg[1].onclick = function(){
            MainImg.src = smallimg[1].src;
        }

        smallimg[2].onclick = function(){
            MainImg.src = smallimg[2].src;
        }

        smallimg[3].onclick = function(){
            MainImg.src = smallimg[3].src;
        }



    </script>

    <!-- <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script> -->

    <script>

        $(document).ready(function () {
            $(document).on('click','#add_to_cart', function  (e) {
                e.preventDefault();
                var product_id = $('#product_id').val();
                var product = $('#product').val();
                var product_quantity = $('#quantity').val();
                var max_product_quantity = $('#quantity').attr('max');
                console.log(max_product_quantity);
                if(product_quantity>max_product_quantity){
                    // console.log("You've reached the maximum quantity");
                    swal({
                        title: "You've reached the maximum quantity",
                        // text: "Once deleted, you will not be able to recover this user!",
                        icon: "info",
                        buttons: "OK",
                        dangerMode: true,
                    });
                    $('#quantity').val(max_product_quantity);
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
                                let popup = document.getElementById("popup");

                                popup.classList.add("open-popup");

                                $(document).on('click','#ok_cart', function  (e) {
                                    popup.classList.remove("open-popup");
                                });

                                var obj = JSON.parse(response);
                                $('#availed_count').text(obj.availed_count);
                                $('.hide_availed_count').attr('hidden',false);
                                // console.log("show add_to_cart");
                                // console.log(response);
                                // console.log(obj.availed_count);

                            }
                        }
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

            $(document).on('keyup','#quantity', function  (e) {
                // console.log('quantity')
                var max_product_quantity = $('#quantity').attr('max');
                // console.log(max_product_quantity);
                var total_price = 0 ;

              
                if($('#quantity').val()){
                    if(parseInt($('#quantity').val())>parseInt(max_product_quantity)){
                        swal({
                            title: "You've reached the maximum quantity",
                            // text: "Once deleted, you will not be able to recover this user!",
                            icon: "info",
                            buttons: "OK",
                            dangerMode: true,
                        });
                        $('#quantity').val(max_product_quantity);

                    }else{
                        total_price = parseFloat($('#quantity').val()) * parseFloat($('#product_price').val());
                        console.log(total_price);
                        $('#total_price').text("TOTAL: ₱"+total_price.toLocaleString());
                    }
                }else{
                    $('#quantity').val(1);
                    $('#total_price').text("TOTAL: ₱"+$('#product_price').val());

                }
                
            });
            
            
        });
    </script>