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
                <div class="row">
                    <div class="col-sm-6">

                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title float-left " style="width:100%">Feedback Report</h3>
                            </div>

                            <div class="container" style="padding-bottom:30px;height:100%;min-height:311px;">
                                <div class="row row-cols-12">
                                    <div class="col m-2">
                                        <div class="d-flex justify-content-center mt-2 ">
                                            <nobr>
                                            <span id="average_star_rating" style="font-weight:800;font-size:35px"></span> <br>
                                            <span id="stars"> </span><br>
                                            <span id="total_ratings" class='text-secondary' style="font-weight:800;font-size:18px"> </span>
                                            </nobr>
                                        </div>
                                   
                                        <div class="d-flex  justify-content-start  " >
                                            
                                            <table style="width:100%;margin:10px;">
                                            <tr>
                                                <td style="width:3%;">5</td>
                                                <td style="width:100%;">
                                                <div class="progress ">
                                                    <div class="progress-bar rounded bg-warning " id="five_star_rating" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>
                                                <div class="progress">
                                                    <div class="progress-bar rounded bg-warning" id="four_star_rating" role="progressbar" style="width: 0%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>
                                                <div class="progress">
                                                    <div class="progress-bar rounded bg-warning" id="three_star_rating" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>
                                                <div class="progress">
                                                    <div class="progress-bar rounded bg-warning" id="two_star_rating" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                <div class="progress">
                                                    <div class="progress-bar rounded bg-warning" id="one_star_rating" role="progressbar" style="width: 0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                </td>
                                            </tr>
                                            </table>
                                        </div>
                                    </div> <!--end of 2nd col-->
                                </div>
                            </div>

                        </div>
                        <!-- /.card -->
                           
                            
                    </div><!-- /.col -->

                    <div class="col-sm-6">
                        <!-- overall sales  template-->
                        <div class="card" >
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <input type="hidden" class="date_filter">
                                    <a href="#" id="search_refresh" style="font-size:25px;margin-right:5px" title="Refresh Graph"><i class="ion-ios-refresh text-dark"></i></a>
                                    <!-- <input type="text" class="form-control" id="search_rate_value"> -->
                                    <select class="form-control select_product"  id="search_rate_value">
                                    <option value="">Select Product Ratings</option>
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
                                    <!-- <button type="submit" id="search_rating" class="btn btn-success">search_rating</button> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- <div class="d-flex" >
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg" id="total_sales"></span>
                                        <span>Product Name </span>
                                    </p>
                                </div> -->
                                <!-- /.d-flex -->

                                <div class="position-relative mb-4">
                                    <canvas id="rates-chart" height="200"></canvas>
                                </div>

                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> Ratings
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        
                    </div>
                    
                    <!-- overall sales  template-->
                    <div class="col-12">
                        <div class="card ">
                            <div class="card-header border-0">
                                <label for="">Products With Ratings</label>
                            </div>
                            <div class="card-body">
                                
                                <div class="position-relative mb-4">
                                    <canvas id="all-rates-chart" height="200"></canvas>
                                </div> 

                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> Ave. Ratings
                                    </span>
                                </div> 
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    
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
                                <!-- <button type="button" class="btn  j-orange j-btn mx-1 float-left" data-toggle="modal" data-target="#filter-sales-modal" title="Filter"><i class="fa fa-filter"></i></button>
                                <button type="button" class="btn  j-orange j-btn mx-1 float-left" data-toggle="modal" data-target="#export-sales-modal" title="Export"><i class="fa fa-download"></i></button> -->
                                <button type="submit" class="btn  j-orange j-btn  mx-1 float-left clear_btn" title="Refresh table"><i class="ion-refresh "></i></button>
                                <!-- <button type="submit" class="btn  j-orange j-btn  mx-1 float-left search_btn" title="Search"><i class="fas fa-search"></i></button> -->
                                <input type="text" class="form-control col-3 mx-1 float-left" placeholder="Search..." id="feedback_reports_global_search_field">
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="feedback_reports_table" class="table table-bordered table-striped table-hover float-left">
                                    <thead>
                                        <tr>
                                            <th>RATE_ID</th>
                                            <th>ORDER_ID</th>
                                            <th>PRODUCT</th>
                                            <th>COMMENT</th>
                                            <th>RATINGS</th>
                                            <th>DATE</th>
                                            <th>IMAGE</th>
                                            <th>USERNAME</th>
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
</body>

<?php include('footer.php'); ?>

<script>
    
    $(function () {



        // console.log('test');
        var feedback_reports_table = $('#feedback_reports_table').DataTable({
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
                url:"fetch_feedback_reports_list_v2.php",
                type:"post",
                data:function(data){
                    data.global_search = $('#feedback_reports_global_search_field').val();
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
                    "className": "rate_id",
                },
           
            ]
            ,initComplete: function(){
                $('.dataTables_filter').css('display','none');
            }
            ,drawCallback:function(settings){
                $('#total_sales').html(settings.json.total);
                // console.log(settings.json.total);
            }
        });//end of #inventory_table

        function searchFields(){
            feedback_reports_table.columns(0).search( '' ).draw();
            feedback_reports_table.columns(1).search( '' ).draw();
            feedback_reports_table.columns(2).search( '' ).draw();
            feedback_reports_table.columns(3).search( '' ).draw();
            feedback_reports_table.columns(4).search( '' ).draw();
            feedback_reports_table.columns(5).search( '' ).draw();
            feedback_reports_table.columns(6).search( '' ).draw();
            feedback_reports_table.columns(7).search( '' ).draw();
        }

       

        // search on keyup
        $(document).on('keyup','#feedback_reports_global_search_field',function(e){
            searchFields();
            console.log($('#feedback_reports_global_search_field').val())
        });

        $(document).on('click','.clear_btn',function(){
            $('#feedback_reports_global_search_field').val('');
            searchFields();
        });

    });
</script>


<!-- 2nd script for charts -->
<script>
    // showVisitGraph();
    //for charts
    function showVisitGraph(product)
    {   
        // console.log(from);
        // console.log(to);
        $.ajax({
        type: 'post',
        url: 'index_data.php',
        data:{
            'product': product,
        },
        success: function (response) {
            var obj = JSON.parse(response);
           
            // console.log(obj.get_rate_1_star);
            // console.log(obj.get_rate_2_star);
            // console.log(obj.get_rate_3_star);
            // console.log("get_rate_4_star: "+obj.get_rate_4_star);
            // console.log(obj.get_rate_5_star);
            
            // ----------------------------------
                var get_rate = [];
                obj.get_rate_count.forEach(element => {
                    get_rate.push(element[0]); //rates
                });

                var get_rate_1 = 0;
                obj.get_rate_1_star.forEach(element => {
                    get_rate_1 = (element[0]); //rates
                });

                var get_rate_2 = 0;
                obj.get_rate_2_star.forEach(element => {
                    get_rate_2 = (element[0]); //rates
                });

                var get_rate_3 = 0;
                obj.get_rate_3_star.forEach(element => {
                    get_rate_3 = (element[0]); //rates
                });

                var get_rate_4 = 0;
                obj.get_rate_4_star.forEach(element => {
                    get_rate_4 = (element[0]); //rates
                });
                // console.log(get_rate_4);

                var get_rate_5 = 0;
                obj.get_rate_5_star.forEach(element => {
                    get_rate_5 = (element[0]); //rates
                });
                // console.log(get_rate);
            // 

            
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            };

            var mode = 'index';
            var intersect = true;

            var ratesChart = $('#rates-chart');
            var ratesChartV2 = new Chart(ratesChart, {
                type: 'bar',
                // type: 'line',
                // type: 'pie',
                data: {
                labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars' ],
                // labels: ['5', '10', '15', '20', '25'],
                // labels: get_month,
                datasets: [
                    {
                    backgroundColor: '#ff8a5d',
                    borderColor: '#ff8a5d',
                    data: [get_rate_1, get_rate_2, get_rate_3, get_rate_4, get_rate_5] // ratings 1-5
                    // data: ['5', '10', '15', '20', '25'],
                    // data: ['1', '2', '3', '4', '5'],
                    // data: get_rate
                    },
                    // {
                    //   backgroundColor: '#ced4da',
                    //   borderColor: '#ced4da',
                    // //   data: [700, 1700] //sales forecast
                    //   data: sales_forecast_array //sales forecast
                    // }
                    // ,
                    // {
                    //   backgroundColor: 'yellow',
                    //   borderColor: '#ced4da',
                    //   data: [5, 3] //sales forecast
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
                            return '' + value
                            }
                        }, ticksStyle)
                    }],
                    xAxes: [{
                    display: true,
                    gridLines: {
                        // display: false
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

   

    $('#search_rate_value').on('change', function(){
        console.log('search_rating');
        showVisitGraph($('#search_rate_value').val());
        if($('#search_rate_value').val()==""){
            window.location = '';
        }
    });

    $('#search_refresh').on('click', function(){
        console.log('search_refresh');
        // $('#search_rate_value').val('');
        // showVisitGraph('l123123123');
        window.location = '';
    });

    //select2 select_customer
    $('.select_product').select2({
        theme: 'classic',
        // closeOnSelect:false,
        // minimumInputLength: 2,
        // multiple: true,
        //   tags: true // to allow not existing value,
    });



    //all rate chart
    showAllGraph();
    function showAllGraph(product)
    {   
        // console.log(from);
        // console.log(to);
        $.ajax({
        type: 'post',
        url: 'index_data.php',
        data:{
            'product': product,
        },
        success: function (response) {
            var obj = JSON.parse(response);
            console.log(obj.get_all_rates);
            // console.log(obj.get_rate_1_star);
            // console.log(obj.get_rate_2_star);
            // console.log(obj.get_rate_3_star);
            // console.log("get_rate_4_star: "+obj.get_rate_4_star);
            // console.log(obj.get_rate_5_star);
            
            // ----------------------------------
                var get_products = [];
                var get_rates = [];
                obj.get_all_rates.forEach(element => {
                    get_products.push(element[0]); //rates
                    get_rates.push(element[1]); //rates
                });

                console.log(get_products);
                console.log(get_rates);
              
            // 

            
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            };

            var mode = 'index';
            var intersect = true;

            var all_ratesChart = $('#all-rates-chart');
            var all_ratesChartV2 = new Chart(all_ratesChart, {
                type: 'bar',
                responsive: true,
                // type: 'line',
                // type: 'pie',
                data: {
                    // labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars' ],
                    // labels: ['5', '10', '15', '20', '25'],
                    labels: get_products,
                    datasets: [
                        {
                        backgroundColor: '#ff8a5d',
                        borderColor: '#ff8a5d',
                        // data: [get_rate_1, get_rate_2, get_rate_3, get_rate_4, get_rate_5] // ratings 1-5
                        // data: ['1', '2', '3', '4', '5'],
                        data: get_rates,
                        },
                        // {
                        //   backgroundColor: '#ced4da',
                        //   borderColor: '#ced4da',
                        // //   data: [700, 1700] //sales forecast
                        //   data: sales_forecast_array //sales forecast
                        // }
                        // ,
                        // {
                        //   backgroundColor: 'yellow',
                        //   borderColor: '#ced4da',
                        //   data: [5, 3] //sales forecast
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
                        callback: function(value) {if (value % 1 === 0) {return value;}}
                    }, ticksStyle)
                    }],
                    xAxes: [{
                    display: true,
                    gridLines: {
                        // display: false
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



