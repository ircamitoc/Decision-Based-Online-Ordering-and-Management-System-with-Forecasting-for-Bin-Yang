<?php 

    include('header.php'); 

    if(!isset($_SESSION['username'])){
        echo '<script> 
            window.location = "login.php";
        </script> '; 
    }

    //count pending orders
    $sql = "SELECT COUNT(*) AS pending_order FROM order_tbl WHERE order_status='pending'";
    $query=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($query);
    $pending_order = $row['pending_order'];

    //count preparing orders
    $sql = "SELECT COUNT(*) AS pending_order FROM order_tbl WHERE order_status='preparing'";
    $query=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($query);
    $preparing_order = $row['pending_order'];

    //count delivering orders
    $sql = "SELECT COUNT(*) AS pending_order FROM order_tbl WHERE order_status='delivering'";
    $query=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($query);
    $delivering_order = $row['pending_order'];

    //count delivered orders
    $sql = "SELECT COUNT(*) AS pending_order FROM order_tbl WHERE order_status='delivered'";
    $query=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($query);
    $delivered_order = $row['pending_order'];

    //count delivered orders
    $sql = "SELECT COUNT(*) AS pending_order FROM order_tbl WHERE order_status='cancelled'";
    $query=mysqli_query($con,$sql);
    $row=mysqli_fetch_array($query);
    $cancelled_order = $row['pending_order'];



?>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Order Management</li>
                    </ol>
                </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="pending_order"><?= $pending_order ?></h3>
                                <p>New Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                                <!-- <a href="/admin/order_management.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                    </div>

                    <div class="col-lg-2 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="preparing_order"><?= $preparing_order ?></h3>
                                <p>Preparing</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-bulb"></i>
                            </div>
                                <!-- <a href="/admin/order_management.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                    </div>

                    <div class="col-lg-2 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="delivering_order"><?= $delivering_order ?></h3>
                                <p>Delivering</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-android-bicycle"></i>
                            </div>
                                <!-- <a href="/admin/order_management.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                    </div>

                    <div class="col-lg-2 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="delivered_order"><?= $delivered_order ?></h3>
                                <p>Delivered</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-home-outline"></i>
                            </div>
                                <!-- <a href="/admin/order_management.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="cancelled_order"><?= $cancelled_order ?></h3>
                                <p>Cancelled</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-backspace"></i>
                            </div>
                                <!-- <a href="/admin/order_management.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

       

        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h3 class="card-title">Inventory</h3> -->
                        <!-- <button type="button" class="btn  j-orange j-btn float-left" data-toggle="modal" data-target="#create-user-modal">
                            <i class="fa fa-solid fa-plus"></i> Create Order
                        </button> -->
                        <button type="button" class="btn  j-orange j-btn mx-1 float-left" data-toggle="modal" data-target="#filter-order-modal" title="Filter"><i class="fa fa-filter"></i></button>
                        <button type="submit" class="btn  j-orange j-btn  mx-1 float-left clear_btn" title="Refresh table"><i class="ion-refresh "></i></button>
                        <input type="text" class="form-control col-3 mx-1 float-left" placeholder="Search..." id="sales_global_search_field">

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <table id="order_table" class="table table-bordered table-striped table-hover ">
                        <thead>
                        <tr>
                            <th width="40px">Action</th>
                            <th>Order&nbsp;Id</th>
                            <th>Order&nbsp;By</th>
                            <th>Order&nbsp;Discount</th>
                            <th>Order&nbsp;Amount</th>
                            <th>Order&nbsp;Payment</th>
                            <th>Order&nbsp;Change</th>
                            <th>Order&nbsp;Date</th>
                            <th>Date&nbsp;Updated</th>
                            <th>Order&nbsp;status</th>
                            <th>Payment&nbsp;Method</th>
                            <th>Delivery&nbsp;Address</th>
                            <th>Order&nbsp;Message</th>
                            <th>Proof&nbsp;of&nbsp;Payment</th>
                            <th>Payment&nbsp;Status</th>
                        </tr>
                        </thead>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    
    </div>
    <!-- /.content-wrapper -->

    <!-- add modal -->
    <div class="modal fade" id="create-user-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Create User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <form action="process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="card " >
                                <div class="card-body">
                                    <div class="form-group">
                                    <!-- <label for="exampleInputEmail1">Username</label> -->
                                        <input type="text" class="form-control" id="Username" placeholder="Enter Username" name="username" >
                                    </div>
                                    <div class="form-group">
                                        <!-- <label for="exampleInputPassword1">Password</label> -->
                                        <input type="password" class="form-control" id="Password" placeholder="Password" name="password" >
                                    </div>
                                    <div class="form-group">
                                        <!-- <label for="exampleInputPassword1">Confirm Password</label> -->
                                        <input type="password" class="form-control" id="Password2" placeholder="Confirm Password" name="password2" >
                                    </div>
                                    <div class="form-group">
                                        <!-- <label for="exampleInputPassword1">Confirm Password</label> -->
                                        <select name="access_level" id="" class="form-control">
                                            <option value="">Select Access Level</option>
                                            <option value="admin">admin</option>
                                            <option value="staff">staff</option>
                                            <option value="owner">owner</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Profile Photo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"  id="profile_photo" accept="image/gif, image/jpeg, image/png" name="image"> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <!-- justify-content-between -->
                        <button type="button" class="btn j-orange j-btn" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn j-green j-btn" name="create_user">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- update modal -->
    <div class="modal fade" id="update-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Update Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <!-- <form action="process.php" method="POST" enctype="multipart/form-data"> -->
                    <div class="modal-body">
                        <div class="card " >
                                <div class="card-body update_order_modal">
                                    <div class="form-group">
                                    <label for="exampleInputEmail1">Order ID</label>
                                        <input type="hidden" class="form-control" id="Update_Order_id"   >
                                        <input type="text" class="form-control" id="get_Update_Order_id"  disabled>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label for="exampleInputFile">Order By</label><br>
                                        <input type="text" class="form-control" id="Update_Order_by"  disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Order Discount</label><br>
                                        <input type="number" class="form-control" id="Update_Order_discount" name="Update_Order_discount" oninput="this.value = this.value.replace(/[^.0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Order Amount</label><br>
                                        <input type="hidden" class="form-control" id="get_Update_Order_amount"   disabled>
                                        <input type="number" class="form-control" id="Update_Order_amount" name="Update_Order_amount"  disabled>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputFile">Order Payment</label><br>
                                        <input type="number" class="form-control" id="Update_Order_payment" name="Update_Order_payment"  oninput="this.value = this.value.replace(/[^.0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Order Change</label><br>
                                        <input type="number" class="form-control" id="Update_Order_change" name="Update_Order_change"  disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Order Date</label><br>
                                        <input type="text" class="form-control" id="Update_Order_date"   disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Date Updated</label><br>
                                        <input type="text" class="form-control" id="Update_Order_date_updated"  disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Order Status</label><br>
                                        <select name="Update_Order_status" id="Update_Order_status" class="form-control" >
                                            <option value="">Select Order Status</option>
                                            <!-- <div style="text-transform: uppercase"> -->
                                                <option value="on-going">on-going</option>
                                                <option value="pending">received</option>
                                                <option value="preparing">preparing</option>
                                                <option value="delivering">on the way</option>
                                                <option value="delivered">delivered</option>
                                                <option value="cancelled">cancelled</option>
                                            <!-- </div> -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Payment Method</label><br>
                                        <select name="Update_Order_payment_method" id="Update_Order_payment_method" class="form-control" >
                                            <option value="">Select Payment Method</option>
                                            <option value="Cashier">Cashier</option>
                                            <option value="Cash-on-Delivery">Cash-on-Delivery</option>
                                            <option value="Gcash">GCash</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Delivery Address</label><br>
                                        <input type="text" class='form-control' id='update_delivery_address' disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Order Message</label><br>
                                        <input type="text" class='form-control' id='update_order_message' disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Proof of Payment</label><br>
                                        <a href="#" id='update_anchor_payment' target="newTab"><img id='update_image_payment' width="100px"></a>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputFile">Payment Status</label><br>
                                        <select class='form-control' id="update_payment_status">
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approve</option>
                                            <option value="declined">Decline</option>
                                            <option value="refunded">Refunded</option>
                                        </select>
                                    </div>


                                </div>
                                <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <!-- justify-content-between -->
                        <button type="button" class="btn j-orange j-btn" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn j-green j-btn submit_update_order" >Update</button>
                    </div>
                <!-- </form> -->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

     <!-- filter modal -->
     <div class="modal fade" id="filter-order-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Filter Order Management</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <!-- <form class="customFilter" > -->
                    <div class="modal-body">
                        <div class="card " >
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="product">Order Date</label>
                                        <input type="hidden" class="date_filter">
                                        <div id="reportrange" class="pull-left " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                            <i class="glyphicon glyphicon-calendar fas fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="product">Order ID</label>
                                        <select id="order_id_filter" class="form-control order_id_filter" style="width:100%;" multiple>
                                            <?php 
                                                $query = "SELECT order_id FROM order_tbl ORDER BY order_id DESC";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['order_id']?>"><?=$row['order_id']?></option>
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="" >No Record Found</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="product">Order By</label>
                                        <select id="user_filter" class="form-control user_filter" style="width:100%;" multiple>
                                            <?php 
                                                $query = "SELECT username FROM users_tbl ";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['username']?>"><?=$row['username']?></option>
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="" >No Record Found</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="product">Order Status</label>
                                        <select id="order_status_filter" class="form-control order_status_filter" style="width:100%;" multiple>
                                            <?php 
                                                $query = "SELECT DISTINCT(order_status) FROM order_tbl ";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['order_status']?>"><?=$row['order_status']?></option>
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="" >No Record Found</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="product">Payment Status (online GCASH users)</label>
                                        <select id="payment_status_filter" class="form-control payment_status_filter" style="width:100%;" multiple>
                                            <?php 
                                                $query = "SELECT DISTINCT(payment_status) FROM order_tbl ";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['payment_status']?>"><?=$row['payment_status']?></option>
                                                    <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <option value="" >No Record Found</option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <!-- justify-content-between -->
                        <button type="button" class="btn j-orange j-btn" data-dismiss="modal">Cancel</button>
                        <!-- <button type="submit" class="btn j-green j-btn export_sales" >Export</button> -->
                        <button type="submit" class="btn j-green j-btn filter_order" >Filter</button>
                    </div>
                <!-- </form> -->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

  

</body>

<?php include('footer.php'); ?>

<script>
    
    $(function () {

        // script to get the current pending orders
        function getdata(){
            $.ajax({
            type: 'post',
            url: 'get_order_count.php',
            success: function (response) {
                // console.log(response);
                // $('#pending_order').text(response);

                // gawing json data maya.
                // para maraming data makuha sa isang page
                var obj = JSON.parse(response);
                // console.log(obj);
                // console.log(response);
                $('#pending_order').text(obj.pending_order);
                $('#preparing_order').text(obj.preparing_order);
                $('#delivering_order').text(obj.delivering_order);
                $('#delivered_order').text(obj.delivered_order);
                $('#cancelled_order').text(obj.cancelled_order);
            }
            });
        }

        setInterval(function () {getdata()}, 1000);

        $('#image').on('change',function(){
            // output raw value of file input
            $('#filename').html($(this).val().replace(/.*(\/|\\)/, '')); 

            // or, manipulate it further with regex etc.
            var filename = $(this).val().replace(/.*(\/|\\)/, '');
            // .. do your magic
            console.log(filename);
            $('#filename').html(filename);
            $('#get_filename').val(filename);
        });

        

        console.log('order management');
        var order_management_table = $('#order_table').DataTable({
            "processing":true,
            "serverSide": true,
            scrollX:true,
            scrollY:'50vh',
            // "ordering":false,
            "pageLength": 10,
            "pagingType": "numbers",
            lengthMenu:[[5,10,25,50,100,500],[5,10,25,50,100,500]],
            order: [[ 1, "DESC" ]],
            "ajax":{
                url:"fetch_order_list.php",
                type:"post",
                data:function(data){
                    data.global_search = $('#sales_global_search_field').val();
                },
                error:function(e){
                    console.log(e);
                }
            },  
            "columnDefs": [ 
            {
                "targets": 0,
                "orderable": false,
                // "width": "25%", 
            },
            {
                "targets": 1,
                "className": "order_id",
            },
            {
                "targets": 5,
                // "orderable": false,
            },
           
            ]
            ,initComplete: function(){
                $('.dataTables_filter').css('display','none');
            }

            
        });//end of #inventory_table

        function searchFields(){
            order_management_table.columns(7).search( '' ).draw();
            order_management_table.columns(1).search( '' ).draw();
            order_management_table.columns(2).search( '' ).draw();
            order_management_table.columns(9).search( '' ).draw();
            order_management_table.columns(14).search( '' ).draw();
        }

        // search on keyup
        $(document).on('keyup','#sales_global_search_field',function(e){
            searchFields();
            console.log($('#sales_global_search_field').val())
        });

        $(document).on('click','.clear_btn',function(){
            $('#sales_global_search_field').val('');
            searchFields();
        });


        $(document).on('click','.update_order', function  (e) {
            e.preventDefault();
            var order_id = $(this).closest('tr').find('.order_id').text();
            console.log(order_id);

            $.ajax({
            method: "POST",
            url: "process.php",
            data: {
                'order_id' : order_id
            },
            success: function (response) {
                // console.log(response); //for debug
                var obj = JSON.parse(response);
                // console.log(obj); //for debug

                $('#Update_Order_id').val(obj.order_id);
                $('#get_Update_Order_id').val(obj.order_id);
                $('#Update_Order_by').val(obj.order_by);
                $('#Update_Order_discount').val(obj.order_discount);
                $('#get_Update_Order_amount').val(obj.order_amount);
                $('#Update_Order_amount').val(obj.order_amount);
                $('#Update_Order_payment').val(obj.order_payment);
                $('#Update_Order_change').val(obj.order_change);
                $('#Update_Order_date').val(obj.order_date);
                $('#Update_Order_date_updated').val(obj.updated_at);
                $('#Update_Order_status').val(obj.order_status);
                $('#Update_Order_payment_method').val(obj.payment_method);
                $('#update_delivery_address').val(obj.delivery_address);
                $('#update_order_message').val(obj.order_message);

                $('#update_anchor_payment').attr("href", "assets/img/"+obj.proof_of_payment);
                $('#update_image_payment').attr("src", "assets/img/"+obj.proof_of_payment);


                

               

                $('#update_payment_status').val(obj.payment_status);
                if(obj.payment_status=="approved"){
                    $('#Update_Order_discount').prop('disabled',true);
                }else{
                    if(obj.order_status=="delivering" || obj.order_status=="delivered" || obj.order_status=="cancelled"){
                        $('#Update_Order_discount').prop('disabled',true);
                    }else{
                        $('#Update_Order_discount').prop('disabled',false);
                    }
                }
                
            }
            });
        });

        $(document).on('click','.submit_update_order', function  (e) {
            e.preventDefault();
            // console.log('update_order_id');
            $.ajax({
                method: "POST",
                url: "process.php",
                data: {
                    'submit_update_order' : 1,
                    'Update_Order_id' : $('#Update_Order_id').val(),
                    'Update_Order_amount' : $('#Update_Order_amount').val(),
                    'Update_Order_discount' : $('#Update_Order_discount').val(),
                    'Update_Order_payment' : $('#Update_Order_payment').val(),
                    'Update_Order_change' : $('#Update_Order_change').val(),
                    'Update_Order_status' : $('#Update_Order_status').val(),
                    'Update_Order_payment_method' : $('#Update_Order_payment_method').val(),
                    'update_payment_status' : $('#update_payment_status').val(),
                },
                success: function (response) {
                    console.log(response); //for debug
                    $('#update-modal').modal('hide');
                    $("#order_table").DataTable().ajax.reload();
                }
            });
        });


        $(document).on('click','.remove_btn', function  (e) {
            e.preventDefault();
            var remove_order_id = $(this).data('id');
            console.log(remove_order_id);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this order!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method: "POST",
                        url: "process.php",
                        data: {
                            'remove_order_id' : remove_order_id
                        },
                        success: function (response) {
                            // console.log(response);
                            // swal({
                            //     icon: "success",
                            // });
                            // window.location='inventory.php';
                            swal("Order transaction has been removed", {
                                icon: "success",
                            });
                            $("#order_table").DataTable().ajax.reload();
                        }
                    });
                   
                } 
                // else {
                //     swal("Your imaginary file is safe!");
                // }
            });
           
        });

        $(document).on('keyup','.update_order_modal', function  (e) {
            console.log("update_order_modal");

            var Update_Order_discount   = $("#Update_Order_discount").val();
            var Update_Order_amount     = $("#get_Update_Order_amount").val();
            var Update_Order_payment    = $("#Update_Order_payment").val();
            var Update_Order_change     = $("#Update_Order_change").val();

            total_Update_Order_amount = Update_Order_amount - Update_Order_discount;
            Update_Order_change = Update_Order_payment - total_Update_Order_amount;
            $("#Update_Order_amount").val(total_Update_Order_amount);
            if(Update_Order_payment!=0){
                $("#Update_Order_change").val(Update_Order_change);
            }else{
                $("#Update_Order_change").val(0);

            }


        });


        // date time picker
        $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });


        var start = moment();
        var end = moment();
        var from_date,to_date;

        function cb(start, end) 
        {
            $('#reportrange span, #reportrange2 span, #reportrange3 span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
            from_date = start.format('YYYY-MM-DD');
            to_date = end.format('YYYY-MM-DD');
            console.log(from_date +' '+to_date);
            
            $('.date_filter').val(from_date +' '+to_date)

        }

        $('#reportrange, #reportrange2 , #reportrange3').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment()],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            }
        }, cb);

        //select2 select_customer
        $('select.order_id_filter, select.user_filter, select.order_status_filter, select.payment_status_filter ').select2({
            // dropdownParent: $('#filter-sales-modal'),
            theme: 'classic',
            closeOnSelect:false,
            // minimumInputLength: 2,
            // multiple: true,
        });

       

        // $('form.customFilter').on('submit',function(e){
        $('.filter_order').on('click',function(e){
            e.preventDefault();
            console.log('customFilter');
            order_management_table.columns(7).search( $('.date_filter').val() ).draw();
            order_management_table.columns(1).search( $('#order_id_filter').val() ).draw();
            order_management_table.columns(2).search( $('#user_filter').val() ).draw();
            order_management_table.columns(9).search( $('#order_status_filter').val() ).draw();
            order_management_table.columns(14).search( $('#payment_status_filter').val() ).draw();
            // console.log($('#product_filter').val());
            console.log($('.date_filter').val());
            console.log($('#order_id_filter').val());
            console.log($('#user_filter').val());
            console.log($('#order_status_filter').val());
            console.log($('#payment_status_filter').val());
            $('#filter-order-modal').modal('hide');
        });
        

    });
</script>


