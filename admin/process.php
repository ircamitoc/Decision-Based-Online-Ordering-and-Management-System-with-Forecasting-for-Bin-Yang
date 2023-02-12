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


    // REGISTER USER
    if (isset($_POST['register'])) {
        // receive all input values from the form
        $username=mysqli_real_escape_string($db, $_POST['username']);
        $password=mysqli_real_escape_string($db, $_POST['password']);
        $password2=mysqli_real_escape_string($db, $_POST['password2']);
        $access_level=mysqli_real_escape_string($db, $_POST['access_level']);

       

        if($password==$password2){

            // first check the database to make sure 
            // a user does not already exist with the same username and/or email
            $user_check_query = "SELECT * FROM users_tbl WHERE username='$username' LIMIT 1";
            $result = mysqli_query($db, $user_check_query);
            $user = mysqli_fetch_assoc($result);
            
            if ($user) { // if user exists
                if ($user['username'] === $username) {
                echo '<script> 
                        alert("Username is already taken.");
                        window.location = "login.php";
                    </script> '; 
                } 
            }else{

                #file name with a random number so that similar dont get replaced
                $filename = rand(1000,10000)."-".$_FILES["image"]["name"];
                #temporary file name to store file
                $tname = $_FILES["image"]["tmp_name"];
                #to move the uploaded file to specific location
                move_uploaded_file($tname,'assets/img/'.$filename);

                // Finally, register user if there are no errors in the form
                $password = password_hash($password, PASSWORD_DEFAULT);//encrypt the password before saving in the database
                $query = "INSERT INTO users_tbl (username,password,access_level,date_created,user_image) 
                        VALUES('$username', '$password', '$access_level', NOW(),'$filename')";
            
                if(!mysqli_query($db, $query)){
                    echo("Error description: " . mysqli_error($db));
                        echo '<script> 
                            alert("mysqli_error...");
                            window.location = "index.php";
                        </script> '; 
                }else{
                    session_start();
                    $_SESSION['username'] = $username;
                    $user_id = mysqli_insert_id($db);
                    $description = "";
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
                        alert("The password did not match.");
                        window.location = "login.php";
                    </script> ';
        }

    }
    

    // LOGIN USER
  	if(isset($_POST['login'])){
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $access_level = mysqli_real_escape_string($db, $_POST['access_level']);

         if (empty($username)) {
           echo '<script> 
                   alert("Username is required")
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
                    WHERE username='$username' 
                    AND access_level='$access_level'
                ";
        $result = mysqli_query($db, $query);
        if(mysqli_num_rows($result)>0){
            $row = mysqli_fetch_array($result);

            if($row['access_level'] == "admin" || $row['access_level'] == "owner" || $row['access_level'] == "staff"){
                if(password_verify($password, $row['password'])){
                    // session_start();
                    $description = "";
                    $user_id = $row['user_id'];
                    $data['user_ip'] = $_SERVER['REMOTE_ADDR'];
                    $data['username'] = $username;
                    $description .= json_encode($data);
                    $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
                    VALUES('$user_id', 'admin_login','$date','$description')";
                    mysqli_query($db, $activity_sql);


                    $_SESSION['username'] = $username;
                    echo '<script> 
                        window.location = "index.php";
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
                echo '<script> 
                    alert("Customer are not allowed to login here, Please contact our admin.")
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
    }

    //add product
  	if(isset($_POST['add_product'])){
        // escape string before passing it to query.
        // receive all input values from the form
        $product=mysqli_real_escape_string($db, $_POST['product']);
        $price=mysqli_real_escape_string($db, $_POST['price']);
        $quantity=mysqli_real_escape_string($db, $_POST['quantity']);
        $category=mysqli_real_escape_string($db, $_POST['category']);



        // first check the database to make sure 
        // the product does not already exist with the same product name
        $product_check_query = "SELECT * FROM products_tbl WHERE product='$product' LIMIT 1";
        $result = mysqli_query($db, $product_check_query);
        $result_product = mysqli_fetch_assoc($result);
        
        if ($result_product) { // if user exists
            if ($result_product['product'] === $product) {
            echo '<script> 
                    alert("Product is already existing.");
                    window.location = "inventory.php";
                </script> '; 
            } 
        }else{
            #file name with a random number so that similar dont get replaced
            $filename = rand(1000,10000)."-".$_FILES["image"]["name"];
            #temporary file name to store file
            $tname = $_FILES["image"]["tmp_name"];
            #to move the uploaded file to specific location
            move_uploaded_file($tname,'assets/img/'.$filename);

            $query = "	INSERT INTO products_tbl (product,product_price,product_quantity,category,product_image) 
                        VALUES('$product','$price','$quantity','$category','$filename')";
                
            if(!mysqli_query($db, $query)){
                echo $error_msg = "Error description: " . mysqli_error($db);
                echo '<script> 
                var error_msg = "'.$error_msg.'";
                alert("Mysqli_error: "+error_msg);
                window.location = "index.php";
                </script> '; 
            }else{

                //save logs
                $description = "";
                $user_id = $session_user_id;
                $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $_POST['user_id'] = $session_user_id;
                $description .= json_encode($_POST);
                $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
                VALUES('$user_id', 'add_product','$date','$description')";
                mysqli_query($db, $activity_sql);

                echo '	<script> 
                            alert("Product added Successful.");
                            window.location = "inventory.php";
                        </script> '; 
            }
        }
        
    }

    //get product row for edit.
    if(isset($_POST['product_id'])){
        $product_id=$_POST['product_id'];
        $sql = "SELECT * FROM products_tbl WHERE product_id=$product_id LIMIT 1";
        $query=mysqli_query($con,$sql);
        $row=mysqli_fetch_array($query);

        if (!file_exists('assets/img/'.$row[4])) {
            $row[4]="default.png";
        }

        $data = [
            'product_id' =>  $row[0],
            'product' =>  $row[1],
            'product_price' =>  $row[2],
            'product_quantity' =>  $row[3],
            'product_image' =>  $row[4],
            'category' =>  $row[6],
            'is_active' =>  $row[5],
        ];

        echo json_encode($data); die();

    }

    //update_product
    if(isset($_POST['update_product'])){
        $product_id = $_POST['update_product_id'];
        $product = $_POST['product'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $category = $_POST['category'];

        if($_POST['get_filename']!="0"){

            #file name with a random number so that similar dont get replaced
            $filename = rand(1000,10000)."-".$_FILES["image"]["name"];
            #temporary file name to store file
            $tname = $_FILES["image"]["tmp_name"];
            #to move the uploaded file to specific location
            move_uploaded_file($tname,'assets/img/'.$filename);

            $sql = "UPDATE products_tbl SET product='$product', product_price='$price', product_quantity='$quantity', category='$category', product_image='$filename' WHERE product_id='$product_id' ";
        }else{
          
            $sql = "UPDATE products_tbl SET product='$product', product_price='$price', product_quantity='$quantity', category='$category'  WHERE product_id='$product_id' ";
        }
        

        if (mysqli_query($con, $sql)) {

            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
            VALUES('$user_id', 'update_product','$date','$description')";
            mysqli_query($db, $activity_sql);

            echo '	<script> 
                        alert("Update Product Successful.");
                        window.location = "inventory.php";
                    </script> '; 
        } else {


            echo '<script> 
                    alert("Error description: '. mysqli_error($con) .'")
                    window.location = "inventory.php";
                </script> '; 
        }
    }

    //remove product
    if(isset($_POST['remove_product_id'])){
        $product_id = $_POST['remove_product_id'];

        
        $sql = "UPDATE products_tbl SET is_active=0 WHERE product_id='$product_id' ";

		if (mysqli_query($con, $sql)) {
            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
            VALUES('$user_id', 'remove_product','$date','$description')";
            mysqli_query($db, $activity_sql);

            echo '	<script> 
                        alert("Product has been removed.");
                        window.location = "inventory.php";
                    </script> '; 
		} else {
		    echo '<script> 
                    alert("Error description: '. mysqli_error($conn) .'"
                    window.location = "inventory.php";
                </script> '; 
		}

    }

    //activate category
    if(isset($_POST['activate_product_id'])){
        $activate_product_id = $_POST['activate_product_id'];
        $system_message = "";
        $error_message = "";

        $sql = "UPDATE products_tbl SET is_active=1 WHERE product_id='$activate_product_id' ";

		if (mysqli_query($con, $sql)) {
            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
            VALUES('$user_id', 'activate_product','$date','$description')";
            mysqli_query($db, $activity_sql);

            $system_message .= "Activate Product Successful.";

		} else {
            $error_message .="ERROR";
            $system_message .= "Activate Product Error Description". mysqli_error($con);
		}

        $data = [
            'system_message' =>  $system_message,
            'error_message' =>  $error_message,
            
        ];

        echo json_encode($data); die();

    }

    //create user
    if (isset($_POST['create_user'])) {
        // receive all input values from the form
        $username=mysqli_real_escape_string($db, $_POST['username']);
        $password=mysqli_real_escape_string($db, $_POST['password']);
        $password2=mysqli_real_escape_string($db, $_POST['password2']);
        $access_level=mysqli_real_escape_string($db, $_POST['access_level']);

        #file name with a random number so that similar dont get replaced
        $filename = rand(1000,10000)."-".$_FILES["image"]["name"];
        #temporary file name to store file
        $tname = $_FILES["image"]["tmp_name"];
        #to move the uploaded file to specific location
        move_uploaded_file($tname,'assets/img/'.$filename);

        if($password==$password2){

            // first check the database to make sure 
            // a user does not already exist with the same username and/or email
            $user_check_query = "SELECT * FROM users_tbl WHERE username='$username' LIMIT 1";
            $result = mysqli_query($db, $user_check_query);
            $user = mysqli_fetch_assoc($result);
            
            if ($user) { // if user exists
                if ($user['username'] === $username) {
                echo '<script> 
                        alert("Username is already taken.");
                        window.location = "user_management.php";
                    </script> '; 
                } 
            }else{
                // Finally, register user if there are no errors in the form
                $password = password_hash($password, PASSWORD_DEFAULT);//encrypt the password before saving in the database
                $query = "INSERT INTO users_tbl (username,password,access_level,date_created,user_image) 
                        VALUES('$username', '$password', '$access_level', NOW(),'$filename')";
            
                if(!mysqli_query($db, $query)){
                    echo("Error description: " . mysqli_error($db));
                        echo '<script> 
                        alert("mysqli_error...");
                        window.location = "user_management.php";
                        </script> '; 
                }else{
                    // session_start();
                    
                    //add logs
                    $description = "";
                    $data['user_ip'] = $_SERVER['REMOTE_ADDR'];
                    $user_id = $session_user_id;
                    $data['user_id'] = mysqli_insert_id($db);
                    $data['username'] = $username;
                    $data['access_level'] = $access_level;
                    $store_data = json_encode($data);
                    $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
                    VALUES('$user_id', 'create_user','$store_data')";
                    mysqli_query($db, $activity_sql);

                    echo '	<script> 
                                alert("Account Creation Successful.");
                                window.location = "user_management.php";
                            </script> '; 
                }
            }
        }else{
            echo '	<script> 
                        alert("The password did not match.");
                        window.location = "user_management.php";
                    </script> ';
        }

    }

    //get user row for edit.
    if(isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
        $sql = "SELECT * FROM users_tbl WHERE user_id=$user_id LIMIT 1";
        $query=mysqli_query($con,$sql);
        $row=mysqli_fetch_array($query);

        if (!file_exists('assets/img/'.$row[5])) {
            $row[5]="assets/img/default.png";
        }

        $data = [
            'user_id' =>  $row[0],
            'username' =>  $row[1],
            'access_level' =>  $row[3],
            'date_created' =>  $row[4],
            'user_image' =>  $row[5],
            'is_active' =>  $row[6],
        ];

        echo json_encode($data); die();

    }


    //update_user
    if(isset($_POST['update_user'])){
        $user_id = $_POST['update_user_id'];
        $username = $_POST['username'];
        $access_level = $_POST['access_level'];

        if($_POST['get_filename']!="0"){
            #file name with a random number so that similar dont get replaced
            $filename = rand(1000,10000)."-".$_FILES["image"]["name"];
            #temporary file name to store file
            $tname = $_FILES["image"]["tmp_name"];
            #to move the uploaded file to specific location
            move_uploaded_file($tname,'assets/img/'.$filename);

            $sql = "UPDATE users_tbl SET username='$username', access_level='$access_level', user_image='$filename' WHERE user_id='$user_id' ";
        }else{
            $sql = "UPDATE users_tbl SET username='$username', access_level='$access_level'  WHERE user_id='$user_id' ";
        }
        

        if (mysqli_query($con, $sql)) {

            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
            VALUES('$user_id', 'update_user','$description')";
            mysqli_query($db, $activity_sql);
            // echo "get_filename: " .$_POST['get_filename'];
            // echo "<br> sql: " . $sql;
            echo '	<script> 
                        alert("Update User Successful.");
                        window.location = "user_management.php";
                    </script> '; 
        } else {
            echo '<script> 
                    alert("Error description: '. mysqli_error($con) .'"
                    window.location = "user_management.php";
                </script> '; 
        }
    }

    //remove User
    if(isset($_POST['remove_user_id'])){
        $user_id = $_POST['remove_user_id'];

        
        $sql = "UPDATE users_tbl SET is_active=0 WHERE user_id='$user_id' ";

		if (mysqli_query($con, $sql)) {
            //save logs
            $description = "";
            $user_id_logs = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
            VALUES('$user_id_logs', 'remove_user','$description')";
            mysqli_query($db, $activity_sql);

            echo '	<script> 
                        alert("Product has been removed.");
                        window.location = "user_management.php";
                    </script> '; 
		} else {
		    echo '<script> 
                    alert("Error description: '. mysqli_error($conn) .'"
                    window.location = "user_management.php";
                </script> '; 
		}

    }

    //get order id details for edit
    if(isset($_POST['order_id'])){
        $order_id=$_POST['order_id'];
        $sql = "SELECT * FROM order_tbl WHERE order_id='$order_id' LIMIT 1";
        $query=mysqli_query($con,$sql);
        $row=mysqli_fetch_array($query);

        $data = [
            'order_id' =>  $row[0],
            'order_by' =>  $row[1],
            'order_discount' =>  $row[2],
            'order_amount' =>  $row[3],
            'order_payment' =>  $row[4],
            'order_change' =>  $row[5],
            'order_date' =>  dateTimeToReadableDate($row[6]),
            'updated_at' =>  dateTimeToReadableDate($row[7]),
            'order_status' =>  $row[8],
            'payment_method' =>  $row[9],
            'delivery_address' =>  $row[10],
            'order_message' =>  $row[11],
            'proof_of_payment' =>  $row[12],
            'payment_status' =>  $row[13],
        ];

        echo json_encode($data); die();

    }   


    //update order_id baka jquery
    if(isset($_POST['submit_update_order'])){
        // echo "submit_update_order2";
        $Update_Order_id        =    $_POST['Update_Order_id'];
        $Update_Order_amount    =    $_POST['Update_Order_amount'];
        $Update_Order_discount  =    $_POST['Update_Order_discount'];
        $Update_Order_payment   =    $_POST['Update_Order_payment'];
        $Update_Order_change    =    $_POST['Update_Order_change'];
        $Update_Order_status    =    $_POST['Update_Order_status'];
        $Update_Order_payment_method    =   $_POST['Update_Order_payment_method'];
        $update_payment_status    =   $_POST['update_payment_status'];
        
        $sql = "UPDATE order_tbl 
                SET order_amount='$Update_Order_amount', 
                    order_discount='$Update_Order_discount', 
                    order_payment='$Update_Order_payment', 
                    order_change='$Update_Order_change', 
                    updated_at='$date', 
                    order_status='$Update_Order_status', 
                    payment_method='$Update_Order_payment_method',
                    payment_status='$update_payment_status'
                WHERE order_id='$Update_Order_id' ";

        if (mysqli_query($con, $sql)) {
            //save logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
            VALUES('$user_id', 'admin_update_order','$description')";
            mysqli_query($db, $activity_sql);


            echo "Update Order Successful.";
            // foreach($_POST as $value){
            //     echo $value."<br>";
            // }   
        }else{
            echo "Error description: ". mysqli_error($con);
        }

    }

    //remove product
    if(isset($_POST['remove_order_id'])){
        $order_id = $_POST['remove_order_id'];

        // echo "wew";
        $sql = "DELETE FROM order_tbl WHERE order_id=$order_id ";

		if (mysqli_query($con, $sql)) {
            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
            VALUES('$user_id', 'remove_order','$description')";
            mysqli_query($db, $activity_sql);

            echo '	<script> 
                        alert("Order has been removed.");
                        window.location = "order_management.php";
                    </script> '; 
		} else {
		    echo '<script> 
                    alert("Error description: '. mysqli_error($conn) .'"
                    window.location = "order_management.php";
                </script> '; 
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


    if(isset($_POST['update_password'])){
        $username=mysqli_real_escape_string($db, $_POST['username']);
        $password=mysqli_real_escape_string($db, $_POST['change_password']);
        $password2=mysqli_real_escape_string($db, $_POST['change_password2']);

        if($password==$password2){
            // Finally, change user pw if there are no errors in the form
            $password = password_hash($password, PASSWORD_DEFAULT);//encrypt the password before saving in the database
            $sql = "UPDATE users_tbl SET password='$password' WHERE username='$username' ";

            if(!mysqli_query($db, $sql)){
                echo("Error description: " . mysqli_error($db));
                echo '<script> 
                    alert("mysqli_error...");
                    window.location = "user_management.php";
                </script> '; 
            }else{
                $_SESSION['username'] = $session_username;
                $description = "";
                $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $_POST['user_id'] = $session_user_id;
                $description .= json_encode($_POST);
                $activity_sql  = "INSERT INTO activity_logs (user_id,action,description) 
                VALUES('$session_user_id', 'update_password','$description')";
                mysqli_query($db, $activity_sql);

                echo '	<script> 
                            alert("Update Password successful.");
                            window.location = "user_management.php";
                        </script> '; 
            }
        }else{
            echo '	<script> 
                alert("The password did not match.");
                window.location = "user_management.php";
            </script> ';
        }
    }


    if(isset($_POST['add_category'])){
        $category_name = $_POST['category_name'];

        $category_check_query = "SELECT * FROM category_tbl WHERE category='$category_name'  ";
        $result = mysqli_query($db, $category_check_query);
        $category_row = mysqli_fetch_assoc($result);
        $system_message = "";
        $error_message = "";
        if ($category_row) { // if category exists
            $system_message .= "Category is already existing.";
        }else{
            $user_ip = $_SERVER['REMOTE_ADDR'];
            $query = "INSERT INTO category_tbl (category,date_added,username,user_ip) 
                        VALUES('$category_name', '$date','$session_username','$user_ip')";
            if(!mysqli_query($db, $query)){
                $error_message .= "ERROR";
                $system_message .= "Adding Category Error description: " . mysqli_error($db);
            }else{

                //add logs
                $description = "";
                $user_id = $session_user_id;
                $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $_POST['user_id'] = $session_user_id;
                $description .= json_encode($_POST);
                $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
                VALUES('$user_id', 'add_category','$date','$description')";
                mysqli_query($db, $activity_sql);

                $system_message .= "New category has been added.";
            }
        }

        $json_data = [
            'system_message' => $system_message,
            'error_message' => $error_message,
            
        ];

        echo json_encode($json_data);
    }

    //get category row for edit.
    if(isset($_POST['edit_category_btn'])){
        $category_id=$_POST['category_id'];
        $sql = "SELECT * FROM category_tbl WHERE category_id=$category_id ";
        $query=mysqli_query($con,$sql);
        $row=mysqli_fetch_assoc($query);

        $data = [
            'category_id' => $row['category_id'],
            'category' =>  $row['category'],
        ];

        echo json_encode($data); die();

    }

    if(isset($_POST['update_category_btn'])){
        $category_id = $_POST['category_id'];
        $category_name = $_POST['category_name'];
        $system_message = "";
        $error_message = "";

        $category_check_query = "SELECT * FROM category_tbl WHERE category='$category_name'  ";
        $result = mysqli_query($db, $category_check_query);
        $category_row = mysqli_fetch_assoc($result);

        if ($category_row) { // if category exists
            $system_message .= "Category is already existing.";
        }else{

            $sql = "UPDATE category_tbl SET category='$category_name', date_updated='$date' WHERE category_id=$category_id ";

            if (mysqli_query($con, $sql)) {
                //add logs
                $description = "";
                $user_id = $session_user_id;
                $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $_POST['user_id'] = $session_user_id;
                $description .= json_encode($_POST);
                $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
                VALUES('$user_id', 'update_category','$date','$description')";
                mysqli_query($db, $activity_sql);

                $system_message .= "Update Category Successful.";
            
            }else{
                $error_message .="ERROR";
                $system_message .= "Updating Category Error Description". mysqli_error($con);

            }

        }


        $data = [
            'system_message' =>  $system_message,
            'error_message' =>  $error_message,
            
        ];

        echo json_encode($data); die();
    }


    //remove category
    if(isset($_POST['remove_category_id'])){
        $category_id = $_POST['remove_category_id'];
        $system_message = "";
        $error_message = "";

        $sql = "UPDATE category_tbl SET is_active=0 WHERE category_id='$category_id' ";

		if (mysqli_query($con, $sql)) {
            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
            VALUES('$user_id', 'remove_category','$date','$description')";
            mysqli_query($db, $activity_sql);

            $system_message .= "Remove Category Successful.";

		} else {
            $error_message .="ERROR";
            $system_message .= "Removing Category Error Description". mysqli_error($con);
		}

        $data = [
            'system_message' =>  $system_message,
            'error_message' =>  $error_message,
            
        ];

        echo json_encode($data); die();

    }

    //activate category
    if(isset($_POST['activate_category_id'])){
        $category_id = $_POST['activate_category_id'];
        $system_message = "";
        $error_message = "";

        $sql = "UPDATE category_tbl SET is_active=1 WHERE category_id='$category_id' ";

		if (mysqli_query($con, $sql)) {
            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
            VALUES('$user_id', 'activate_category','$date','$description')";
            mysqli_query($db, $activity_sql);

            $system_message .= "Activate Category Successful.";

		} else {
            $error_message .="ERROR";
            $system_message .= "Activate Category Error Description". mysqli_error($con);
		}

        $data = [
            'system_message' =>  $system_message,
            'error_message' =>  $error_message,
            
        ];

        echo json_encode($data); die();

    }

    // ---------------------------------add-ons

    if(isset($_POST['add_add_ons'])){
        $add_ons_name = $_POST['add_ons_name'];
        $add_ons_price = $_POST['add_ons_price'];
        $add_ons_quantity = $_POST['add_ons_quantity'];
        $add_ons_category = $_POST['add_ons_category'];

        // $add_ons_check_query = "SELECT * FROM add_ons_list_tbl WHERE add_ons='$add_ons_name'  ";
        // $result = mysqli_query($db, $add_ons_check_query);
        // $add_ons_row = mysqli_fetch_assoc($result);
        // $system_message = "";
        // $error_message = "";
        // if ($add_ons_row) { // if category exists
        //     $system_message .= "Add-ons is already existing.";
        // }else{
            $user_ip = $_SERVER['REMOTE_ADDR'];
            $query = "INSERT INTO add_ons_list_tbl (add_ons,add_ons_price,add_ons_quantity,add_ons_category,date_added,username,user_ip) 
                        VALUES('$add_ons_name', '$add_ons_price', '$add_ons_quantity', '$add_ons_category', '$date','$session_username','$user_ip')";
            if(!mysqli_query($db, $query)){
                $error_message .= "ERROR";
                $system_message .= "Adding Add-ons Error description: " . mysqli_error($db);
            }else{

                //add logs
                $description = "";
                $user_id = $session_user_id;
                $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $_POST['user_id'] = $session_user_id;
                $description .= json_encode($_POST);
                $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
                VALUES('$user_id', 'add_add_ons','$date','$description')";
                mysqli_query($db, $activity_sql);

                $system_message .= "New Add-ons has been added.";
            }
        // }

        $json_data = [
            'system_message' => $system_message,
            'error_message' => $error_message,
            
        ];

        echo json_encode($json_data);
    }


     //get category row for edit.
     if(isset($_POST['edit_add_ons_btn'])){
        $add_ons_list_id=$_POST['add_ons_list_id'];
        $sql = "SELECT * FROM add_ons_list_tbl WHERE add_ons_list_id=$add_ons_list_id  ";
        $query=mysqli_query($con,$sql);
        $row=mysqli_fetch_assoc($query);

        $data = [
            'add_ons_list_id' => $row['add_ons_list_id'],
            'add_ons' =>  $row['add_ons'],
            'add_ons_price' =>  $row['add_ons_price'],
            'add_ons_quantity' =>  $row['add_ons_quantity'],
            'add_ons_category' =>  $row['add_ons_category'],
        ];

        echo json_encode($data); die();

    }

    if(isset($_POST['update_add_ons_btn'])){
        $add_ons_list_id = $_POST['add_ons_list_id'];
        $add_ons_name = $_POST['add_ons_name'];
        $add_ons_price = $_POST['add_ons_price'];
        $add_ons_quantity = $_POST['add_ons_quantity'];
        $add_ons_category = $_POST['add_ons_category'];

        $system_message = "";
        $error_message = "";

        // $add_ons_check_query = "SELECT * FROM add_ons_list_tbl WHERE add_ons='$add_ons_name'  ";
        // $result = mysqli_query($db, $add_ons_check_query);
        // $add_ons_row = mysqli_fetch_assoc($result);

        // if ($add_ons_row) { // if category exists
        //     $system_message .= "Add-ons is already existing.";
        // }else{

            $sql = "UPDATE add_ons_list_tbl SET 
                        add_ons='$add_ons_name', 
                        add_ons_price='$add_ons_price', 
                        add_ons_quantity='$add_ons_quantity', 
                        add_ons_category='$add_ons_category', 
                        date_updated='$date'
                    WHERE add_ons_list_id=$add_ons_list_id ";

            if (mysqli_query($con, $sql)) {
                //add logs
                $description = "";
                $user_id = $session_user_id;
                $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $_POST['user_id'] = $session_user_id;
                $description .= json_encode($_POST);
                $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
                VALUES('$user_id', 'update_add_ons','$date','$description')";
                mysqli_query($db, $activity_sql);

                $system_message .= "Update Add-ons Successful.";
            
            }else{
                $error_message .="ERROR";
                $system_message .= "Updating Add-ons Error Description". mysqli_error($con);

            }

        // }


        $data = [
            'system_message' =>  $system_message,
            'error_message' =>  $error_message,
            
        ];

        echo json_encode($data); die();
    }


    //remove product
    if(isset($_POST['remove_add_ons_list_id'])){
        $remove_add_ons_list_id = $_POST['remove_add_ons_list_id'];
        $system_message = "";
        $error_message = "";

        $sql = "UPDATE add_ons_list_tbl SET is_active=0 WHERE add_ons_list_id='$remove_add_ons_list_id' ";

		if (mysqli_query($con, $sql)) {
            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
            VALUES('$user_id', 'remove_add_ons','$date','$description')";
            mysqli_query($db, $activity_sql);

            $system_message .= "Remove Add-ons Successful.";

		} else {
            $error_message .="ERROR";
            $system_message .= "Removing Add-ons Error Description". mysqli_error($con);
		}

        $data = [
            'system_message' =>  $system_message,
            'error_message' =>  $error_message,
            
        ];

        echo json_encode($data); die();

    }

    //activate category
    if(isset($_POST['activate_add_ons_id'])){
        $activate_add_ons_id = $_POST['activate_add_ons_id'];
        $system_message = "";
        $error_message = "";

        $sql = "UPDATE add_ons_list_tbl SET is_active=1 WHERE add_ons_list_id='$activate_add_ons_id' ";

		if (mysqli_query($con, $sql)) {
            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
            VALUES('$user_id', 'activate_add_ons','$date','$description')";
            mysqli_query($db, $activity_sql);

            $system_message .= "Activate Add-ons Successful.";

		} else {
            $error_message .="ERROR";
            $system_message .= "Activate Add-ons Error Description". mysqli_error($con);
		}

        $data = [
            'system_message' =>  $system_message,
            'error_message' =>  $error_message,
            
        ];

        echo json_encode($data); die();

    }

    // -----------------------------------end of add ons

    

    // edit delivery fee
    if(isset($_POST['delivery_fee_input'])){
        $delivery_fee_input = $_POST['delivery_fee_input'];
        $system_message = "";
        $error_message = "";

        $sql = "UPDATE delivery_fee_tbl SET delivery_fee=$delivery_fee_input WHERE delivery_fee_id ='1' ";
        if (mysqli_query($con, $sql)) {
            //add logs
            $description = "";
            $user_id = $session_user_id;
            $_POST['user_ip'] = $_SERVER['REMOTE_ADDR'];
            $_POST['user_id'] = $session_user_id;
            $description .= json_encode($_POST);
            $activity_sql  = "INSERT INTO activity_logs (user_id,action,created_at,description) 
            VALUES('$user_id', 'update_delivery_fee','$date','$description')";
            mysqli_query($db, $activity_sql);

            $system_message .= "Update Delivery Fee Successful.";

        }else{
            $error_message .="ERROR";
            $system_message .= "Update Delivery Fee Error Description". mysqli_error($con);
        }

        $data = [
            'system_message' =>  $system_message,
            'error_message' =>  $error_message,
            
        ];

        echo json_encode($data); die();
    }

    

    




?>