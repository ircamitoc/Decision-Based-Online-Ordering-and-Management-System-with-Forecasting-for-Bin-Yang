<?php 
    include('admin/db_connection.php'); 

    $sql = "SELECT * FROM order_tbl WHERE order_by='$session_username' ";
    $query=mysqli_query($con,$sql);
    // $row=mysqli_fetch_array($query);
    // $order_id = $row['order_id'];
    // $order_status = $row['order_status'];

    $data=array();

    while($row=mysqli_fetch_array($query)){
        $subdata=array();
        
        $subdata[]=$row[0]; //id
        $subdata[]=$row[8]; //order_status

        $data[]=$subdata;
    }

    // ---------------------------------------------------------

    $sql = "
        SELECT *,order_tbl.order_id as order_id_join FROM order_tbl 
        LEFT JOIN order_status_tbl
        ON order_tbl.order_id = order_status_tbl.order_id
        WHERE order_by='$session_username' 
    ";
    $result = mysqli_query($con,$sql);
    $received_data=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();
        $subdata[] = $row['order_id_join'];
        $subdata[] = $row['receiving_order_status'];

        $received_data[]=$subdata;
    }



    $json_data = [
        'data' =>  $data,
        'received_data' => $received_data,
    ];

    echo json_encode($json_data);
?>