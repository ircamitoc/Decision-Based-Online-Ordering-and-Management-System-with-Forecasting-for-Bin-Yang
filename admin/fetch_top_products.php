<?php 

    include('db_connection.php');

    $request=$_REQUEST;
    $col = array(
        0 => 'product',
        1 => 'product_price',
        2 => 'total_sales',
        3 => 'total_sales',
    );

    //count results
    $sql="
    SELECT *,SUM(availed_quantity) as total_sales 
    FROM `products_tbl`
    LEFT JOIN availed_product_tbl
    ON products_tbl.product = availed_product_tbl.availed_product
    LEFT JOIN  order_tbl
    ON availed_product_tbl.order_id = order_tbl.order_id
    WHERE order_tbl.order_status='delivered'
    AND order_payment>0
    GROUP BY product
    ";
    
    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql = "
        SELECT *,SUM(availed_quantity) as total_sales 
        FROM `products_tbl`
        LEFT JOIN availed_product_tbl
        ON products_tbl.product = availed_product_tbl.availed_product
        LEFT JOIN  order_tbl
        ON availed_product_tbl.order_id = order_tbl.order_id
        WHERE order_tbl.order_status='delivered'
        AND order_payment>0
        GROUP BY product
    ";

    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    
    //order
    $sql .=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";
    
    $query=mysqli_query($con,$sql);

    $data=array();

    while($row=mysqli_fetch_array($query)){
        $subdata=array();
        // $get_product_sales_sql="SELECT COUNT(availed_quantity) as total_sales FROM availed_product_tbl WHERE availed_product='$row[1]' ";
        // $get_product_query=mysqli_query($con,$get_product_sales_sql);
        // $get_product=mysqli_fetch_array($get_product_query);

        if (!file_exists('assets/img/'.$row[4])) {
            $row[4]="<img src='assets/img/default.png' style='width:40px;height:40px;'  class='rounded-circle'>";
        }else{
            $row[4]="<img src='assets/img/$row[4]' width='40px' height='40px' class='rounded-circle'>";
        }
        $subdata[]=$row[4].' '.$row[1];//product
        $subdata[]="₱". number_format($row[2], 2, ".", ",");//price
        if($row[13]==""){
            $row[13]=0;
        }
        $subdata[]=$row[28]." sold";//total sales
        // $subdata[]="<a href='#top_product_details' class='text-muted' ><i class='fas fa-search'></i></a>";//order_discount

        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              => intval($request['draw']),
        "recordsTotal"      => intval($totalData),
        "recordsFiltered"   => intval($totalFilter),
        "data"              => $data
    );

    function dateTimeToReadableDate($date){
        if($date=='0000-00-00 00:00:00' || $date ==null){
            $new_date='';
        }else{
            $date = date_create($date);
            $new_date =  date_format($date, 'D, M j, Y G:i:s');
        }

        return $new_date;
    }

    echo json_encode($json_data);
?>