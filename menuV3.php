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
    <!-- CATEGORY1 --> 
    <div style="margin-top:100px;"></div>
    <div id="added_to_cart">Added to Cart</div>

    <?php 
        $category_list = "SELECT * FROM category_tbl WHERE is_active=1 ";
        $categroy_result_list = $con->query($category_list);
        if ($categroy_result_list->num_rows>0) {
            $category_array_list_checker_for_add_ons_modal_display = [];
            while ($category_row = $categroy_result_list->fetch_assoc()){ 
                $category = $category_row['category'];

               ?>

                <section id="product1" class="section-p1  " >
                    <h2 class='' id="coffee_section"><?= $category ?></h2>
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
                                                <img src="admin/assets/img/<?=$product_image?>" alt="" style="width:100%;height:200px;">
                                                <div class="des">
                                                    <span><?= substr($row['product'], 0, -4)?>  </span>
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
                                                </div>
                                                    <input type="hidden" value="<?= $row['category'] ?>">
                                                    <input type="hidden" value="<?= $product ?>">
                                                    <?php if(!isset($_SESSION['username'])):?>
                                                        <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                                    <?php else:?>
                                                        <a href="#add_to_cart" class="normal mt-5" id="add_to_cart_sizes" data-bs-toggle="modal" data-bs-target='#display-product-sizes-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
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
                                                
                                                <input type="hidden" value="<?=$row['product_id']?>" id="product_id" class="product_id">
                                                <input type="hidden" value="<?=$row['product']?>" id="product">
                                                <input type="hidden" value="<?=$row['product_price']?>" id="product_price">
                                                <?php if(!isset($_SESSION['username'])):?>
                                                    <a href="#login" class="normal" id="add_to_cart_login"><i class="fa-solid fa-cart-shopping cart"></i></a>
                                                <?php else:?>
                                                    <?php 
                                                        $add_hypen_for_add_ons_modal =  str_replace(" ", "-", $category);
                                                    ?>
                                                    <a href="#add_to_cart" class="normal" id="add_to_cart_p1" data-toggle='modal' data-target='#<?=$add_hypen_for_add_ons_modal?>-add-ons-modal'><i class="fa-solid fa-cart-shopping cart"></i></a>
                                                <?php endif;?>
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
                                                            <h4 class="modal-title "><?=$category?> - ADD ONS</h4>
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
                                                            <label for="">Quantity</label>
                                                            <input class="form-control w-50 " type="number" value="1" class="order_quantity p-2"  oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                                            <div id="subtotal" class="d-flex justify-content-center " style="border:0;margin:0;padding:0;">
                                                                <button type="button" class="normal mx-1" data-dismiss="modal" >Cancel</button>
                                                                <input type="hidden" value="" id="product_id_modal" class="product_id_modal">
                                                                <input type="hidden" value="" id="product_modal" class="product_modal">
                                                                <input type="hidden" value="" id="product_price_modal">
                                                                <!-- <a href="#coffee_add_ons_modal" id="add_to_cart" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-cart-shopping cart"></i> Add to Cart</a> -->
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
            var product_quantity = $(this).parent().prev().val();
            // console.log(product_id);
            // console.log(product);
            // console.log(product_quantity);

            // var add_ons_array = [];
            // var add_ons='';
            // $('.add_ons:radio:checked').each(function (e) {
            //     console.log(this.value);
            //     // add_ons_array.push(this.value);
            //     add_ons +=this.value+',';
            // });
            // console.log(add_ons_array);
            // add_ons = add_ons.slice(0, -1);
            // console.log($('.add_ons:radio:checked').val());
            // console.log(add_ons);
            var add_ons=$('.add_ons:radio:checked').val();
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
                    // console.log(response); //for debug
                    var obj = JSON.parse(response);
                    console.log(obj.check_with_add_ons);
                    obj.get_products.forEach(element => {
                        var get_product_id = element[0];
                        var get_product_name = element[1];
                        var get_product_price = element[2];
                        var get_product_image = element[3];
                        var get_product_category = element[4];
                        // console.log('product: ' + get_product_name);
                        // console.log('image: '+element[3]);

                        category =  category.replace(/\s+/g, '-');
                        
                        if(obj.check_with_add_ons==1){
                            $('#sizes-body').append(
                                `
                                    <div class="pro m-4">
                                        <img src="admin/assets/img/`+element[3]+`" alt="" style="width:100%;height:200px;">
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
                                        <img src="admin/assets/img/`+element[3]+`" alt="" style="width:100%;height:200px;">
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
                                            <a href="#add_to_cart" class="normal " id="add_to_cart"  ><i class="fa-solid fa-cart-shopping cart"></i></a>
                                        </div>         
                                    </div>
                                `
                            );
                        }

                        // <a href="#add_to_cart" class="normal " id="add_to_cart_p1"  data-toggle="modal" data-target="#`+category+`-add-ons-modal"><i class="fa-solid fa-cart-shopping cart"></i></a>

                    });

                    
                }
            });
        });

        $(document).on('click','.close-size', function  (e) {
            $('#sizes-body').html('');
        });

        $(document).on('click','.cart', function  (e) {
            console.log('cart');
            $('.no_add_ons').prop('checked', true);
        });

        


        

    });

</script>



    