<?php 

    include('db_connection.php');

    $number_of_days_back=0;
    // $sqlQuery = "SELECT count(action) as action_count,created_at 
    //                 FROM activity_logs 
                        
    //                 WHERE 
    //                     action='visit' 
    //                     -- AND date(created_at) >= dateadd(day,datediff(day,0,GetDate())- 7,0)
    //                 ORDER BY created_at
    //                  " ;

    //ph time
        date_default_timezone_set('Asia/Manila');
        $current_date = date("Y-m-d");
        $current_year = date("Y");
    //end of ph time


    // get monthly sales
    $condition = " order_status ='delivered' ";
    if(isset($_POST['from']) && isset($_POST['to'])){
        $from = $_POST['from'];
        $to = $_POST['to'];
        $condition .= " AND updated_at BETWEEN '$from' AND '$to' ";
    }

    $get_monthly_sales_sql = "
        SELECT date_format(updated_at,'%M') as month,SUM(availed_amount) AS total_sales
        FROM order_tbl
        LEFT JOIN availed_product_tbl
        ON order_tbl.order_id = availed_product_tbl.order_id 
        WHERE 
        $condition
        AND order_payment!=0
        GROUP BY year(updated_at),month(updated_at)
        ORDER BY year(updated_at),month(updated_at)
    ";

    $result = mysqli_query($con,$get_monthly_sales_sql);
    $get_monthly_sales=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        // $subdata[] = $last_week_start;
        // $subdata[] = $last_week_end;
        $subdata[] = $row['month'];
        $subdata[] = $row['total_sales'];

        $get_monthly_sales[]=$subdata;

    }

    // end of monthly sales


    
    $json_data = [
        'get_monthly_sales' => $get_monthly_sales,
        'from' => $from,
        'to' => $to,
    ];

    // mysqli_close($con);

    echo json_encode($json_data);
?>