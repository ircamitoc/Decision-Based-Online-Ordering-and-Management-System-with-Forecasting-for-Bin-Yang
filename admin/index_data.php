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


    //get days of the week
    function getStartAndEndDate($week, $year) {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }

    $date = new DateTime($current_date);
    $current_week = $date->format("W");
    $ret_result = getStartAndEndDate($current_week, $current_year);
    $week_start = $ret_result['week_start'];
    $week_end = $ret_result['week_end'];

    $sqlQuery = "
        SELECT
            count(case when WEEKDAY(created_at)=6 THEN created_at END) as S,
            count(case when WEEKDAY(created_at)=0 THEN created_at END) as M,
            count(case when WEEKDAY(created_at)=1 THEN created_at END) as T,
            count(case when WEEKDAY(created_at)=2 THEN created_at END) as W,
            count(case when WEEKDAY(created_at)=3 THEN created_at END) as R,
            count(case when WEEKDAY(created_at)=4 THEN created_at END) as F,
            count(case when WEEKDAY(created_at)=5 THEN created_at END) as Sat,
            count(action) as TOTAL,
            created_at

        FROM activity_logs
        WHERE created_at BETWEEN '$week_start' AND '$week_end' 

        AND action='visit'
        ORDER BY created_at ASC 
    " ;


    $result = mysqli_query($con,$sqlQuery);
    $data=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        // $subdata[] = $week_start;
        $subdata[] = $row['S'];
        $subdata[] = $row['M'];
        // $subdata[] = $ret_result['week_start'];
        $subdata[] = $row['T'];
        $subdata[] = $row['W'];
        $subdata[] = $row['R'];
        $subdata[] = $row['F'];
        $subdata[] = $row['Sat'];
        $subdata[] = $row['TOTAL'];
        $subdata[] = $row['created_at'];
           

        $data[]=$subdata;

    }


    // ------------------------------------------------ end of get this week
    

    // ---------start of data last week
    //get days of the week
    function getStartAndEndDateLastWeek($week, $year) {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('-6 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }

    $date = new DateTime($current_date);
    $current_week = $date->format("W");
    $ret_result = getStartAndEndDateLastWeek($current_week, $current_year);
    $last_week_start = $ret_result['week_start'];
    $last_week_end = $ret_result['week_end'];

    $sqlQuery = "
        SELECT
            count(case when WEEKDAY(created_at)=6 THEN created_at END) as S,
            count(case when WEEKDAY(created_at)=0 THEN created_at END) as M,
            count(case when WEEKDAY(created_at)=1 THEN created_at END) as T,
            count(case when WEEKDAY(created_at)=2 THEN created_at END) as W,
            count(case when WEEKDAY(created_at)=3 THEN created_at END) as R,
            count(case when WEEKDAY(created_at)=4 THEN created_at END) as F,
            count(case when WEEKDAY(created_at)=5 THEN created_at END) as Sat,
            count(action) as TOTAL,
            created_at

        FROM activity_logs
        WHERE created_at BETWEEN '$last_week_end' AND '$last_week_start' 
        AND action='visit'
        ORDER BY created_at ASC 
    " ;


    $result = mysqli_query($con,$sqlQuery);
    $data2=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        // $subdata[] = $last_week_start;
        // $subdata[] = $last_week_end;
        $subdata[] = $row['S'];
        $subdata[] = $row['M'];
        $subdata[] = $row['T'];
        $subdata[] = $row['W'];
        $subdata[] = $row['R'];
        $subdata[] = $row['F'];
        $subdata[] = $row['Sat'];
        $subdata[] = $row['TOTAL'];
        $subdata[] = $row['created_at'];
           

        $data2[]=$subdata;

    }



    // --------------------get stocks
    $check_stocks_sql = "
        SELECT *
        FROM products_tbl
        WHERE product_quantity <=10
        AND is_active=1
    ";

    $result = mysqli_query($con,$check_stocks_sql);
    $check_stocks_data=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        $subdata[] = $row['product_id'];
        // $subdata[] = $row['product_quantity'];
        
        $check_stocks_data[]=$subdata;
    }
    // ------------------------------


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


    // get product ratings
    $condition = ' 1=1 ';

    $rate_count_sql = "
        SELECT SUM(rate_id) AS rate_count
        FROM rates_tbl
        LEFT JOIN products_tbl
        ON rates_tbl.product_id = products_tbl.product_id 
        WHERE 
        $condition
        GROUP BY rate_id
    ";

    $result = mysqli_query($con,$rate_count_sql);
    $get_rate_count=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        $subdata[] = $row['rate_count'];

        $get_rate_count[]=$subdata;

    }

    // end of rate

    // get 1 star ratings
    $condition = ' ratings=1  ';

    if(isset($_POST['product'])){
        $product = $_POST['product'];
        $condition .= " AND product LIKE '%$product%' ";
    }

    $rate_count_sql = "
        SELECT COUNT(ratings) AS rate_count
        FROM rates_tbl
        LEFT JOIN products_tbl
        ON rates_tbl.product_id = products_tbl.product_id 
        WHERE 
        $condition
        GROUP BY ratings
    ";

    $result = mysqli_query($con,$rate_count_sql);
    $get_rate_1_star=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        $subdata[] = $row['rate_count'];

        $get_rate_1_star[]=$subdata;

    }

    // end of rate

    
    // get 2 star ratings
   $condition = ' ratings=2  ';

    if(isset($_POST['product'])){
        $product = $_POST['product'];
        $condition .= " AND product LIKE '%$product%' ";
    }

    $rate_count_sql = "
        SELECT COUNT(ratings) AS rate_count
        FROM rates_tbl
        LEFT JOIN products_tbl
        ON rates_tbl.product_id = products_tbl.product_id 
        WHERE 
        $condition
        GROUP BY ratings
    ";

    $result = mysqli_query($con,$rate_count_sql);
    $get_rate_2_star=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        $subdata[] = $row['rate_count'];

        $get_rate_2_star[]=$subdata;

    }

    // end of rate

    
    // get 3 star ratings
    $condition = ' ratings=3  ';

    if(isset($_POST['product'])){
        $product = $_POST['product'];
        $condition .= " AND product LIKE '%$product%' ";
    }

    $rate_count_sql = "
        SELECT COUNT(ratings) AS rate_count
        FROM rates_tbl
        LEFT JOIN products_tbl
        ON rates_tbl.product_id = products_tbl.product_id 
        WHERE 
        $condition
        GROUP BY ratings
    ";

    $result = mysqli_query($con,$rate_count_sql);
    $get_rate_3_star=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        $subdata[] = $row['rate_count'];

        $get_rate_3_star[]=$subdata;

    }

    // end of rate

    // get 4 star ratings
    $condition = ' ratings=4  ';

    if(isset($_POST['product'])){
        $product = $_POST['product'];
        $condition .= " AND product LIKE '%$product%' ";
    }

    $rate_count_sql = "
        SELECT COUNT(ratings) AS rate_count
        FROM rates_tbl
        LEFT JOIN products_tbl
        ON rates_tbl.product_id = products_tbl.product_id 
        WHERE 
        $condition
        GROUP BY ratings
    ";

    $result = mysqli_query($con,$rate_count_sql);
    $get_rate_4_star=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        $subdata[] = $row['rate_count'];

        $get_rate_4_star[]=$subdata;

    }

    // end of rate

    
    // get 5 star ratings
    $condition = ' ratings=5  ';

    if(isset($_POST['product'])){
        $product = $_POST['product'];
        $condition .= " AND product LIKE '%$product%' ";
    }

    $rate_count_sql = "
        SELECT COUNT(ratings) AS rate_count
        FROM rates_tbl
        LEFT JOIN products_tbl
        ON rates_tbl.product_id = products_tbl.product_id 
        WHERE 
        $condition
        GROUP BY ratings
    ";

    $result = mysqli_query($con,$rate_count_sql);
    $get_rate_5_star=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        $subdata[] = $row['rate_count'];

        $get_rate_5_star[]=$subdata;

    }

    // end of rate

    //get products and rates
    $rate_count_sql = "
        SELECT AVG(ratings) as ave_ratings, product
        FROM products_tbl
        LEFT JOIN  rates_tbl
        ON products_tbl.product_id = rates_tbl.product_id
        WHERE ratings>=1
        GROUP BY product,category
        ORDER BY ave_ratings ASC
    ";

    $result = mysqli_query($con,$rate_count_sql);
    $get_all_rates=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        $subdata[] = $row['product'];
        $ave_ratings =  number_format((float)$row['ave_ratings'], 2, '.', '');
        $subdata[] = $ave_ratings;

        $get_all_rates[]=$subdata;
    }


    // end of get product and rates




    // get monthly sales - manual system
    $manual_condition=' 1=1 ';
    if(isset($_POST['from']) && isset($_POST['to'])){
        $from = $_POST['from'];
        $to = $_POST['to'];
        $manual_condition .= " AND manual_order_date BETWEEN '$from' AND '$to' ";
    }

    $get_monthly_manual_sales_sql = "
        SELECT date_format(manual_order_date,'%M') as month,SUM(manual_product_total) AS total_sales
        FROM manual_order_tbl
        WHERE 
        $manual_condition
        GROUP BY year(manual_order_date),month(manual_order_date)
        ORDER BY year(manual_order_date),month(manual_order_date)
    ";

    $result = mysqli_query($con,$get_monthly_manual_sales_sql);
    $get_monthly_manual_sales_sql=array();
    while($row=mysqli_fetch_array($result)){
        $subdata=array();

        $subdata[] = $row['month'];
        $subdata[] = $row['total_sales'];

        $get_monthly_manual_sales[]=$subdata;

    }

    // end of monthly sales - manual system


    //get total manual sales
    $sql = "SELECT SUM(manual_product_total) as manual_product_total_amount FROM manual_order_tbl  ";
    $query=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($query);
    // $product_row = $row[0];
    $manual_product_total_amount = $row['manual_product_total_amount'];
    // end of get total manual sales


    
    $json_data = [
        'data' =>  $data,
        'data2' => $data2,
        'check_stocks_data' => $check_stocks_data,
        'get_monthly_sales' => $get_monthly_sales,
        'from' => $from,
        'to' => $to,
        'get_monthly_sales_sql' => $get_monthly_sales_sql,
        'get_rate_count' => $get_rate_count,
        'get_rate_1_star' => $get_rate_1_star,
        'get_rate_2_star' => $get_rate_2_star,
        'get_rate_3_star' => $get_rate_3_star,
        'get_rate_4_star' => $get_rate_4_star,
        'get_rate_5_star' => $get_rate_5_star,
        'get_all_rates' => $get_all_rates,
        'get_monthly_manual_sales' => $get_monthly_manual_sales,
        'manual_product_total_amount' => $manual_product_total_amount,
    ];

    // mysqli_close($con);

    echo json_encode($json_data);
?>