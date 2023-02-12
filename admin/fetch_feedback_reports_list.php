<?php 

    include('db_connection.php');

    $request=$_REQUEST;
    $col = array(
        0 => 'name',
        1 => 'email',
        2 => 'subject',
        3 => 'message',
        4 => 'date_created',
    );

    $search_global_custom = $_POST['global_search'];

    $condition = " 
                1=1 
    ";
    if(empty($search_global_custom)){

        $search_name = $_REQUEST['columns'][0]['search']['value'];
        $search_email = $_REQUEST['columns'][1]['search']['value'];
        $search_subject = $_REQUEST['columns'][2]['search']['value'];
        $search_message = $_REQUEST['columns'][3]['search']['value'];
        $search_date_created = $_REQUEST['columns'][4]['search']['value'];
       
        
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
        $condition .= "name LIKE '%".$search_global_custom."%' ";
        $condition .= "OR email LIKE '%".$search_global_custom."%' ";
        $condition .= "OR subject LIKE '%".$search_global_custom."%' ";
        $condition .= "OR message LIKE '%".$search_global_custom."%' ";
        $condition .= "OR date_created LIKE '%".$search_global_custom."%' ";
        $condition .= ")";
    }

    //count results
    $sql="
        SELECT *
        FROM message_tbl 
        WHERE $condition
    ";

    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql = "
        SELECT *
        FROM message_tbl 
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

        $subdata[]=$row[1];//name
        $subdata[]=$row[2];//email
        $subdata[]=$row[3];//subject
        $subdata[]=$row[4];//message
        $subdata[]="<nobr>".dateTimeToReadableDate($row[5])."</nobr>";//date 

        $data[]=$subdata;
        
    }
       

    $json_data=array(
        "draw"              => intval($request['draw']),
        "recordsTotal"      => intval($totalData),
        "recordsFiltered"   => intval($totalFilter),
        "data"              => $data,
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