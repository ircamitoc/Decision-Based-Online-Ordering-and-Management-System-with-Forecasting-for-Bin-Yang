<?php 

include('header.php'); 

if(!isset($_SESSION['username'])){
    echo '<script> 
        window.location = "login.php";
    </script> '; 
}

?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12 d-flex justify-content-center ">

                        <!-- overall sales  template-->
                        <div class="card w-100" style="max-width:700px;">
                            <div class="card-header border-0">
                                <h1 class="m-0 col-12">Sales Report</h1>
                            
                                <div class="d-flex justify-content-between">
                                    <!-- <h3 class="card-title">Overall Sales</h3> -->
                                
                                    <!-- <a href="sales_reports.php">View Report</a> -->
                                </div>

                                <div class="d-flex justify-content-between">
                                    <input type="hidden" class="date_filter">
                                    <a href="#" id="refresh_sales_filter" style="font-size:25px;margin-right:5px;" title="Refresh Graph"><i class="ion-ios-refresh text-dark" ></i></a>
                                    <div id="reportrange3" class="pull-left " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                        <span></span> <b class="caret"></b>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex" >
                                    <p class="d-flex flex-column"> 
                                    <?php 
                                        //SUM total paid sales
                                        $sql = "
                                        SELECT *,SUM(availed_amount) AS total_sales
                                        FROM order_tbl 
                                        LEFT JOIN availed_product_tbl
                                        ON order_tbl.order_id = availed_product_tbl.order_id 
                                        WHERE order_status ='delivered'
                                        AND order_payment!=0
                                        ";
                                        $query=mysqli_query($con,$sql);
                                        $row=mysqli_fetch_array($query);
                                        $total_sales = number_format($row['total_sales'], 2, ".", ",");
                                    ?>
                                    <span class="text-bold text-lg" >₱<?= $total_sales ?></span>
                                        <span>Sales Over Time </span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right" id="hide_sales_rate_on_filter">
                                        <span class="text-success" id="total_sales_percentage_this_month">
                                            <!-- <i class="fa fa-spinner fa-pulse"></i> -->
                                        </span>
                                        <span class="text-muted">Since last month</span>
                                    </p>
                                </div>
                                <!-- /.d-flex -->
                                <i class="fas fa-spinner fa-pulse" hidden></i>

                                <div class="position-relative mb-4">
                                    <canvas id="total-sales-chart" height="200"></canvas>
                                    <canvas id="total-sales-chart-filtered" height="200" hidden></canvas>
                                </div>

                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This year
                                    </span>

                                    <!-- <span>
                                    <i class="fas fa-square text-gray"></i> Last year
                                    </span> -->
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        
                    </div><!-- /.col -->
                    
                    <div class="col-sm-6" hidden>
                        <!-- overall sales  template-->
                        <h1 class="m-0 col-12">Sales Report (manual system data)</h1>

                        <div class="card">
                            <div class="card-header border-0">
                                
                                <div class="d-flex justify-content-between">
                                    <!-- <h3 class="card-title">Overall Manual Sales</h3>  -->
                                    <!-- <a href="import_manual_sales.php" class='btn btn-primary extra-btn mb-2'>Import Manual Sales (do not click this)</a> -->
                                </div>

                                <div class="d-flex justify-content-between">
                                    <input type="hidden" class="date_filter">
                                    <a href="#" id="refresh_sales_filter" style="font-size:25px;margin-right:5px;" title="Refresh Graph"><i class="ion-ios-refresh text-dark" ></i></a>
                                    <div id="reportrange3" class="pull-left " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                        <span></span> <b class="caret"></b>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex" >
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg" id="chart_total_manual_sales"></span>
                                        <span>Sales Over Time </span>
                                    </p>
                                    <p class="ml-auto d-flex flex-column text-right" id="hide_sales_rate_on_filter">
                                        <!-- <span class="text-success" id="total_sales_percentage_this_month"> -->
                                            <!-- <i class="fa fa-spinner fa-pulse"></i> -->
                                        </span>
                                        <!-- <span class="text-muted">Since last month</span> -->
                                    </p>
                                </div>
                                <!-- /.d-flex -->

                                <div class="position-relative mb-4">
                                    <canvas id="total-manual-sales-chart" height="200"></canvas>
                                </div>

                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This year
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

            
                    <!-- <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Sales Report</li>
                        </ol>
                    </div> -->
                    <!-- /.col -->
                    
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h3 class="card-title">Inventory</h3> -->
                        <button type="button" class="btn  j-orange j-btn mx-1 float-left" data-toggle="modal" data-target="#filter-sales-modal" title="Filter"><i class="fa fa-filter"></i></button>
                        <button type="button" class="btn  j-orange j-btn mx-1 float-left" data-toggle="modal" data-target="#export-sales-modal" title="Export"><i class="fa fa-download"></i></button>
                        <button type="submit" class="btn  j-orange j-btn  mx-1 float-left clear_btn" title="Refresh table"><i class="ion-refresh "></i></button>
                        <!-- <button type="submit" class="btn  j-orange j-btn  mx-1 float-left search_btn" title="Search"><i class="fas fa-search"></i></button> -->
                        <input type="text" class="form-control col-3 mx-1 float-left" placeholder="Search..." id="sales_global_search_field">
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <table id="sales_reports_table" class="table table-bordered table-striped table-hover float-left">
                        <thead>
                            <tr>
                                <!-- <th width="40px">ACTION</th> -->
                                <th>DATE</th>
                                <!-- <th>ORDER ID</th> -->
                                <th>PRODUCT</th>
                                <th>ADD-ONS</th>
                                <th>ORDER FROM</th>
                                <th>QUANTITY</th>
                                <th>PRICE</th>
                                <th>TOTAL</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th colspan="5">Total</th>
                                <th id="total_sales"></th>
                            </tr>
                        </tfoot>
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

    <!-- filter modal -->
    <div class="modal fade" id="filter-sales-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Filter Sales Report</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <!-- <form class="customFilter" > -->
                    <div class="modal-body">
                        <div class="card " >
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="product">Date</label>
                                        <input type="hidden" class="date_filter">
                                        <div id="reportrange" class="pull-left " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                            <i class="glyphicon glyphicon-calendar fas fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="product">Product</label>
                                        <select id="product_filter" class="form-control product_filter" style="width:100%;" multiple>
                                            <?php 
                                                $query = "SELECT product FROM products_tbl WHERE is_active=1 ORDER BY product";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['product']?>"><?=$row['product']?></option>
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
                                                $query = "SELECT username FROM users_tbl WHERE is_active=1 ORDER BY username";
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
                                </div>
                                <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <!-- justify-content-between -->
                        <button type="button" class="btn j-orange j-btn" data-dismiss="modal">Cancel</button>
                        <!-- <button type="submit" class="btn j-green j-btn export_sales" >Export</button> -->
                        <button type="submit" class="btn j-green j-btn filter_sales" >Filter</button>
                    </div>
                <!-- </form> -->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- export modal -->
    <div class="modal fade" id="export-sales-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header j-orange">
                    <h4 class="modal-title ">Export Sales Report</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <form action="export_sales_report.php" method="POST" >
                    <div class="modal-body">
                        <div class="card " >
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="product">Date</label>
                                        <input type="hidden" class="date_filter" name="date">
                                        <div id="reportrange2" class="pull-left " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                            <i class="glyphicon glyphicon-calendar fas fa-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="product">Product</label>
                                        <input type="hidden" id="hidden_product_filter_export" name="product_filter">
                                        <select id="product_filter2" class="form-select product_filter" style="width:100%;" multiple >
                                            <?php 
                                                $query = "SELECT product FROM products_tbl WHERE is_active=1 ORDER BY product";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run)>0){
                                                    foreach($query_run as $row){
                                                    ?>
                                                        <option value="<?=$row['product']?>"><?=$row['product']?></option>
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
                                        <input type="hidden" id="hidden_user_filter_export" name="user_filter">
                                        <select id="user_filter2" class="form-select user_filter" style="width:100%;" multiple >
                                            <?php 
                                                $query = "SELECT username FROM users_tbl WHERE is_active=1 ORDER BY username";
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
                                </div>
                                <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <!-- justify-content-between -->
                        <button type="button" class="btn j-orange j-btn" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn j-green j-btn " name="export_sales">Export</button>
                    </div>
                </form>
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



        // console.log('test');
        var sales_reports_table = $('#sales_reports_table').DataTable({
            "processing":true,
            "serverSide": true,
            scrollX:true,
            scrollY:'50vh',
            // "ordering":false,
            "pageLength": 10,
            "pagingType": "numbers",
            lengthMenu:[[5,10,25,50,100,500],[5,10,25,50,100,500]],
            order: [[ 0, "DESC" ]],
            "ajax":{
                url:"fetch_sales_list.php",
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
                    // "orderable": false,
                    // "width": "25%", 
                },
                {
                    "targets": 1,
                    "className": "order_id",
                },
           
            ]
            ,initComplete: function(){
                $('.dataTables_filter').css('display','none');
            }
            ,drawCallback:function(settings){
                // $('#chart_total_sales').text(settings.json.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#total_sales').text(settings.json.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                // console.log("total_sales: "+settings.json.total);
            }
        });//end of #inventory_table

        function searchFields(){
            sales_reports_table.columns(0).search( '' ).draw();
            sales_reports_table.columns(1).search( '' ).draw();
            sales_reports_table.columns(2).search( '' ).draw();
            sales_reports_table.columns(3).search( '' ).draw();
            sales_reports_table.columns(4).search( '' ).draw();
            sales_reports_table.columns(5).search( '' ).draw();
        }

        // search with click
        // $(document).on('click','.search_btn',function(e){
        //     searchFields();
        //     console.log($('#sales_global_search_field').val())
        //     console.log('searchFields');
        // });

        // search on keyup
        $(document).on('keyup','#sales_global_search_field',function(e){
            searchFields();
            console.log($('#sales_global_search_field').val())
        });

        $(document).on('click','.clear_btn',function(){
            $('#sales_global_search_field').val('');
            searchFields();
        });

        //select2 select_customer
        $('select.product_filter').select2({
            // dropdownParent: $('#filter-sales-modal'),
            theme: 'classic',
            closeOnSelect:false,
            // minimumInputLength: 2,
            // multiple: true,
        });

        //select2 select_customer
        $('select.user_filter').select2({
            // dropdownParent: $('#filter-sales-modal'),
            theme: 'classic',
            closeOnSelect:false,
            // minimumInputLength: 2,
            // multiple: true,
        });

        // $('.product_filter').select2({
        //     ajax:{
        //         url: 'get_products.php',
        //         type:"post",
        //         data: function (params) {
        //         return {
        //             q: params.term, // search term
        //             page: params.page
        //         };
        //     }
        //     ,success: function(result){
        //         console.log(result);
        //     }
        //     ,error: function(result){
        //         console.log(result);
        //     }
            
        //     },
        //     // selectOnClose: false,
        //     closeOnSelect: false,
        //     theme: 'classic',
        //     allowClear: true
        //     // minimumInputLength: 2
        // });

        // latest export 
        $('#user_filter2').on('change',function(e){
            $('#hidden_user_filter_export').val($(this).val());
        });

        $('#product_filter2').on('change',function(e){
            $('#hidden_product_filter_export').val($(this).val());
        });
        

        // customFilter
        // $('form.customFilter').on('submit',function(e){
        $('.filter_sales').on('click',function(e){
            e.preventDefault();
            console.log('customFilter');
            sales_reports_table.columns(0).search( $('.date_filter').val() ).draw();
            sales_reports_table.columns(1).search( $('#product_filter').val() ).draw();
            sales_reports_table.columns(2).search( $('#user_filter').val() ).draw();
            // console.log($('#product_filter').val());
            console.log($('.date_filter').val());
            $('#filter-sales-modal').modal('hide');
        });

        // $(document).on('click','.export_node_btn',function(){
        $('.export_sales').on('click',function(e){ // not working naka form nalang yung export
			console.log('export_sales');
            e.preventDefault();
            
            console.log($("#user_filter").val());
                
            // console.log(from_date);
            // console.log(to_date);
            console.log($('.date_filter').val());
            $('.export_sales')
            .html('<span>Exporting <i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>')
            .attr('disabled',true);
            $.ajax({
                url: 'export_sales_report.php',
                method: 'post',
                data:{
                    date: $('.date_filter').val(),
                    product_filter: $("#product_filter2").val(),
                    user_filter: $("#user_filter2").val(),
                },
                success: function(result){
                    $('.export_sales').html('Export').attr('disabled',false);
                    console.log('success');
                    console.log(result);
                    // window.location='export_sales.xls';
                },
                error: function(e,b,c,d,f){
                    $('.export_sales').html('Export').attr('disabled',false);
                    console.log(e);
                    console.log(b);
                    console.log(c);
                    console.log(d);
                    console.log(f);
                }
            });
		
		
		
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
            $('#total-sales-chart').attr('hidden', true);
            $('#total-sales-chart-filtered').attr('hidden', false);
            showVisitGraphFilter(from_date, to_date);

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

        $(document).on('click','#refresh_sales_filter', function  (e) {
            console.log("refresh_sales_filter");
            window.location="";
            // $('#reportrange3 span').html('');
            // showVisitGraph();
        });


        

    });
</script>


<!-- 2nd script for charts -->
<script>
    showVisitGraph();
    //for charts
    function showVisitGraph(from, to)
    {   
        // console.log(from);
        // console.log(to);
        $('.fa-spinner').attr('hidden',false);
        $.ajax({
        type: 'post',
        url: 'get_monthly_sales_data.php',
        data:{
            'from': from,
            'to': to,
        },
        success: function (response) {
            $('.fa-spinner').attr('hidden',true);
            var obj = JSON.parse(response);
            // console.log(obj.from);
            // console.log(obj.to);
            // console.log(obj.get_monthly_sales_sql);
            

            // console.log(response);
            var action = [];
            var date = [];
            var s =[];
            var m =[];
            var t =[];
            var w =[];
            var th =[];
            var f =[];
            var sat =[];
            var total =[];
            var created_at =[];



            // console.log(obj.action);

            var data = [];
      

            

            var data_last_week = [];
           

            //start of get total sales
            var get_month = [];
            var get_monthly_sales = [];
            var sales_percentage_since_last_month = 0;
            obj.get_monthly_sales.forEach(element => {
                get_month.push(element[0]); //months
                get_monthly_sales.push(element[1]);//sales this month
                
            });
            var get_sales_this_month = get_monthly_sales[get_monthly_sales.length-1];
            var get_sales_last_month = get_monthly_sales[get_monthly_sales.length-2];
            get_sales_this_month /= get_sales_last_month;
            get_sales_this_month *= 100;
            get_sales_this_month = Number(Math.round(get_sales_this_month + 'e' + 2) + 'e-' + 2);
            // console.log('percentage'+get_sales_this_month);
            // get_sales_this_month = -1;
            
            if(get_sales_this_month<0){
                $('#total_sales_percentage_this_month').removeClass('text-success');
                $('#total_sales_percentage_this_month').addClass('text-danger');
                $('#total_sales_percentage_this_month').html('<i class="fas fa-arrow-down"></i> '+get_sales_this_month+"%");
            }else{
                if(get_sales_this_month==0){
                $('#total_sales_percentage_this_month').removeClass('text-success');
                $('#total_sales_percentage_this_month').removeClass('text-danger');
                $('#total_sales_percentage_this_month').html(get_sales_this_month+"%");
                }else{
                $('#total_sales_percentage_this_month').addClass('text-success');
                $('#total_sales_percentage_this_month').removeClass('text-danger');
                $('#total_sales_percentage_this_month').html('<i class="fas fa-arrow-up"></i> '+get_sales_this_month+"%");
                }
            }

            if(from){
                $('#hide_sales_rate_on_filter').html('');
                console.log('get_sales_this_month: '+ get_sales_this_month);
            }
            // console.log("get_sales_this_month: "+ get_monthly_sales[get_monthly_sales.length-1]);
            // console.log("get_sales_last_month: "+ get_monthly_sales[get_monthly_sales.length-2]);
            // total_sales /=


            //end of get total sales
            
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            };

            var mode = 'index';
            var intersect = true;

            var total_sales_chartv2 = $('#total-sales-chart');
            var total_sales_chart = new Chart(total_sales_chartv2, {
                type: 'bar',
                // type: 'line',
                // type: 'pie',
                data: {
                // labels: ['SEP', 'OCT', 'NOV', 'DEC'],
                labels: get_month,
                datasets: [
                    {
                    backgroundColor: '#ff8a5d',
                    borderColor: '#ff8a5d',
                    // data: [10000, 20000, 30000, 25000, 27000, 25000, 30000] // sale data this year
                    data: get_monthly_sales
                    },
                    // {
                    //   backgroundColor: '#ced4da',
                    //   borderColor: '#ced4da',
                    //   data: [700, 1700] //sales data last year
                    // }
                    // ,
                    // {
                    //   backgroundColor: 'yellow',
                    //   borderColor: '#ced4da',
                    //   data: [5, 3] //sales data last year
                    // }
                ]
                },
                options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect // comment coz nag fflicker yung data
                },
                legend: {
                    display: false,
                    
                },
                scales: {
                    yAxes: [{
                    // display: false,
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,

                        // Include a peso sign in the ticks
                        callback: function (value) {
                        if (value >= 1000) {
                            value /= 1000
                            value += 'k'
                        }

                        // return '₱' + value
                        return '₱' + value
                        }
                    }, ticksStyle)
                    }],
                    xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    ticks: ticksStyle
                    }]
                }
                }
            });
            // 


            // //total-manual-sales-chart
            // var manual_product_total_amount = parseFloat(obj.manual_product_total_amount).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // // console.log(manual_product_total_amount);
            // $('#chart_total_manual_sales').text("₱"+manual_product_total_amount);

            // //start of get total sales
            // var get_manual_sales_month = [];
            // var get_manual_sales_monthly = [];
            // var sales_percentage_since_last_month = 0;
            // obj.get_monthly_manual_sales.forEach(element => {
            //     get_manual_sales_month.push(element[0]); //months
            //     get_manual_sales_monthly.push(element[1]);//sales this month
                
            // });

            // var total_manual_sales_chartv2 = $('#total-manual-sales-chart');
            // var total_manual_sales_chart = new Chart(total_manual_sales_chartv2, {
            //     type: 'bar',
            //     // type: 'line',
            //     // type: 'pie',
            //     data: {
            //     // labels: ['SEP', 'OCT', 'NOV', 'DEC'],
            //     labels:  get_manual_sales_month,
            //     datasets: [
            //         {
            //         backgroundColor: '#ff8a5d',
            //         borderColor: '#ff8a5d',
            //         // data: [10000, 20000, 30000, 25000, 27000, 25000, 30000] // sale data this year
            //         data: get_manual_sales_monthly
            //         },
            //         // {
            //         //   backgroundColor: '#ced4da',
            //         //   borderColor: '#ced4da',
            //         //   data: [700, 1700] //sales data last year
            //         // }
            //         // ,
            //         // {
            //         //   backgroundColor: 'yellow',
            //         //   borderColor: '#ced4da',
            //         //   data: [5, 3] //sales data last year
            //         // }
            //     ]
            //     },
            //     options: {
            //     maintainAspectRatio: false,
            //     tooltips: {
            //         mode: mode,
            //         intersect: intersect
            //     },
            //     hover: {
            //         mode: mode,
            //         intersect: intersect // comment coz nag fflicker yung data
            //     },
            //     legend: {
            //         display: false,
                    
            //     },
            //     scales: {
            //         yAxes: [{
            //         // display: false,
            //         gridLines: {
            //             display: true,
            //             lineWidth: '4px',
            //             color: 'rgba(0, 0, 0, .2)',
            //             zeroLineColor: 'transparent'
            //         },
            //         ticks: $.extend({
            //             beginAtZero: true,

            //             // Include a peso sign in the ticks
            //             callback: function (value) {
            //             if (value >= 1000) {
            //                 value /= 1000
            //                 value += 'k'
            //             }

            //             // return '₱' + value
            //             return '₱' + value
            //             }
            //         }, ticksStyle)
            //         }],
            //         xAxes: [{
            //         display: true,
            //         gridLines: {
            //             display: false
            //         },
            //         ticks: ticksStyle
            //         }]
            //     }
            //     }
            // });
            // // end of manual system data
        }
        });
    }// end of chart



    function showVisitGraphFilter(from, to)
    {   
        // console.log(from);
        // console.log(to);
        $('.fa-spinner').attr('hidden',false);
        $.ajax({
        type: 'post',
        url: 'get_monthly_sales_data.php',
        data:{
            'from': from,
            'to': to,
        },
        success: function (response) {
            $('.fa-spinner').attr('hidden',true);

            var obj = JSON.parse(response);
            // console.log(obj.from);
            // console.log(obj.to);
            // console.log(obj.get_monthly_sales_sql);
            

            // console.log(response);
            var action = [];
            var date = [];
            var s =[];
            var m =[];
            var t =[];
            var w =[];
            var th =[];
            var f =[];
            var sat =[];
            var total =[];
            var created_at =[];



            // console.log(obj.action);

            var data = [];
      

            

            var data_last_week = [];
           

            //start of get total sales
            var get_month = [];
            var get_monthly_sales = [];
            var sales_percentage_since_last_month = 0;
            obj.get_monthly_sales.forEach(element => {
                get_month.push(element[0]); //months
                get_monthly_sales.push(element[1]);//sales this month
                
            });
            var get_sales_this_month = get_monthly_sales[get_monthly_sales.length-1];
            var get_sales_last_month = get_monthly_sales[get_monthly_sales.length-2];
            get_sales_this_month /= get_sales_last_month;
            get_sales_this_month *= 100;
            get_sales_this_month = Number(Math.round(get_sales_this_month + 'e' + 2) + 'e-' + 2);
            // console.log('percentage'+get_sales_this_month);
            // get_sales_this_month = -1;
            
            if(get_sales_this_month<0){
                $('#total_sales_percentage_this_month').removeClass('text-success');
                $('#total_sales_percentage_this_month').addClass('text-danger');
                $('#total_sales_percentage_this_month').html('<i class="fas fa-arrow-down"></i> '+get_sales_this_month+"%");
            }else{
                if(get_sales_this_month==0){
                $('#total_sales_percentage_this_month').removeClass('text-success');
                $('#total_sales_percentage_this_month').removeClass('text-danger');
                $('#total_sales_percentage_this_month').html(get_sales_this_month+"%");
                }else{
                $('#total_sales_percentage_this_month').addClass('text-success');
                $('#total_sales_percentage_this_month').removeClass('text-danger');
                $('#total_sales_percentage_this_month').html('<i class="fas fa-arrow-up"></i> '+get_sales_this_month+"%");
                }
            }

            if(from){
                $('#hide_sales_rate_on_filter').html('');
                console.log('get_sales_this_month: '+ get_sales_this_month);
            }
            // console.log("get_sales_this_month: "+ get_monthly_sales[get_monthly_sales.length-1]);
            // console.log("get_sales_last_month: "+ get_monthly_sales[get_monthly_sales.length-2]);
            // total_sales /=


            //end of get total sales
            
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            };

            var mode = 'index';
            var intersect = true;

            var total_sales_chartv2 = $('#total-sales-chart-filtered');
            var total_sales_chart = new Chart(total_sales_chartv2, {
                type: 'bar',
                // type: 'line',
                // type: 'pie',
                data: {
                // labels: ['SEP', 'OCT', 'NOV', 'DEC'],
                labels: get_month,
                datasets: [
                    {
                    backgroundColor: '#ff8a5d',
                    borderColor: '#ff8a5d',
                    // data: [10000, 20000, 30000, 25000, 27000, 25000, 30000] // sale data this year
                    data: get_monthly_sales
                    },
                    // {
                    //   backgroundColor: '#ced4da',
                    //   borderColor: '#ced4da',
                    //   data: [700, 1700] //sales data last year
                    // }
                    // ,
                    // {
                    //   backgroundColor: 'yellow',
                    //   borderColor: '#ced4da',
                    //   data: [5, 3] //sales data last year
                    // }
                ]
                },
                options: {
                maintainAspectRatio: false,
                tooltips: {
                    mode: mode,
                    intersect: intersect
                },
                hover: {
                    mode: mode,
                    intersect: intersect // comment coz nag fflicker yung data
                },
                legend: {
                    display: false,
                    
                },
                scales: {
                    yAxes: [{
                    // display: false,
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,

                        // Include a peso sign in the ticks
                        callback: function (value) {
                        if (value >= 1000) {
                            value /= 1000
                            value += 'k'
                        }

                        // return '₱' + value
                        return '₱' + value
                        }
                    }, ticksStyle)
                    }],
                    xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    ticks: ticksStyle
                    }]
                }
                }
            });
            // 


        }
        });
    }// end of chart


</script>


