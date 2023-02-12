<?php 
    include('admin/db_connection.php');
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d G:i:s");
    // $price = 0 ;
    // $price +=1;
    // echo $price;

    //  test
        // use of explode
        // $string = "123,46,78,000";
        // $str_arr = explode (",", $string); 
        // print_r($str_arr);
        // foreach ($str_arr as $key => $value) {
        //     echo "<br>";
        //     echo $value;
        //     echo "<br>";
        // }
    // end of test


    // REGISTER USER
    if (isset($_POST['submit_register'])) {
        // receive all input values from the form
        $username=mysqli_real_escape_string($db, $_POST['email']);
        $password=mysqli_real_escape_string($db, $_POST['password']);
        $password2=mysqli_real_escape_string($db, $_POST['password2']);
        $mobile=mysqli_real_escape_string($db, $_POST['mobile']);
        $fullname=mysqli_real_escape_string($db, $_POST['name']);
        $address=mysqli_real_escape_string($db, $_POST['address']);
        $access_level='Customer';

        if($password==$password2){

            if(strpos(strtolower($address), 'binan') !== false || strpos(strtolower($address), 'biñan') !== false){ //true
                
                // first check the database to make sure 
                // a user does not already exist with the same username and/or email
                $user_check_query = "SELECT * FROM users_tbl WHERE username='$username' LIMIT 1";
                $result = mysqli_query($db, $user_check_query);
                $user = mysqli_fetch_assoc($result);
                
                if ($user) { // if user exists
                    if ($user['username'] === $username) {
                    echo '<script> 
                            alert("Username is already taken.");
                            window.location = "register.php";
                        </script> '; 
                    } 
                }else{

                    #file name with a random number so that similar dont get replaced
                    $filename = rand(1000,10000)."-".$_FILES["image"]["name"];
                    #temporary file name to store file
                    $tname = $_FILES["image"]["tmp_name"];
                    #to move the uploaded file to specific location
                    move_uploaded_file($tname,'admin/assets/img/'.$filename);

                    // Finally, register user if there are no errors in the form
                    $password = password_hash($password, PASSWORD_DEFAULT);//encrypt the password before saving in the database
                    $query = "INSERT INTO users_tbl (username,password,access_level,date_created,user_image,full_name,mobile,`address`) 
                            VALUES('$username', '$password', '$access_level', NOW(),'$filename','$fullname','$mobile','$address')";
                
                    if(!mysqli_query($db, $query)){
                        echo("Error description: " . mysqli_error($db));
                            echo '<script> 
                                alert("mysqli_error..."'.mysqli_error($db).');
                                window.location = "register.php";
                            </script> '; 
                    }else{
                        session_start();
                        $_SESSION['username'] = $username;
                        // echo $_SESSION['username'];
                        $user_id = mysqli_insert_id($db);
                        $description = " ";
                        // $description .= " user_ip: " . $_SERVER['REMOTE_ADDR'] . ", ";
                        $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
                        $_POST['user_id'] = $user_id;
                        $description .= json_encode($_POST);
                        $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
                        VALUES('$user_id', 'register','$description')";
                        mysqli_query($db, $activity_sql);

                        echo '	<script> 
                                    alert("Registration successful.");
                                    window.location = "index.php";
                                </script> '; 
                    }
                }
            }else{
                echo '	<script> 
                    alert("Your place is out of reach for Bin Yang Coffee & Tea. Sorry for the inconvenience.");
                    window.location = "register.php";
                </script> ';
            }

        }else{
            echo '	<script> 
                        alert("The password did not match.");
                        window.location = "register.php";
                    </script> ';
        }

    } // end of register


    // LOGIN USER
  	if(isset($_POST['submit_login'])){
        $username = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if (empty($username)) {
        echo '<script> 
                alert("Email is required")
                window.location = "login.php";
        </script> '; 
        }
        
        if (empty($password)) {
        echo '<script> 
            alert("Password is required")
            window.location = "login.php";
        </script> '; 
        }

        //  if(!ctype_alnum($username)){
        //      echo '<script> 
        //        alert("@Username, Alphanumeric characters are only allowed.")
        //        window.location = "login.php";
        //    </script> '; 
        //    }
        //    if(!ctype_alnum($password)){
        //          echo '<script> 
        //            alert("@Password, Alphanumeric characters are only allowed.")
        //            window.location = "login.php";
        //        </script> '; 
        //    }

        $query = "  SELECT * 
                    FROM users_tbl 
                    WHERE username='$username' ";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_array($result);
        if(password_verify($password, $row['password'])){
            // session_start();
            $_SESSION['username'] = $username;

            $description = " ";
            $user_id = $row['user_id'];
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $row['user_id'];
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
            VALUES('$user_id', 'customer_login','$description')";
            mysqli_query($db, $activity_sql);

            echo '<script> 
                window.location = "/";
                </script> ';
        }else{
            // session_start();
                $_SESSION['usernameLogin'] = $username;
            echo '<script>
                    alert("Wrong username/password combination.1");
                    window.location = "login.php";
            </script> ';
        }
        }else{
        // session_start();
        $_SESSION['usernameLogin'] = $username;
        echo '<script> 
            alert("Wrong username/password combination.2")
            window.location = "login.php";
        </script> ';
        }
    }// end of login
    



    if(isset($_POST['add_to_cart'])){
        $product_id = $_POST['product_id'];
        $product = $_POST['product'];
        $product_quantity = $_POST['product_quantity'];
        $add_ons = $_POST['add_ons'];

        $delivery_fee_query = "SELECT delivery_fee FROM delivery_fee_tbl";
        $delivery_fee_query_run = mysqli_query($con, $delivery_fee_query);
        $delivery_fee_query_row=mysqli_fetch_array($delivery_fee_query_run);
        $delivery_fee = $delivery_fee_query_row['delivery_fee'];
        // $delivery_fee = 75;

        // $add_ons_prices_array = array(
        //     "ExtraShot"=>"20",
        //     "Vanilla"=>"20",
        //     "Hazelnut"=>"20",
        //     "Caramel"=>"20",
        //     "ColdFoam"=>"20",
        //     "Cheesecake"=>"20",
        //     "Pearl"=>"15",
        //     "Crystal"=>"15",
        //     "Oreo"=>"15",
        //     "FruitJelly"=>"15",
        //     "PoppingBoba"=>"15",
        // );

        $system_msg='';

        if($product_id==""){
            $system_msg .= "invalid input";
            
            $data = [
                'system_msg' =>  $system_msg,
            ];

            echo json_encode($data); die();
        }else{

            //check if user has existing order
            $check_order_query = "SELECT * FROM order_tbl WHERE order_by='$session_username' AND order_status='on-going' LIMIT 1";
            $order_result = mysqli_query($db, $check_order_query);
            $order = mysqli_fetch_assoc($order_result);

            if ($order) { // if on-going order exists

                //add nalang sa availed_product_tbl
                //fetch product details via id
                $product_query = "SELECT * FROM products_tbl WHERE product_id='$product_id' AND is_active=1 LIMIT 1";
                $product_result = mysqli_query($db, $product_query);
                $product_row = mysqli_fetch_assoc($product_result);
                $product= $product_row['product'];
                $product_price=$product_row['product_price'];
                $availed_amount=$product_price*$product_quantity;

                $order_id = $order['order_id'];

                $query_availed_product = "  INSERT INTO availed_product_tbl 
                                            (availed_product,availed_price,availed_quantity,availed_amount,order_id) 
                                            VALUES('$product','$product_price','$product_quantity','$availed_amount','$order_id')
                                        ";
                if(!mysqli_query($db, $query_availed_product)){
                    $system_msg .= "query availed product failed "  . mysqli_error($db);
                }else{
                    $availed_id = mysqli_insert_id($db);

                    if($add_ons!=""){
                        // $add_ons_array = explode (",", $add_ons); 
                        // foreach ($add_ons_array as $value) {
                        //     $add_ons_price = $add_ons_prices_array[$value];

                        // get add_ons_details
                        $add_ons_check_query = "SELECT * FROM add_ons_list_tbl WHERE add_ons_list_id='$add_ons' LIMIT 1";
                        $add_ons_check_result = mysqli_query($db, $add_ons_check_query);
                        $add_ons_check_row = mysqli_fetch_assoc($add_ons_check_result);
                        $add_ons_name = $add_ons_check_row['add_ons'];
                        $add_ons_price = $add_ons_check_row['add_ons_price'];
                        $add_ons_price *= $product_quantity;
                        $query_availed_add_ons = "  INSERT INTO add_ons_tbl 
                                                    (add_ons,add_ons_price,product,order_id,availed_id) 
                                                    VALUES('$add_ons_name',$add_ons_price,'$product','$order_id','$availed_id')
                                                ";
                        if(!mysqli_query($db, $query_availed_add_ons)){
                            $system_msg .= "query availed add ons failed "  . mysqli_error($db);
                        }
                        // }
                    }

                    //get total availed products
                    $check_availed_query = "SELECT * FROM availed_product_tbl WHERE order_id='$order_id'";
                    $availed_result = $con->query($check_availed_query);
                    if($availed_result->num_rows>0){
                        $order_amount=0;
                        while($row=$availed_result->fetch_assoc()){
                            $order_amount+=$row['availed_amount'];
                        }
                    }

                    //get total add_ons 
                    $add_ons_amount=0;
                    $check_availed_add_ons_query = "SELECT * FROM add_ons_tbl WHERE order_id='$order_id' ";
                    $availed_add_ons_result = $con->query($check_availed_add_ons_query);
                    if($availed_add_ons_result->num_rows>0){
                        $add_ons_amount=0;
                        while($row=$availed_add_ons_result->fetch_assoc()){
                            $add_ons_amount+=$row['add_ons_price'];
                        }
                    }

                    $order_amount+=$add_ons_amount;

                    $order_amount+=$delivery_fee;

                    //update order_tbl
                    $query_update_order = "UPDATE order_tbl SET order_amount='$order_amount'  WHERE order_id='$order_id' ";
                    if (!mysqli_query($db, $query_update_order)) {
                        $system_msg .= "query update order failed " . mysqli_error($db);
                    }else{
                        // echo "added to cart";

                        $order_list = " SELECT *, COUNT(*) AS availed_count
                                            FROM order_tbl
                                            LEFT JOIN availed_product_tbl
                                            ON order_tbl.order_id = availed_product_tbl.order_id
                                            WHERE order_status = 'on-going' 
                                            AND order_by='$session_username' "; 
                        $result_list = $con->query($order_list);
                        if ($result_list->num_rows>0) {
                            while ($row = $result_list->fetch_assoc()){ 
                                // echo $availed_count = $row['availed_count'];
                                $data = [
                                    'availed_count' =>  $row['availed_count'],
                                    'system_msg' => $system_msg,
                                ];

                                echo json_encode($data); die();
                            }
                        }
                    }
                    
                }


                    

            }else{
                //insert order
                $query_order = "INSERT INTO order_tbl (order_by,order_status,order_date) VALUES('$session_username','on-going','$date')";
                if(!mysqli_query($db, $query_order)){
                    $system_msg .= "query order failed " . mysqli_error($db);
                }else{
                    $order_id = mysqli_insert_id($db);

                    $product_query = "SELECT * FROM products_tbl WHERE product_id='$product_id' AND is_active=1 LIMIT 1";
                    $product_result = mysqli_query($db, $product_query);
                    $product_row = mysqli_fetch_assoc($product_result);
                    // $product=$product_row['product'];
                    $product=str_replace("'", "\'", $product_row['product']);

                    $product_price=$product_row['product_price'];
                    $availed_amount=$product_price*$product_quantity;

                    $query_new_availed_product = "  INSERT INTO availed_product_tbl 
                                                    (availed_product,availed_price,availed_quantity,availed_amount,order_id) 
                                                    VALUES('$product','$product_price','$product_quantity','$availed_amount','$order_id')
                    ";
                    if(!mysqli_query($db, $query_new_availed_product)){
                        $system_msg .= "query new availed product failed " . mysqli_error($db);
                    }else{

                        $availed_id = mysqli_insert_id($db);

                        if($add_ons!=""){
                            $add_ons_check_query = "SELECT * FROM add_ons_list_tbl WHERE add_ons_list_id='$add_ons' LIMIT 1";
                            $add_ons_check_result = mysqli_query($db, $add_ons_check_query);
                            $add_ons_check_row = mysqli_fetch_assoc($add_ons_check_result);
                            $add_ons_name = $add_ons_check_row['add_ons'];
                            $add_ons_price = $add_ons_check_row['add_ons_price'];
                            $add_ons_price *= $product_quantity;
                            $query_availed_add_ons = "  INSERT INTO add_ons_tbl 
                                                        (add_ons,add_ons_price,product,order_id,availed_id) 
                                                        VALUES('$add_ons_name',$add_ons_price,'$product','$order_id','$availed_id')
                                                    ";
                            if(!mysqli_query($db, $query_availed_add_ons)){
                                $system_msg .= "query availed add ons failed "  . mysqli_error($db);
                            }
                        }

                        //get total availed products
                        $check_availed_query = "SELECT * FROM availed_product_tbl WHERE order_id='$order_id'";
                        $availed_result = $con->query($check_availed_query);
                        if($availed_result->num_rows>0){
                            $order_amount=0;
                            while($row=$availed_result->fetch_assoc()){
                                $order_amount+=$row['availed_amount'];
                            }
                        }

                        //get total add_ons 
                        $add_ons_amount=0;
                        $check_availed_add_ons_query = "SELECT * FROM add_ons_tbl WHERE order_id='$order_id' ";
                        $availed_add_ons_result = $con->query($check_availed_add_ons_query);
                        if($availed_add_ons_result->num_rows>0){
                            $add_ons_amount=0;
                            while($row=$availed_add_ons_result->fetch_assoc()){
                                $add_ons_amount+=$row['add_ons_price'];
                            }
                        }

                        $order_amount+=$add_ons_amount;

                        $order_amount+=$delivery_fee;//add delivery fee

                        //update order_tbl
                        $query_update_order = "UPDATE order_tbl SET order_amount='$order_amount'  WHERE order_id='$order_id' ";
                        if (!mysqli_query($db, $query_update_order)) {
                            $system_msg .= "query update order failed " . mysqli_error($db);
                        }else{
                            // echo "new order";
                            $order_list = " SELECT *, COUNT(*) AS availed_count
                                            FROM order_tbl
                                            LEFT JOIN availed_product_tbl
                                            ON order_tbl.order_id = availed_product_tbl.order_id
                                            WHERE order_status = 'on-going' 
                                            AND order_by='$session_username' "; 
                            $result_list = $con->query($order_list);
                            if ($result_list->num_rows>0) {
                                while ($row = $result_list->fetch_assoc()){ 
                                    // echo $availed_count = $row['availed_count'];
                                    $data = [
                                        'availed_count' =>  $row['availed_count'],
                                        'system_msg' => $system_msg,
                                    ];

                                    echo json_encode($data); die();
                                }
                            }

                            $data = [
                                'system_msg' =>  $system_msg,
                            ];
                
                            echo json_encode($data); die();
                        }

                        $data = [
                            'system_msg' =>  $system_msg,
                        ];
            
                        echo json_encode($data); die();
                    }

                    $data = [
                        'system_msg' =>  $system_msg,
                    ];
        
                    echo json_encode($data); die();
                }

                $data = [
                    'system_msg' =>  $system_msg,
                ];
    
                echo json_encode($data); die();
            }
            $data = [
                'system_msg' =>  $system_msg,
            ];

            echo json_encode($data); die();
            
        }
        
        echo $add_ons;
        

    } // end of add to cart


    if(isset($_POST['Remove_product'])){
        $availed_id = $_POST['availed_id'];

        //get availed_amount from  availed_product_tbl
        $availed_query = "SELECT * FROM availed_product_tbl WHERE availed_id='$availed_id' LIMIT 1";
        $availed_result = mysqli_query($db, $availed_query);
        $availed_row = mysqli_fetch_assoc($availed_result);
        $order_id = $availed_row['order_id'];

        //get availed_amount from  availed_product_tbl
        $order_tbl_query = "SELECT * FROM order_tbl WHERE order_id='$order_id' AND order_by='$session_username' LIMIT 1";
        $order_tbl_result = mysqli_query($db, $order_tbl_query);
        $order_tbl = mysqli_fetch_assoc($order_tbl_result);
        $order_amount = $order_tbl['order_amount'];

        //get total add_ons 
        $add_ons_amount=0;
        $check_availed_add_ons_query = "SELECT * FROM add_ons_tbl WHERE availed_id='$availed_id'  ";
        $availed_add_ons_result = $con->query($check_availed_add_ons_query);
        if($availed_add_ons_result->num_rows>0){
            while($row=$availed_add_ons_result->fetch_assoc()){
                $add_ons_amount+=$row['add_ons_price'];
            }
        }

        //subtract availed_amount to order_amount from order_tbl
        $new_availed_amount = $order_amount - $availed_row['availed_amount'] - $add_ons_amount;
        $update_order_tbl_query = "UPDATE order_tbl SET order_amount='$new_availed_amount' WHERE order_id='$order_id' AND order_by='$session_username' ";
        if (!mysqli_query($db, $update_order_tbl_query)) {
            $system_msg = "query subtract availed_amount to order_amount from order_tbl failed: " . mysqli_error($db);
        }else{
            $system_msg = "Order table has been updated.";
        }

        $result = '';
        $remove_availed_id = "DELETE FROM availed_product_tbl WHERE availed_id='$availed_id' AND order_id='$order_id' ";
        $remove_result = mysqli_query($db,$remove_availed_id);
        if($remove_result==true){
            $result .= "Order has been removed ";
        }else{
            $result .= " Error: " . mysqli_error($db);
        }

        $remove_add_ons_id = "DELETE FROM add_ons_tbl WHERE availed_id='$availed_id' AND order_id='$order_id' ";
        $remove_result = mysqli_query($db,$remove_add_ons_id);
        if($remove_result==true){
            $result .= " Add ons has been removed";
        }else{
            $result .= " Error: " . mysqli_error($db);
        }

        //then select latest order_amount from order_tbl to display in cart.php
        $new_availed_amount;

        //get latest availed count
        $availed_count_query = "SELECT COUNT(*) AS availed_count  FROM availed_product_tbl WHERE order_id='$order_id' ";
        $availed_count_result = mysqli_query($db, $availed_count_query);
        $availed_count_row = mysqli_fetch_assoc($availed_count_result);

        $data = [
            "Remove_product" => $result,
            "availed_id" => $availed_id,
            "availed_row" => json_encode($availed_row),
            "availed_count" => $availed_count_row['availed_count'],
            "new_availed_amount" => $new_availed_amount,
            "msg" =>  $system_msg
        ];

        echo json_encode($data);

        
    }

    if(isset($_POST['place_order'])){
        // echo "place_order";
        // echo $session_username;
        // $delivery_fee=75;

        $order_tbl_query = "SELECT * FROM order_tbl WHERE order_by='$session_username' AND order_status='on-going' LIMIT 1";
        $order_tbl_result = mysqli_query($db, $order_tbl_query);
        $order_tbl_row = mysqli_fetch_assoc($order_tbl_result);

        if($order_tbl_row){ // if order_id exist
            $order_id = $order_tbl_row['order_id'];
            
            //update order_tbl to pending_request
            $order_id = $order_tbl_row['order_id'];
            $delivery_address = $_POST['delivery_address'];
            $message = $_POST['message'];
            $payment_method = $_POST['payment_method'];
            $order_amount = $order_tbl_row['order_amount'];

            $update_order_tbl_query = "UPDATE order_tbl SET order_status='pending',delivery_address='$delivery_address', order_message='$message', payment_method='$payment_method', order_amount='$order_amount' WHERE order_id='$order_id' AND order_by='$session_username' ";
            if (!mysqli_query($db, $update_order_tbl_query)) {
                $system_msg = "query to update order_status=pending on order_tbl, failed: " . mysqli_error($db);
            }else{
                $system_msg = "Order table has been updated.";
            }

            echo "system_msg: " . $system_msg ;

        }else{
            echo "You Don't Have Any Order" ;
        }

    }


    if(isset($_POST['Remove_All_Product'])){
        echo "Remove_All_Product";
        $order_tbl_query = "SELECT * FROM order_tbl WHERE order_by='$session_username' AND order_status='on-going' LIMIT 1";
        $order_tbl_result = mysqli_query($db, $order_tbl_query);
        $order_tbl_row = mysqli_fetch_assoc($order_tbl_result);

        if($order_tbl_row){ // if order_id exist
            $order_id = $order_tbl_row['order_id'];

            //delete sa availed table using order_id
            $remove_availed_id = "DELETE FROM availed_product_tbl WHERE order_id='$order_id'  ";
            $remove_result = mysqli_query($db,$remove_availed_id);
            if($remove_result==true){
                $result = "Orders have been removed";
            }else{
                $result = "Error: " . mysqli_error($db);
            }

            $remove_availed_add_ons_id = "DELETE FROM add_ons_tbl WHERE order_id='$order_id'  ";
            $remove_result = mysqli_query($db,$remove_availed_add_ons_id);
            if($remove_result==true){
                $result = "Orders have been removed";
            }else{
                $result = "Error: " . mysqli_error($db);
            }

        }

        echo $result;

    }


    if(isset($_POST['submit_message'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message_txt = $_POST['message_txt'];

        $query = "INSERT INTO message_tbl (`name`,`email`,`subject`,`message`) 
                        VALUES('$name', '$email', '$subject','$message_txt')";
            
        $system_msg='';
        if(!mysqli_query($db, $query)){
            $system_msg.= "Sending message failed: " . mysqli_error($db);
        }else{
            $system_msg="Message has been sent.";
        }

        $data = [
            'system_msg' =>  $system_msg,
        ];

        echo json_encode($data); die();
    }

    if(isset($_POST['edit_profile'])){
        $name = $_POST['name'];
        $mobile_number = $_POST['mobile_number'];
        $address = $_POST['address'];

        if(strpos($address, 'Biñan') !== false){ // if true
            if($_POST['get_filename']!="0"){
                #file name with a random number so that similar dont get replaced
                $filename = rand(1000,10000)."-".$_FILES["image"]["name"];
                #temporary file name to store file
                $tname = $_FILES["image"]["tmp_name"];
                #to move the uploaded file to specific location
                move_uploaded_file($tname,'admin/assets/img/'.$filename);

                $sql = "UPDATE users_tbl SET full_name='$name', mobile='$mobile_number', `address`='$address', user_image='$filename' WHERE user_id='$session_user_id' ";
            }else{
            
                $sql = "UPDATE users_tbl SET full_name='$name', mobile='$mobile_number', `address`='$address'  WHERE user_id='$session_user_id' ";
            }

            if (mysqli_query($con, $sql)) {

                //add logs
                $description = "";
                $user_id = $session_user_id;
                $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $_POST['user_id'] = $session_user_id;
                $description .= json_encode($_POST);
                $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
                VALUES('$user_id', 'update_profile','$description')";
                mysqli_query($db, $activity_sql);
    
                echo '	<script> 
                            alert("Update Profile Successful.");
                            window.location = "profile.php";
                        </script> '; 
            }else{


                echo '<script> 
                        alert("Error description: '. mysqli_error($conn) .'")
                        window.location = "profile.php";
                    </script> '; 
            }
        }else{
            echo '	<script> 
                alert("Your place is out of reach for Bin Yang Coffee & Tea. Sorry for the inconvenience.");
                window.location = "profile.php";
            </script> ';
        }
    }

    if (isset($_POST['rate_product'])) {
        echo "rate_product";
        $product_id = $_POST['rate_product_id'];
        $order_id = $_POST['rate_order_id'];
        $comment = $_POST['comment'];
        $ratings = $_POST['ratings'];
        
        #file name with a random number so that similar dont get replaced
        $filename = rand(1000,10000)."-".$_FILES["image"]["name"];
        #temporary file name to store file
        $tname = $_FILES["image"]["tmp_name"];
        #to move the uploaded file to specific location
        move_uploaded_file($tname,'admin/assets/img/'.$filename);


        $rate_product_query = "  
            INSERT INTO rates_tbl (product_id,order_id,comment,ratings,rating_image,rate_username) 
            VALUES('$product_id','$order_id','$comment','$ratings','$filename','$session_username')
        ";
        if(!mysqli_query($db, $rate_product_query)){
            $system_msg .= "query send rating failed "  . mysqli_error($db);
        }else{
            //add logs
            $description = "";
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
            VALUES('$session_user_id', 'Send Ratings','$description')";
            mysqli_query($db, $activity_sql);

            echo '	<script> 
                        alert("Send Rating Successful.");
                        window.location = "profile.php";
                    </script> '; 
        }
    }

    //upload proof of payment
    if(isset($_POST['upload_proof_of_payment'])){
        echo "upload_proof_of_payment";
        $order_id = $_POST['order_id'];

        #file name with a random number so that similar dont get replaced
        $filename = rand(1000,10000)."-".$_FILES["image"]["name"];
        #temporary file name to store file
        $tname = $_FILES["image"]["tmp_name"];
        #to move the uploaded file to specific location
        move_uploaded_file($tname,'admin/assets/img/'.$filename);


        $proof_of_payment_query = "UPDATE order_tbl SET proof_of_payment='$filename', payment_status='pending' WHERE order_id='$order_id' ";
        if(!mysqli_query($db, $proof_of_payment_query)){
            echo $system_msg .= "query send rating failed "  . mysqli_error($db);
        }else{
            //add logs
            $description = "";
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
            VALUES('$session_user_id', 'Send Proof of Payment','$description')";
            mysqli_query($db, $activity_sql);

            echo '	<script> 
                        alert("Proof of payment has been sent.");
                        window.location = "profile.php";
                    </script> '; 
        }
    }


    if(isset($_POST['receiving_order_status'])){
        $order_id = $_POST['id'];
        $receiving_order_status = $_POST['receiving_order_status'];

        $received_order_query = "  
            INSERT INTO order_status_tbl (order_id,receiving_order_status,date_confirmed) 
            VALUES('$order_id','$receiving_order_status','$date')
        ";
        if(!mysqli_query($db, $received_order_query)){
            $system_msg .= "query receiving order status failed "  . mysqli_error($db);
        }else{
            $order_status_id = mysqli_insert_id($db);
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $_POST['order_status_id'] = $order_status_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
            VALUES('$session_user_id', 'received_order','$description')";
            mysqli_query($db, $activity_sql);

            echo "order received";

        }
    }

    if(isset($_POST['get_products'])){
        $product = $_POST['product'];
        $category = $_POST['category'];

        $product_list = "SELECT * FROM products_tbl WHERE product LIKE '%$product%' AND category = '$category' AND product_quantity>0 AND is_active=1" ; //category = category_name
        $result_list = $con->query($product_list);

        $get_products=array();
        if ($result_list->num_rows>0) {
            while ($row = $result_list->fetch_assoc()){ 
                $subdata=array();
                $subdata[] = $row['product_id'];
                $subdata[] = $row['product'];
                $subdata[] = $row['product_price'];
                $subdata[] = $row['product_image'];
                $subdata[] = $row['category'];

                $get_products[]=$subdata;
            }
        }

        // check category if has add_ons_list
        $check_with_add_ons = 0;
        $check_add_ons_list = "SELECT * FROM add_ons_list_tbl WHERE add_ons_category='$category' AND add_ons_quantity>0 AND is_active=1" ; 
        $check_add_ons_list_result = $con->query($check_add_ons_list);
        if ($check_add_ons_list_result->num_rows>0) {
            $check_with_add_ons = 1;
        }

        $json_data = [
            'get_products' => $get_products,
            'check_with_add_ons' => $check_with_add_ons,
        ];

        echo json_encode($json_data);

    }

    if(isset($_POST['check_email'])){

        $email = $_POST['email'];
        // first check the database to make sure 
        // a user does not already exist with the same username and/or email
        $user_check_query = "SELECT * FROM users_tbl WHERE username='$email' LIMIT 1";
        $result = mysqli_query($db, $user_check_query);
        $user = mysqli_fetch_assoc($result);
        $system_message='';
        if ($user) { // if user exists
            $system_message .= "This email is already taken.";
        }else{
            $system_message .= "Available";
        }

        $json_data = [
            'system_message' => $system_message,
        ];
        
        echo json_encode($json_data);

    }


    if (isset($_POST['submit_new_password'])) {
        $generated_request_id = $_POST['generated_request_id'];
        // $old_password = $_POST['old_password'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if($password == $password2){

            $sql = "SELECT * FROM reset_request_tbl WHERE generated_request_id='$generated_request_id' LIMIT 1";
            $query=mysqli_query($con,$sql);
            $row=mysqli_fetch_assoc($query);
            
            if($row){ //existing
                $email = $row['email'];
                $sql = "SELECT * FROM users_tbl WHERE username='$email' LIMIT 1";
                $query=mysqli_query($con,$sql);
                $row2=mysqli_fetch_assoc($query);
                if($row2){ // existing
                    // if(password_verify($old_password, $row2['password'])){
                    $new_password = password_hash($password, PASSWORD_DEFAULT);//encrypt the password before saving in the database
                    $user_id = $row2['user_id'];
                    $query_update= "UPDATE users_tbl SET password='$new_password'  WHERE user_id='$user_id' ";
                    if (!mysqli_query($db, $query_update)) {
                        echo "query update new password failed:". mysqli_error($db);
                        // echo '<script> 
                        //     alert("query update new password failed: '. mysqli_error($db).'");
                        //     window.location = "login.php";
                        // </script> ';
                    }else{
                        echo '<script> 
                            alert("Reset Password Successful.");
                            window.location = "login.php";
                        </script> ';
                    }
                    // }else{
                    //     echo '<script> 
                    //         alert("Incorrect Password.");
                    //         window.location = "login.php?generated_request_id=a524b7";
                    //     </script> ';
                    // }

                }else{ //not existing email
                    echo '<script> 
                        alert("email is not valid.");
                        window.location = "login.php";
                    </script> '; 
                }


            }else{ //not exsiting
                echo '<script> 
                    alert("Code is not valid.");
                    window.location = "login.php";
                </script> '; 
            }
        }else{
            echo '<script> 
                alert("Password did not match.");
                window.location = "login.php";
            </script> '; 
        }

    }


    if(isset($_POST['cancel_order_status'])){
        $order_id = $_POST['id'];
        $cancel_order_status = $_POST['cancel_order_status'];

        //update order_tbl
        $query_update_order = "UPDATE order_tbl SET order_status='$cancel_order_status'  WHERE order_id='$order_id' ";
        if (!mysqli_query($db, $query_update_order)) {
            $system_msg .= "query cancel order failed " . mysqli_error($db);
        }else{

            $system_msg .= "Cancel  order successful.";

            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
            VALUES('$user_id', 'cancel_order','$date','$description')";
            mysqli_query($db, $activity_sql);
        }

        $json_data = [
            'system_msg' => $system_msg,
        ];

        echo json_encode($json_data);

    }
    
?>