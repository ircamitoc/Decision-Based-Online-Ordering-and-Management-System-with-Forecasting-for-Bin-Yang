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

       .j-orange-text {
            color: rgb(255,138,93);
        } 
    </style> 


     <!-- page HEADER -->
     <section id="page-header" class="cart-header">
        <h2>CHECKOUT</h2>
        <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p> -->
    </section>

    <!-- CART -->
    <section id="cart" class="section ">
        <div class="table-responsive">
            <table width="100%" class=' table table-hover'>
                <thead>
                    <tr>
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
                                    $get_product_image = $product_image['product_image'];
                                    ?>
                                    <tr id="table_row<?=$availed_id?>">
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
                                        <td ><?=$availed_quantity?></td>
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

    <!-- end of show order -jcabrieto -->

                   
    <!-- <tr>
        <td><a href=""><i class="fa-regular fa-circle-xmark"></i></a></i></td>
        <td><img src="img/products/f5.jpg" alt=""></td>
        <td>Scallop Sallad</td>
        <td>₱760</td>
        <td><input type="number" value="2"></td>
        <td>₱1520</td>
    </tr>

    <tr>
        <td><a href=""><i class="fa-regular fa-circle-xmark"></i></a></i></td>
        <td><img src="img/products/f7.jpg" alt=""></td>
        <td>Belgian Waffle</td>
        <td>₱470</td>
        <td><input type="number" value="2"></td>
        <td>₱940</td>
    </tr>

    <tr>
        <td><a href=""><i class="fa-regular fa-circle-xmark"></i></a></i></td>
        <td><img src="img/products/f2.jpg" alt=""></td>
        <td>Sashimi Toast</td>
        <td>₱1250</td>
        <td><input type="number" value="3"></td>
        <td>₱3750</td>
    </tr> -->

    <!-- COUPON SECTION -->
    <section id="cart-add" class="mt-5  d-flex justify-content-center"> <!-- section-p1 -->
        <!-- style="background:red;" -->
            <div id=""  class="w-100 " style="max-width:400px;"> 
           
                <h3 ><i class="fa-solid fa-location-dot j-orange-text" ></i> Delivery Address</h3>

                <div class="form-outline mb-3" style="margin:0;">
                <label class="form-label" style="margin:0;" >Street Address (Street, Floor/Unit/Room #)</label>
                <input type="text"  class="form-control form-control-lg Street" required style="margin:0;" oninput="this.value = this.value.replace(/[^0-9.a-zA-Z ]/g, '').replace(/(\..*)\./g, '$1');"/>
                </div>

                <div class="form-outline mb-3" style="margin:0;">
                <label class="form-label" style="margin:0;" >Landmark (optional)</label>
                <input type="text"  class="form-control form-control-lg Landmark"  style="margin:0;" oninput="this.value = this.value.replace(/[^0-9.a-zA-Z ]/g, '').replace(/(\..*)\./g, '$1');"/>
                </div>

                <div class="form-outline mb-3" style="margin:0;">
                <label class="form-label" style="margin:0;" >Town / City</label>
                <input type="text"  class="form-control form-control-lg Town"   required style="margin:0;" value ='Biñan City, Laguna' disabled/>
                </div>

                <div class="form-outline mb-3" style="margin:0;">
                <label class="form-label" style="margin:0;" >Country</label>
                <input type="text"  class="form-control form-control-lg Country"  required style="margin:0;" value ='Philippines' disabled/>
                </div>

                <div class="form-outline mb-3" style="margin:0;">
                <label class="form-label" style="margin:0;" >Postcode</label>
                <input type="text"  class="form-control form-control-lg Postcode"  required style="margin:0;" value ='4024' disabled/>
                </div>

                <div class="form-outline mb-3"  style='pointer-events:none;'>
                <!-- <input type="text" id="form2Example28" class="form-control form-control-lg" name="address"/> -->
                <label class="form-label" style="margin:0;" >Delivery Address</label>
                <textarea name="address" id="delivery_address" cols="30" rows="3" class="form-control form-control-lg" placeholder="Address"  style="resize: none;" required ><?=$session_user_address?></textarea>
                </div>

                <div class="form-outline mb-3" style="margin:0;">
                    <label class="form-label" style="margin:0;" >Message</label>
                    <textarea class="form-control" placeholder="(Optional) Leave a message to seller" id="message" style="width:100%;" id="" cols="30" rows="3" oninput="this.value = this.value.replace(/[^0-9.a-zA-Z ]/g, '').replace(/(\..*)\./g, '$1');"></textarea>
                </div>

                <!-- <h3 class="mt-2">Apply Coupon</h3>
                <div>
                    <input type="text" placeholder="Enter Your Coupon">
                    <button class="normal">Apply</button>
                </div> -->

                <div class="mt-5">
                    <label class="form-label" style="margin:0;" >Choose Payment Method</label><br>
                    <input type="radio" value="Cash-on-Delivery" name="payment_method"  id="COD" class="form-check-input" style="width:1px;padding:10px;" checked>
                    <label for="COD" class="form-check-label"><img src="admin/assets/img/cod-motor.png" width="100px"></label><br><br>
                    <input type="radio" value="Gcash" name="payment_method" id="Gcash"  class="form-check-input" style="width:2px;padding:10px;">
                    <label for="Gcash" class="form-check-label"><img src="admin/assets/img/GCash-Logo-Transparent-PNG-1.png" width="100px"></label>
                </div>

                <div id="subtotal" class=" mt-5" style="width:400px;" >
                    <label class="form-label" style="margin:0;" >Cart Total</label><br>
                    <table >
                        <tr>
                            <td>Subtotal</td>
                            <td class="order_amount">₱<?= number_format($order_amount - $delivery_fee, 2, ".", ",")?></td>
                        </tr>
                        <tr>
                            <td>Delivery Fee</td>
                            <td>₱<?=$delivery_fee?></td>
                        </tr>
                        <!-- <tr>
                            <td>Coupon</td>
                            <td></td>
                        </tr> -->
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><Strong class="order_amount">₱<?= number_format($order_amount, 2, ".", ",")?></Strong></td>
                        </tr>
                    </table>

                    <button type="submit" class="normal" name="place_order" id="place_order">Place order</button>
                </div>
                
            </div>

           

                

            
    </section>

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
        });
        
        $(document).on('click','#decrease_quantity', function  (e) {
            
            var get_input_quantity_id = $(this).next().attr('id');
            var get_availed_id_number = get_input_quantity_id.replace(/[^\d.-]/g, '');
                console.log("#availed_quantity"+get_availed_id_number);
                console.log($("#availed_quantity"+get_availed_id_number).val());
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
                            $('.order_amount').text("₱"+obj.new_availed_amount);
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

        $(document).on('click','#place_order', function  (e) {
            // console.log(place_order);

            // console.log($('input[name="payment_method"]:checked').val());


            var delivery_address = $('#delivery_address').val().toLowerCase();
            var message = $('#message').val();
            var payment_method = $('input[name="payment_method"]:checked').val();
            //check if biñan;
            if(delivery_address!=''){

                var check_location_1 = delivery_address.includes("biñan");
                var check_location_2 = delivery_address.includes("binan");
                if(check_location_1==true || check_location_2==true){
                    $.ajax({
                        method: "POST",
                        url: "process.php",
                        data: {
                            'place_order' : 1,
                            'delivery_address':delivery_address,
                            'message':message,
                            'payment_method' : payment_method,
                        },
                        success: function (response) {
                            // console.log(response); //for debug
                            // var obj = JSON.parse(response);
                            // $('#availed_count').val(obj.Remove_product); // set notif count
                            // $('#availed_amount'+get_availed_id_number).text(obj.availed_id);
                            // $('.order_amount').text("₱"+obj.new_availed_amount);
                            // $('#availed_count').text(obj.availed_count);
                            // if(obj.availed_count=="0"){
                            //     $('.hide_availed_count').attr('hidden',true);
                            // }
                           
                            swal({
                                title: "Thank you",
                                text: "Your order has been placed.",
                                icon: "success",
                                // buttons: true,
                                dangerMode: true,
                            }).then((willDelete) => {
                                if (willDelete) {
                                   
                                    window.location="profile.php";
                                    console.log(response);
                                } 
                                
                            });
                        }
                    });
                }else{
                    
                    swal({
                        title: "",
                        text: "Your place is out of reach for Bin Yang Coffee & Tea. Sorry for the inconvenience.",
                        icon: "warning",
                        // buttons: true,
                        dangerMode: true,
                    });
                }
            }else{
                swal({
                    title: "No Delivery Address",
                    // text: "Once deleted, you will not be able to recover this product!",
                    icon: "warning",
                    // buttons: true,
                    dangerMode: true,
                });
            }
            
        });

        $('.Street, .Landmark').on('keyup',function (e) {
            console.log('street');
            $('#delivery_address').text(
            $('.Street').val()+" "+
            $('.Landmark').val()+" "+
            $('.Town').val()+" "+
            $('.Country').val()+" "+
            $('.Postcode').val()+" "
            );
        });


    }); // end of jqdoc
</script>
