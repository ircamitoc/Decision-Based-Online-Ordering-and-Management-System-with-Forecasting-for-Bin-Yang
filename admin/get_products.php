<?php
    include('db_connection.php');

    // $resultset=[];
    if(!isset($_POST['q'])){
        // Fetch record
        $query = "SELECT product FROM products_tbl WHERE is_active=1 ORDER BY product";
        $result_list = $con->query($query);
        if ($result_list->num_rows>0) {
            while ($row = $result_list->fetch_assoc()){ 
                $resultset[] = $row;
            }
        }
    }else{
        // Fetch record
        $query = "SELECT product FROM products_tbl WHERE LIKE='%$q%' AND is_active=1 ORDER BY product";
        $result_list = $con->query($query);
        if ($result_list->num_rows>0) {
            while ($row = $result_list->fetch_assoc()){ 
                $resultset[] = $row;
            }
        }
     }

    $data = array();
    foreach($resultset as $key){
        $data[] = array(
            "id" => $key['product'],
            "text" => $key['product'],
        );
    }
    echo json_encode($data);
    

?>