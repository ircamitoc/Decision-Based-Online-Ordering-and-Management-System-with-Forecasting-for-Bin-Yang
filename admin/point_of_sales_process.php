<?php 
    include('db_connection.php');

    
    function dateTimeToReadableDate($date){
        if($date=='0000-00-00 00:00:00' || $date ==null){
            $new_date='';
        }else{
            $date = date_create($date);
            $new_date =  date_format($date, 'D, M j, Y G:i:s');
        }

        return $new_date;
    }

    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d h:i:s');

    // echo "order_id: ".$_SESSION['order_id'];
    // unset($_SESSION['order_id']);
    if(isset($_POST['insert_order_tbl'])){
         $senior_id_number     = $_POST['senior_id_number'];
         $order_discount     = $_POST['order_discount'];
         $order_amount       = $_POST['order_amount'];
         $order_payment      = $_POST['order_payment'];
         $order_change       = $_POST['order_change'];
         $notes              = $_POST['notes'];
         $system_msg         ='';

        //insert sa order_tbl
        $order_query  = "INSERT INTO order_tbl (order_by,order_discount,order_amount,order_payment,order_change,order_date,updated_at,order_status,payment_method,order_message,discount_id_number) 
        VALUES('$session_username', '$order_discount', '$order_amount','$order_payment','$order_change','$date','$date','delivered','$session_username','$notes','$senior_id_number') ";
        if (!mysqli_query($db, $order_query)) {
            $system_msg .= 'Error insert order: '.mysqli_error($db);
        }else{

            $system_msg .= 'new order, ';
            $order_id = mysqli_insert_id($db);
            $_SESSION['order_id'] = $order_id;
            $session_order_id = $_SESSION['order_id'];

            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
            VALUES('$user_id', 'POS_checkout','$description')";
            mysqli_query($db, $activity_sql);

        }

        $data = [
            'inserted_order_id' =>  $order_id,
            'system_msg' =>  $system_msg,
        ];

        echo json_encode($data); die();


    }

    if(isset($_POST['insert_point_of_sales'])){
        // echo "insert_point_of_sales<br>";
        $product_id         = $_POST['product_id'];
        $availed_product    = $_POST['availed_product'];
        $availed_quantity   = $_POST['availed_quantity'];
        $inserted_order_id  = $_POST['inserted_order_id'];

        $order_discount     = $_POST['order_discount'];
        $order_amount       = $_POST['order_amount'];
        $order_payment      = $_POST['order_payment'];
        $order_change       = $_POST['order_change'];
        $notes              = $_POST['notes'];
        $system_msg         ='';

        //get product info 
        $product_price_check_query = "SELECT product_price FROM products_tbl WHERE product_id='$product_id' LIMIT 1";
        $result_price = mysqli_query($db, $product_price_check_query);
        $product_price_row = mysqli_fetch_assoc($result_price);
        $availed_price = $product_price_row['product_price'];
        $availed_amount = $availed_price * $availed_quantity;

        // add insert sa availed tbl
        $availed_query  = "INSERT INTO availed_product_tbl (availed_product,availed_price,availed_quantity,availed_amount,order_id) 
        VALUES('$availed_product','$availed_price','$availed_quantity','$availed_amount','$inserted_order_id') ";
        if (!mysqli_query($db, $availed_query)) {
            $system_msg .= 'Error add insert availed: '.mysqli_error($db);
        }else{
            $system_msg .= 'add insert availed, ';
            $inserted_availed_id = mysqli_insert_id($db);

            //deduct the quantity to the actual db count.
            $product_quantity_check_query = "SELECT product_quantity FROM products_tbl WHERE product_id='$product_id' LIMIT 1";
            $result_quantity = mysqli_query($db, $product_quantity_check_query);
            $product_quantity_row = mysqli_fetch_assoc($result_quantity);
            $current_quantity = $product_quantity_row['product_quantity'];
            $updated_quantity = $current_quantity - $availed_quantity;

            $sql = "UPDATE products_tbl SET product_quantity='$updated_quantity' WHERE product_id='$product_id' ";
            if (mysqli_query($con, $sql)) {
                $system_msg .= 'Product Quantity Has Been Updated. , ';
            }else{
                $system_msg .= 'Error Product Quantity Update: , '.mysqli_error($db);
            }
        }

        $data = [
            // 'availed_price' =>  $availed_price,
            // 'insert_point_of_sales' =>  $_POST['insert_point_of_sales'],
            'inserted_order_id' => $inserted_order_id,
            'inserted_availed_id' => $inserted_availed_id,
            'system_msg' =>  $system_msg,
        ];

        echo json_encode($data); die();

    }


    if(isset($_POST['insert_add_ons'])){
        $availed_product    = $_POST['availed_product'];
        $inserted_order_id  = $_POST['inserted_order_id'];
        $inserted_availed_id    = $_POST['inserted_availed_id'];
        $availed_add_ons    = $_POST['availed_add_ons'];
        $add_ons_price    = $_POST['availed_add_ons_price'];
        $availed_quantity    = $_POST['availed_quantity'];

        $add_ons_price = $add_ons_price * $availed_quantity;

        // add insert sa add-ons tbl
        $add_ons_query  = "INSERT INTO add_ons_tbl (add_ons,add_ons_price,product,order_id,availed_id) 
        VALUES('$availed_add_ons','$add_ons_price','$availed_product','$inserted_order_id','$inserted_availed_id') ";
        if (!mysqli_query($db, $add_ons_query)) {
            $system_msg .= 'Error add insert availed: '.mysqli_error($db);
        }else{
            $system_msg .= 'Add insert availed add-ons, ';
            $inserted_add_ons_id = mysqli_insert_id($db);
        }

        $data = [
            'inserted_add_ons_id' => $inserted_add_ons_id,
            'system_msg' =>  $system_msg,
        ];

        echo json_encode($data); die();


    }

    //all search
	if(isset($_POST['search'])){
		$search = $_POST['search'];
		
        $sql = "SELECT * 
                FROM products_tbl 
                WHERE product LIKE '%".$search."%'
                OR category LIKE '%".$search."%' ";

        if(strlen($search)>1){
            $allSearch = mysqli_query($db,$sql);
            if ($allSearch->num_rows>0) {
                while($row = $allSearch->fetch_assoc()){
                    $product_id=$row['product_id'];
                    $product = $row['product'];
                    $product_price = $row['product_price'];
                    $product_quantity = $row['product_quantity'];
                    $product_image = $row['product_image'];
                    $category = $row['category'];
    
                    //check for 1 decimal convert into two using number_format();.
                    $checkWithOneDecimal = strlen(substr(strrchr($product_price, "."), 1));
                    if ($checkWithOneDecimal==true) {
                        $product_price = number_format($product_price,2);
                    }else{
                        $product_price = number_format($product_price,0);
                    }
    
                    if($product==""){
                        $product = "Lorem, ipsum dolor.";
                    }else{
                        $product = $row['product'];
                    }
    
                    echo '
                        <div class="pro m-1">
                            <div class="des">
                                <span>'.$product.'</span><br>
                                <span>Quantity: '.$product_quantity .'</span>
                                <h4>'.$product_price.'</h4>
                            </div>
                            <input type="hidden" value="'.$product_id.'" >
                            <input type="hidden" value="'.$product.'" >
                            <input type="hidden" value="'.$product_price.'" >
                            <a href="#add_to_cart" class="normal " id="add_to_cart_p1"  data-toggle="modal" data-target="#coffee-add-ons-modal"><i class="fas fa-plus cart"></i></a>
                        </div>
                    ';
                    //<a href="#add_to_cart" data-id="product_id'.$product_id.'"><i class="fas fa-plus cart"></i></a>
                }
            }
        }else{
            echo "";
        }

        // echo $search;
	}
	if(isset($_POST['get_add_ons_details'])){
        $add_ons_id = $_POST['add_ons'];
        $add_ons_details_query = "SELECT * FROM add_ons_list_tbl WHERE add_ons_list_id=$add_ons_id LIMIT 1";
        $add_ons_details_result = mysqli_query($db, $add_ons_details_query);
        $add_ons_details_row = mysqli_fetch_assoc($add_ons_details_result);

        $add_ons_name = $add_ons_details_row['add_ons'];
        $add_ons_price = $add_ons_details_row['add_ons_price'];

        $json_data = [
            'add_ons_name' => $add_ons_name,
            'add_ons_price' => $add_ons_price,
        ];

        echo json_encode($json_data);

	}

    

?>