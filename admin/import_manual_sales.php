<?php 

include('header.php'); 

if(!isset($_SESSION['username'])){
    echo '<script> 
        window.location = "login.php";
    </script> '; 
}

?>

<?php 

    ini_set('memory_limit', '-1'); // to export many rows
    
    //ph time
    date_default_timezone_set('Asia/Manila');
    $date = date("Y-m-d G:i:s");
    $currentDate = date("Y-m-d");
    //end of ph time

    $message = '';

    $TWO_MONTHS_ERROR_COUNT = 0;
    $upload_message = "";
    $failedCount=0;
    $successCount=0;
    $Uploadmessage= '';
    $allSucess ='';
    $ISOLATION_TIME='';

    $failed_data_array = [];
    $noa_id_data_array = [];
    $username = $_SESSION['USERNAME'];

    if(isset($_POST['Import'])){
        if($_FILES['file']['name']){
            $filename = explode('.',$_FILES['file']['name']);
            if(end($filename)=='csv'){
                $CAR_Reference_No ='';
                $handle = fopen($_FILES['file']['tmp_name'],"r");
                fgetcsv($handle);//skip row 1
                while($data = fgetcsv($handle)){
                    
                    $DATE = str_replace("'", "", $data[0]);
                    $PRODUCT_ID = str_replace("'", "", $data[1]);
                    $PRODUCT_NAME = str_replace("'", "", $data[2]);
                    $PRODUCT_DETAILS = str_replace("'", "", $data[3]);
                    $PRODUCT_PRICE = str_replace("'", "", $data[4]);
                    $PRODUCT_QTY = str_replace("'", "", $data[5]);
                    $TOTAL = str_replace("'", "", $data[6]);
                   
                    // $query = "  
                    //     INSERT INTO manual_order_tbl(
                    //         manual_order_date,
                    //         manual_product_id,
                    //         manual_product_name,
                    //         manual_product_detail,
                    //         manual_product_price,
                    //         manual_product_qty,
                    //         manual_product_total
                    //     )
                    //     VALUES (
                    //         '$DATE',
                    //         '$PRODUCT_ID',
                    //         '$PRODUCT_NAME',
                    //         '$PRODUCT_DETAILS',
                    //         '$PRODUCT_PRICE',
                    //         '$PRODUCT_QTY',
                    //         '$TOTAL'
                    //     )
                    // ";

                    $query_to_order_tbl = "
                        INSERT INTO order_tbl (
                            order_by,
                            order_amount,
                            order_payment,
                            order_date,
                            updated_at,
                            order_status
                        )
                        VALUES(
                            'admin1',
                            '$TOTAL',
                            '$TOTAL',
                            '$DATE',
                            '$DATE',
                            'delivered'
                        )
                    ";
   
                    if(!mysqli_query($db, $query_to_order_tbl)){
                        echo "(ERROR) import manual order -order_tbl: ".mysqli_error($db)."<br>";
                        echo $query."<br>";
                        $Uploadmessage .= "<label class='alert alert-danger m-1 rounded p-1'>FAILED PRODUCT_ID#: ". $PRODUCT_ID."</label> <br>";
                        $failedCount+=1;
                        array_push($failed_data_array, $PRODUCT_ID); 
                    }else{ 

                        $order_id = mysqli_insert_id($db); // last inserted id

                        $query_to_order_tbl = "
                            INSERT INTO availed_product_tbl (
                                availed_product,
                                availed_price,
                                availed_quantity,
                                availed_amount,
                                order_id
                            )
                            VALUES(
                                '$PRODUCT_NAME',
                                '$PRODUCT_PRICE',
                                '$PRODUCT_QTY',
                                '$TOTAL',
                                '$order_id'
                            )
                        ";
                        if(!mysqli_query($db, $query_to_order_tbl)){
                            echo "(ERROR) import manual order -availed_product_tbl: ".mysqli_error($db)."<br>";
                            echo $query."<br>";
                            $Uploadmessage .= "<label class='alert alert-danger m-1 rounded p-1'>FAILED PRODUCT_ID#: ". $PRODUCT_ID."</label> <br>";
                            $failedCount+=1;
                            array_push($failed_data_array, $PRODUCT_ID); 
                        }else{
                            $allSucess ='<label class="alert-success  rounded p-1 m-1">File Upload successful.</label><br>';
                            $successCount+=1;
                        }

                    }
                    // echo $DATE . "<br>";
                }
                fclose($handle);
                // echo "<script>window.location='/index.php?updation=1'</script>";
                // header("location:index.php?updation=1");
            }else{
                $message = '<label class="  alert-danger mt-2 p-2 rounded"> Please select only CSV files. </label>';
            }
        }else{
            $message = "<label class=' alert-danger mt-2  p-2 rounded'>Please Select a File</label>";
        }
    }

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-bottom:500px;">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="card ">
                            <div class="card-header">
                                <h4>Upload CSV File</h4>
                            </div>
                            <div class="card-body shadow">
                                <div class="row mb-4">
                                    <div class="col-12 ">
                                        <div class="form-group">
                                        <?php 
                                            $config_base_url = 'http://'.$_SERVER['SERVER_NAME'];
                                        ?>
                                            <form action="" method="POST" enctype="multipart/form-data" >
                                                <!-- <label class="control-label">Upload CSV File </label> -->
                                                <input type="file" class="form-control shadow extra-btn " style="padding-bottom:35px;" name="file" id="file" accept=".csv">
                                                <?php if($allSucess!=''){
                                                    echo '
                                                        <label class=" alert alert-success m-1 mb-2 mt-5 rounded-pill p-1 "><span style="width:50px;height:50px;" class="p-1">Success: '.$successCount.' </span></label>
                                                        <label class=" alert alert-danger m-1 mb-2 rounded-pill p-1 "><span style="width:50px;height:50px;" class="p-1">Error(s):'.$failedCount.' </span></label><br>
                                                    ';
                                                }   
                                                ?>
                                                <?= $message; ?>
                                                <?= $allSucess; ?>
                                                <?= $Uploadmessage; ?>
                                                <div class="mt-3">
                                                    <a href="<?=$config_base_url.'/admin/sales_reports'?>"  class="btn btn-danger float-end  text-white m-2 shadow extra-btn" ><i class="fas fa-arrow-left"></i> Back</a>
                                                    <button type="submit" name="Import" id="import" class="btn btn-info float-end  text-white shadow extra-btn" value="Import"><i class="fas fa-cloud-upload-alt"></i> Import</button>
                                                </div>
                                            </form>

                                            <?php 
                                                // if($noa_id_data_array){
                                                //     echo '<script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>';
                                                //     echo "  <script>  
                                                //                 $( document ).ready(function() {
                                                //                     $('#confirmModal').modal('show');
                                                //                 });
                                                //             </script>";
                                                // }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    
    </div>
    <!-- /.content-wrapper -->

</body>

<?php include('footer.php'); ?>


