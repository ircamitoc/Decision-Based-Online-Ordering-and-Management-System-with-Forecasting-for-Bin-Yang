<?php 

    include('db_connection.php');

    $request=$_REQUEST;
    $col = array(
        0 => 'rate_id',
        1 => 'order_id',
        2 => 'product',
        3 => 'comment',
        4 => 'ratings',
        5 => 'rating_date',
        6 => 'rate_username',
        7 => 'rating_image',
    );

    $search_global_custom = $_POST['global_search'];

    $condition = " 
                1=1 
    ";

    if(empty($search_global_custom)){

        $rate_id = $_REQUEST['columns'][0]['search']['value'];
        $order_id = $_REQUEST['columns'][1]['search']['value'];
        $product = $_REQUEST['columns'][2]['search']['value'];
        $comment = $_REQUEST['columns'][3]['search']['value'];
        $ratings = $_REQUEST['columns'][4]['search']['value'];
        $rating_date = $_REQUEST['columns'][5]['search']['value'];
        $rate_username = $_REQUEST['columns'][6]['search']['value'];
       
        
        $search = array(
            'rate_id' =>  ($rate_id!='')?$rate_id:'ALL',
            'order_id' =>  ($order_id!='')?$order_id:'ALL',
            'product' =>  ($product!='')?$product:'ALL',
            'comment' =>  ($comment!='')?$comment:'ALL',
            'ratings' =>  ($ratings!='')?$ratings:'ALL',
            'rating_date' =>  ($rating_date!='')?$rating_date:'ALL',
            'rate_username' =>  ($rate_username!='')?$rate_username:'ALL',
        );


        if($search['rate_id'] != 'ALL'){

            $condition .= ' AND (';

            $rate_id = str_replace(",", "','", $search['rate_id']);

            $condition .= "rate_id IN ('$rate_id') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        if($search['order_id'] != 'ALL'){

            $condition .= ' AND (';

            $order_id = str_replace(",", "','", $search['order_id']);

            $condition .= "order_id IN ('$order_id') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        
        if($search['product'] != 'ALL'){

            $condition .= ' AND (';

            $product = str_replace(",", "','", $search['product']);

            $condition .= "product IN ('$product') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        
        if($search['comment'] != 'ALL'){

            $condition .= ' AND (';

            $comment = str_replace(",", "','", $search['comment']);

            $condition .= "comment IN ('$comment') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        
        if($search['ratings'] != 'ALL'){

            $condition .= ' AND (';

            $ratings = str_replace(",", "','", $search['ratings']);

            $condition .= "ratings IN ('$ratings') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        
        if($search['rate_username'] != 'ALL'){

            $condition .= ' AND (';

            $rate_username = str_replace(",", "','", $search['rate_username']);

            $condition .= "rate_username IN ('$rate_username') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        // $condition .= ($search['rating_date'] != '')? " AND DATE(rating_date) BETWEEN '".substr($search['rating_date'], 0,10)."' AND '".substr($search['rating_date'], 11,10)."' " : '';


    }else{
        $condition .= " AND (";
        $condition .= "rate_id LIKE '%".$search_global_custom."%' ";
        $condition .= "OR order_id LIKE '%".$search_global_custom."%' ";
        $condition .= "OR product LIKE '%".$search_global_custom."%' ";
        $condition .= "OR comment LIKE '%".$search_global_custom."%' ";
        $condition .= "OR ratings LIKE '%".$search_global_custom."%' ";
        $condition .= "OR rating_date LIKE '%".$search_global_custom."%' ";
        $condition .= "OR rate_username LIKE '%".$search_global_custom."%' ";
        $condition .= ")";
    }

    //count results
    $sql="
        SELECT * 
        FROM rates_tbl
        LEFT JOIN products_tbl 
        ON rates_tbl.product_id = products_tbl.product_id
        WHERE $condition
    ";

    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql = "
        SELECT * 
        FROM rates_tbl
        LEFT JOIN products_tbl 
        ON rates_tbl.product_id = products_tbl.product_id
        WHERE $condition
    ";

    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);

    //order
    $sql .=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";
    
    $query=mysqli_query($con,$sql);

    $total_sales=0;
    $data=array();
    while($row=mysqli_fetch_array($query)){
        $subdata=array();

        $star='';
        for ($i=1; $i <=$row[4]; $i++) { 
           $star .= '<i class="fas fa-star text-warning"></i>';
        }

        $subdata[]=$row[0];//rate_id
        $subdata[]=$row[2];//order_id
        $subdata[]=$row[9];//product
        $subdata[]=$row[3];//comment
        $subdata[]="<nobr>".$star."</nobr>";//ratings
        $subdata[]=dateTimeToReadableDate($row[5]);//rating_date

        if (!file_exists('assets/img/'.$row[6])) {
            $image="assets/img/default.png";
        }else{
			$image = 'assets/img/'.$row[6];
		}

        $subdata[]="<a href='$image' target='newTab'><img src='$image' width='100px'></a>";//rating_image

        $subdata[]=$row[7];//rate_username
        // $subdata[]="<nobr>".dateTimeToReadableDate($row[5])."</nobr>";//date 

        $data[]=$subdata;
        
    }
       

    $json_data=array(
        "draw"              => intval($request['draw']),
        "recordsTotal"      => intval($totalData),
        "recordsFiltered"   => intval($totalFilter),
        "data"              => $data,
        'sql'               => $sql
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
    // echo $condtion;


?>