<?php 

    include('db_connection.php');

    $request=$_REQUEST;
    $col = array(
        0 => 'user_id',
        1 => 'username',
        2 => 'access_level',
        3 => 'date_created',
        4 => 'full_name',
    );

    //count results
    $sql="SELECT * FROM users_tbl WHERE is_active=1 ";
    if(!empty($request['search']['value'])){
        $sql .= " AND (username LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR user_id LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR access_level LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR date_created LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR full_name LIKE '%". $request['search']['value']."%' )";
    }
    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql = "SELECT * FROM users_tbl WHERE is_active=1 ";

    if(!empty($request['search']['value'])){
        $sql .= " AND (username LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR user_id LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR access_level LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR date_created LIKE '%". $request['search']['value']."%' ";
        $sql .= " OR full_name LIKE '%". $request['search']['value']."%' )";
    }
    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    
    //order
    $sql .=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";
    
    $query=mysqli_query($con,$sql);

    $data=array();

    while($row=mysqli_fetch_array($query)){
        $subdata=array();
        
        if($session_access=="owner" || $session_access=="admin"){

            $subdata[]='    

                        <div class="dropdown d-flex justify-content-center">
                            <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            <div class="dropdown-menu bg-secondary p-2 rounded " aria-labelledby="dropdownMenuButton"  >
                                <li >
                                    <a href="#updateproduct" class="btn btn-primary btn-sm update_user text-left w-100" data-toggle="modal" data-target="#update-modal"><i class="far fa-edit"></i> Update</a></a>
                                </li>
                                <li class="mt-1" >
                                    <a href="#updateproduct" class="btn btn-danger btn-sm remove_btn text-left w-100" data-id="'.$row[0].'"><i class="fa fa-ban"></i> Remove</a>
                                </li>
                            </div>
                        </div>
                            
                        ';
        }  //end if
        
        $subdata[]=$row[0];//id
        // $subdata[]=$session_access;//id
        $subdata[]=$row[1];//username
        $subdata[]=$row[3];//access_level
        $subdata[]=$row[4];//access_level
        
        if(!file_exists("assets/img/{$row[5]}") || $row[5]==""){
            $subdata[]="<a href='assets/img/default.png' target='newTab'><img src='assets/img/default.png' width='100px' height='100px'></a>";//image
        }else{
            $subdata[]="<a href='assets/img/{$row[5]}' target='newTab'><img src='assets/img/{$row[5]}' width='100px' height='100px'></a>";//image
        }

        $subdata[]=$row[6];//is_active


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