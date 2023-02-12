<?php 

    include('db_connection.php');

    header("Content-type: application/octet-stream");
    header("Pragma: no-cache");
    header("Expires: 0");

    $date = $_POST['date'];
    $product_filter = $_POST['product_filter'];
    $user_filter = $_POST['user_filter'];

    $search = array(
        'date' =>  ($date!='')?$date:'',
        'product_filter' =>  ($product_filter!='')?$product_filter:'ALL',
        'user_filter' =>  ($user_filter!='')?$user_filter:'ALL',
    );

    $condition = " 1=1 AND order_status = 'delivered' AND order_payment>0 ";

    if($search['product_filter'] != 'ALL'){

        $condition .= ' AND (';

        $product_filter = str_replace(",", "','", $search['product_filter']);

        $condition .= "availed_product IN ('$product_filter') ";

        $condition .= ')';
    }
    else{
        $condition .= '';
    }

    if($search['user_filter'] != 'ALL'){

        $condition .= ' AND (';

        $user_filter = str_replace(",", "','", $search['user_filter']);

        $condition .= "order_by IN ('$user_filter') ";

        $condition .= ')';
    }
    else{
        $condition .= '';
    }

    $condition .= ($search['date'] != '')? " AND DATE(updated_at) BETWEEN '".substr($search['date'], 0,10)."' AND '".substr($search['date'], 11,10)."' " : '';

    $sql = "
        SELECT *
        FROM order_tbl 
        LEFT JOIN availed_product_tbl 
        ON order_tbl.order_id = availed_product_tbl.order_id 
        WHERE $condition
    ";


    // Excel file name for download 
    // $fileName = "export_sales" . date('Y-m-d') . ".xls"; 
    $fileName = "export_sales.xls"; 

    // Column names 
    $fields = array(
        "DATE",
        "PRODUCT",
        "ORDER FROM",
        "QUANTITY",
        "PRICE",
        "TOTAL",
    );

    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n"; 

    echo $sql;
    $total_sales=0;

    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result)> 0){ 
		$data = array();
        while($row= mysqli_fetch_array($result)){ 
            $list = array(
                'updated_at' => $row['updated_at'],
                'availed_product' => $row['availed_product'],
                'order_by' => $row['order_by'],
                'availed_quantity' => $row['availed_quantity'],
                'availed_price' => $row['availed_price'],
                'availed_amount' => $row['availed_amount']
            );
			array_push($data, $list);
        }
    }else{
        echo $excelData .= 'No records found...'. "\n"; 
    }

    header("Content-Type: text/plain");
    $flag = false;
    foreach($data as $row2) {
        if(!$flag) {
        // display field/column names as first row
        echo implode("\t", array_keys($row2)) . "\r\n";
        $flag = true;
        }
        echo implode("\t", array_values($row2)) . "\r\n";
    }
    // exit;
    
    

?>