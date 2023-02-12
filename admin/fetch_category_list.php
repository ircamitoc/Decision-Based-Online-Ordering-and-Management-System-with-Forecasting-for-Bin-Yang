<?php 

    include('db_connection.php');

    $request=$_REQUEST;
    $col = array(
        0 => 'category_id',
        1 => 'category_id',
        2 => 'category',
        3 => 'date_added',
        4 => 'date_updated',
        5 => 'username',
        6 => 'is_active',
    );

    //count results
    $sql="SELECT * FROM category_tbl WHERE 1=1 ";
    if(!empty($request['search']['value'])){
        $sql .= " AND (category LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR category LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR date_added LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR date_updated LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR is_active LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR username LIKE '%". $request['search']['value']."%' )";
    }
    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql = "SELECT * FROM category_tbl  WHERE 1=1 ";

    if(!empty($request['search']['value'])){
        $sql .= " AND (category LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR category LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR date_added LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR date_updated LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR is_active LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR username LIKE '%". $request['search']['value']."%' )";
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

        $action_button="";
        if($row['is_active']=="0"){
            $action_button .=' <a href="#activate_category" class="btn btn-success btn-sm activate_category_btn text-left w-100" data-id="'.$row['category_id'].'"><i class="fa fa-ban"></i> Active</a>';
        }else{
            $action_button .=' <a href="#remove_category" class="btn btn-danger btn-sm remove_category_btn text-left w-100" data-id="'.$row['category_id'].'"><i class="fa fa-ban"></i> Inactive</a>';
        }
     
        $subdata[]='    

                    <div class="dropdown d-flex justify-content-center">
                        <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu bg-secondary p-2 rounded " aria-labelledby="dropdownMenuButton"  >
                            <li >
                                <a href="#update_category" class="btn btn-primary btn-sm edit_category_btn  text-left w-100" data-toggle="modal" data-target="#update-category-modal"><i class="far fa-edit"></i> Update</a></a>
                            </li>
                            <li class="mt-1" >'.
                                $action_button.'
                            </li>
                        </div>
                    </div>
                        
                    ';
        
        $subdata[]=$row['category_id'];//id
        $subdata[]=$row['category'];//id
        $subdata[]=dateTimeToReadableDate($row['date_added']);//id
        $subdata[]=dateTimeToReadableDate($row['date_updated']);//id
        $subdata[]=$row['username'];//id

        if($row['is_active']=="0"){
            $subdata[]= "<span class='text-white bg-danger rounded p-2'><b>INACTIVE</b></span>";
        }else{
            $subdata[]= "<span class='text-white bg-success rounded p-2'><b>ACTIVE</b></span>";
        }
       
        
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