<?php 

    include('db_connection.php');

    $request=$_REQUEST;
    $col = array(
        0 => 'updated_at',
        1 => 'availed_product',
        2 => 'order_by',
        3 => 'availed_quantity',
        4 => 'availed_price',
        5 => 'availed_amount',
    );

    $search_global_custom = $_POST['global_search'];

    $condition = " 
                1=1 
                AND order_status = 'delivered' 
                AND order_payment>0
    ";
    if(empty($search_global_custom)){

        $search_date = $_REQUEST['columns'][0]['search']['value'];
        $search_product = $_REQUEST['columns'][1]['search']['value'];
        $search_order_by = $_REQUEST['columns'][2]['search']['value'];
       
        
        $search = array(
            'date' =>  ($search_date!='')?$search_date:'',
            'product' =>  ($search_product!='')?$search_product:'ALL',
            'order_by' =>  ($search_order_by!='')?$search_order_by:'ALL',
        );


        if($search['product'] != 'ALL'){

            $condition .= ' AND (';

            $product = str_replace(",", "','", $search['product']);

            $condition .= "availed_product IN ('$product') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        if($search['order_by'] != 'ALL'){

            $condition .= ' AND (';

            $order_by = str_replace(",", "','", $search['order_by']);

            $condition .= "order_by IN ('$order_by') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        $condition .= ($search['date'] != '')? " AND DATE(updated_at) BETWEEN '".substr($search['date'], 0,10)."' AND '".substr($search['date'], 11,10)."' " : '';


    }else{
        $condition .= " AND (";
        $condition .= "updated_at LIKE '%".$search_global_custom."%' ";
        $condition .= "OR availed_product LIKE '%".$search_global_custom."%' ";
        $condition .= "OR order_by LIKE '%".$search_global_custom."%' ";
        $condition .= ")";
    }

    //count results
    $sql="
        SELECT *
        FROM order_tbl 
        LEFT JOIN availed_product_tbl 
        ON order_tbl.order_id = availed_product_tbl.order_id 
        WHERE $condition
    ";

    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql = "
        SELECT *
        FROM order_tbl 
        LEFT JOIN availed_product_tbl 
        ON order_tbl.order_id = availed_product_tbl.order_id 
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
     
        // $subdata[]='<a href="#updateproduct" class="btn btn-primary btn-sm update_product text-left w-100 text-center" data-toggle="modal" data-target="#view-sales-modal"><i class="far fa-edit "></i></a>';
        
        // $subdata[]=$row[0];//id
        // $subdata[]=substr($search['date'], 0,10);//availed_product
        // $subdata[]=substr($search['date'], 11,10);//order_by
        // $subdata[]=$search_global_custom;//availed_product
        
        $subdata[]="<nobr>".dateTimeToReadableDate($row[7])."</nobr>";//date 
        $subdata[]=$row[16];//availed_product

            //add-ons details
            $availed_product = $row[16];
            $add_ons_list_query = "
                SELECT * 
                FROM add_ons_tbl
                WHERE order_id = $row[0]
                AND product='$availed_product' 
                AND availed_id=$row[15]
            ";
            $add_ons_list = '';
            $add_ons_total = 0;
            $add_ons_result_list = $con->query($add_ons_list_query);
            if ($add_ons_result_list->num_rows>0) {
                while ($add_ons_row = $add_ons_result_list->fetch_assoc()){
                    $add_ons_list .= $add_ons_row['add_ons']."<br>";
                    $add_ons_total += $add_ons_row['add_ons_price'];
                }
            }

            $add_ons_display = '';
            if($add_ons_total>0){
                $add_ons_display = "<br> + ₱".str_replace('.00', '', number_format($add_ons_total, 2, '.', '')) . " add ons";
            }
        $subdata[]=$add_ons_list;//add-ons

        $subdata[]=$row[1];//order_by
        $subdata[]=$row[18];//availed_quantity
        $subdata[]="₱ ".str_replace('.00', '', number_format($row[17], 2, '.', '')) . $add_ons_display;//availed_price 
        $subdata[]="₱ ".str_replace('.00', '', number_format($row[19]+$add_ons_total, 2, '.', ''));//availed_amount 
        
        
        $total_sales += $row[19] + $add_ons_total;
        // $total_sales += $add_ons_total;
        // $subdata[]=$total_sales;

        $data[]=$subdata;
        
    }
       

    $json_data=array(
        "draw"              => intval($request['draw']),
        "recordsTotal"      => intval($totalData),
        "recordsFiltered"   => intval($totalFilter),
        "data"              => $data,
        "total" => "₱ ".str_replace('.00', '', number_format($total_sales, 2, '.', ''))
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