<?php 

    include('db_connection.php');

    $request=$_REQUEST;
    $col = array(
        0 => 'activity_id',
        1 => 'username',
        2 => 'action',
        3 => 'created_at',
        4 => 'description',
    );

    //count results
    $sql="SELECT * FROM activity_logs 
            LEFT JOIN  users_tbl
            ON activity_logs.user_id = users_tbl.user_id
            WHERE is_active=1 ";
    if(!empty($request['search']['value'])){
        $sql .= " AND (activity_id LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR username LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR action LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR created_at LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR description LIKE '%". $request['search']['value']."%' )";
    }
    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql="SELECT * FROM activity_logs 
            LEFT JOIN  users_tbl
            ON activity_logs.user_id = users_tbl.user_id
            WHERE is_active=1 ";

    if(!empty($request['search']['value'])){
        $sql .= " AND (activity_id LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR username LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR action LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR created_at LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR description LIKE '%". $request['search']['value']."%' )";
    }
    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    
    //order
    $sql .=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";
    
    $query=mysqli_query($con,$sql);

    $data=array();

    while($row=mysqli_fetch_assoc($query)){
        $subdata=array();
    
        $subdata[]=$row['activity_id'];//
        $subdata[]=$row['username'];//
        $subdata[]=$row['action'];//
        $subdata[]="<nobr>".dateTimeToReadableDate($row['created_at'])."</nobr>";//
        $subdata[]=$row['description'];//

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