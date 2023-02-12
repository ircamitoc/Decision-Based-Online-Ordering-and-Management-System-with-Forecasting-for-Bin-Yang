<?php 

    include('db_connection.php');

    $request=$_REQUEST;
    $col = array(
        0 => 'product_id',
        1 => 'product_id',
        2 => 'product',
        3 => 'product_price',
        4 => 'product_quantity',
        5 => 'category',
        6 => 'is_active',
        7 => 'is_active',
    );

    //count results
    $sql="SELECT * FROM products_tbl WHERE 1=1 ";
    if(!empty($request['search']['value'])){
        $sql .= " AND (product LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR product_id LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR product_price LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR product_quantity LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR category LIKE '%". $request['search']['value']."%' )";
    }
    $query=mysqli_query($con,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;

    $sql = "SELECT * FROM products_tbl WHERE 1=1 ";

    if(!empty($request['search']['value'])){
        $sql .= " AND (product LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR product_id LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR product_price LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR product_quantity LIKE '%". $request['search']['value']."%' ";
        $sql .= "OR category LIKE '%". $request['search']['value']."%' )";
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

        $action_button="";
        if($row[5]=="0"){
            $action_button .=' <a href="#activate_product" class="btn btn-success btn-sm activate_product_btn text-left w-100" data-id="'.$row['0'].'"><i class="fa fa-ban"></i> Active</a>';
        }else{
            $action_button .=' <a href="#remove_product" class="btn btn-danger btn-sm remove_btn text-left w-100" data-id="'.$row[0].'"><i class="fa fa-ban"></i> Remove</a>';
        }
     
        $subdata[]='    

                    <div class="dropdown d-flex justify-content-center">
                        <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu bg-secondary p-2 rounded " aria-labelledby="dropdownMenuButton"  >
                            <li >
                                <a href="#updateproduct" class="btn btn-primary btn-sm update_product text-left w-100" data-toggle="modal" data-target="#update-modal"><i class="far fa-edit"></i> Update</a></a>
                            </li>
                            <li class="mt-1" >
                                '.$action_button.'
                            </li>
                        </div>
                    </div>
                        
                    ';
        
        $subdata[]=$row[0];//id
        $subdata[]=$row[1];//product
        $subdata[]="₱ ".str_replace('.00', '', number_format($row[2], 2, '.', ''));//price 
        if($row[3]<=10){
            //red
            $subdata[]= "<span class='text-white bg-danger rounded p-2'><b>".$row[3]."</b></span>";
        }elseif($row[3]<=20){
            //yellow
            $subdata[]= "<span class='text-white bg-warning rounded p-2'>".$row[3]."</span>";
        }else{
            //green
            $subdata[]= "<span class='text-white bg-success rounded p-2'>".$row[3]."</span>";
        }
        // $subdata[]=$row[3];//quantity
        $subdata[]=$row[6];//product
        if(!file_exists("assets/img/{$row[4]}")){
            $subdata[]="<a href='assets/img/default.png' target='newTab'><img src='assets/img/default.png' width='100px' height='100px'></a>";//image
        }else{
            $subdata[]="<a href='assets/img/{$row[4]}' target='newTab'><img src='assets/img/{$row[4]}' width='100px' height='100px'></a>";//image
        }

        if($row[5]=="0"){
            $subdata[]= "<span class='text-white bg-danger rounded p-2'><b>INACTIVE</b></span>";
        }else{
            $subdata[]= "<span class='text-white bg-success rounded p-2'><b>ACTIVE</b></span>";
        }


        // if (file_exists('images/'.$row[3])) {
        //     $subdata[]="<img src='images/".$row[3]."' alt='Product: ".$row[1]." <br>Price: ".$row[2]."' width='50px' onclick='onClick(this)'>";//image
        // } else {
        //     $subdata[]="<img src='images/default_image.jfif' width='50px' onclick='onClick(this)'>";
        // }

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