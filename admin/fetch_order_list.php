<?php 

    include('db_connection.php');

    $request=$_REQUEST;
    $col = array(
        0 => 'order_id',
        1 => 'order_id',
        2 => 'order_by',
        3 => 'order_discount',
        4 => 'order_amount',
        5 => 'order_payment',
        6 => 'order_change',
        7 => 'order_date',
        8 => 'updated_at',
        9 => 'order_status',
        10 => 'payment_method',
        11 => 'delivery_address',
        12 => 'order_message',
        13 => 'proof_of_payment',
        14 => 'payment_status',
    );


    $search_global_custom = $_POST['global_search'];

    $condition = " 
        1=1 
        AND order_status!='on-going'
    ";

    if(empty($search_global_custom)){
        $search_date = $_REQUEST['columns'][7]['search']['value'];
        $search_order_id = $_REQUEST['columns'][1]['search']['value'];
        $search_username = $_REQUEST['columns'][2]['search']['value'];
        $search_order_status = $_REQUEST['columns'][9]['search']['value'];
        $search_payment_status = $_REQUEST['columns'][14]['search']['value'];

        $search = array(
            'date' =>  ($search_date!='')?$search_date:'',
            'order_id' =>  ($search_order_id!='')?$search_order_id:'ALL',
            'username' =>  ($search_username!='')?$search_username:'ALL',
            'order_status' =>  ($search_order_status!='')?$search_order_status:'ALL',
            'payment_status' =>  ($search_payment_status!='')?$search_payment_status:'ALL',
        );

        if($search['order_id'] != 'ALL'){

            $condition .= ' AND (';

            $order_id = str_replace(",", "','", $search['order_id']);

            $condition .= "order_id IN ('$order_id') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        if($search['username'] != 'ALL'){

            $condition .= ' AND (';

            $username = str_replace(",", "','", $search['username']);

            $condition .= "order_by IN ('$username') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        if($search['order_status'] != 'ALL'){

            $condition .= ' AND (';

            $order_status = str_replace(",", "','", $search['order_status']);

            $condition .= "order_status IN ('$order_status') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        if($search['payment_status'] != 'ALL'){

            $condition .= ' AND (';

            $payment_status = str_replace(",", "','", $search['payment_status']);

            $condition .= "payment_status IN ('$payment_status') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        $condition .= ($search['date'] != '')? " AND DATE(order_date) BETWEEN '".substr($search['date'], 0,10)."' AND '".substr($search['date'], 11,10)."' " : '';

    }else{
        $condition .= " AND (";
        $condition .= "order_date LIKE '%".$search_global_custom."%' ";
        $condition .= "OR order_id LIKE '%".$search_global_custom."%' ";
        $condition .= "OR order_by LIKE '%".$search_global_custom."%' ";
        $condition .= "OR order_status LIKE '%".$search_global_custom."%' ";
        $condition .= "OR payment_status LIKE '%".$search_global_custom."%' ";
        $condition .= ")";
    }

    //count results
    $sql="SELECT * FROM order_tbl WHERE $condition  ";
   
    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql="SELECT * FROM order_tbl WHERE $condition  ";

    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    
    //order
    $sql .=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";
    
    $query=mysqli_query($con,$sql);

    $data=array();

    while($row=mysqli_fetch_array($query)){
        $subdata=array();
     
        $subdata[]='    

                    <div class="dropdown d-flex justify-content-center">
                        <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu bg-secondary p-2 rounded " aria-labelledby="dropdownMenuButton"  >
                            <li >
                                <a href="/admin/assets/fpdf184/export_pdf?order_id='.$row[0].'" target="newTab" class="btn btn-primary btn-sm view_receipt text-left w-100" ><i class="fa fa-receipt" style="margin-right:5px;"></i>View Receipt</a></a>
                            </li>

                            <li class="mt-1" >
                                <a href="#updateproduct" class="btn btn-primary btn-sm update_order text-left w-100" data-toggle="modal" data-target="#update-modal"><i class="far fa-edit"></i> Update</a></a>
                            </li>
                            <li class="mt-1" >
                                <a href="#updateproduct" class="btn btn-danger btn-sm remove_btn text-left w-100" data-id="'.$row[0].'"><i class="fa fa-ban"></i> Remove</a>
                            </li>
                        </div>
                    </div>
                        
                    ';
        
        $subdata[]=$row[0];//order_id
        $subdata[]=$row[1];//order_by
        $subdata[]=$row[2];//order_discount
        $subdata[]=$row[3];//order_amount
        $subdata[]=$row[4];//order_payment
        $subdata[]=$row[5];//order_change
        $subdata[]=dateTimeToReadableDate($row[6]);//order_date
        $subdata[]=dateTimeToReadableDate($row[7]);//updated_at
        $subdata[]=$row[8];//order_status
        $subdata[]=$row[9];//payment_method
        $subdata[]=$row[10];//payment_method
        $subdata[]=$row[11];//payment_method
        $subdata[]=$row[12];//payment_method
        $subdata[]=$row[13];//payment_method
        $subdata[]=$row[14];//payment_method


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