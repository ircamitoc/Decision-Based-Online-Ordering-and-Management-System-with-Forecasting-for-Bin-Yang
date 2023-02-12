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
                            <h1 class="m-0 col-12">Sales Forecast</h1>

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
                                
                                    <span class="text-bold text-lg" id="total_sales"></span>
                                    <span>Sales Forecast </span>
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
                                    <i class="fas fa-square text-primary"></i> Sales
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Forecast
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                    
                </div><!-- /.col -->

                <div class="col-sm-6" hidden>
                    <!-- overall sales  template-->
                    <h1 class="m-0 col-12">Sales Forecast (manual system data)</h1>

                    <div class="card">
                        <div class="card-header border-0">
                            
                            <div class="d-flex justify-content-between">
                                <!-- <h3 class="card-title">Overall Manual Sales</h3>  -->
                                <!-- <a href="import_manual_sales.php" class='btn btn-primary extra-btn mb-2'>Import Manual Sales</a> -->
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
                                <span>
                                    <i class="fas fa-square text-gray"></i> Forecast
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-sm-12 d-flex justify-content-center ">
                    <!-- overall sales  template-->

                    <div class="card w-100"   style="max-width:700px;">
                        <div class="card-header border-0">
                            <p>Total Forecasted Revenue</p>
                            <h1 id="Total_Forecasted_Revenue"></h1>
                        </div>
                       
                        <div class="card-body " >
                            
                        <style>
                            td{
                                padding:10px;
                            }
                        </style>
                            <table  class='w-100 rounded shadow table table-responsive ' id="forecast_error_table" style="background:rgb(212,145,87);color:white">
                                <tr>
                                    <td>2022</td>
                                    <td>Actual</td>
                                    <td>Forecasted</td>
                                    <td>Error</td>
                                    <td>Absolute&nbsp;Error</td>
                                    <td>Error^2</td>
                                    <td>%&nbsp;Error</td>
                                    <td>%&nbsp;Accuracy</td>
                                </tr>
                               
                            </table>

                            <div hidden>
                                <input type="text" value="0.00" id="actual" >
                                <input type="text" value="0.00" id="forecasted">
                                <input type="text" value="0.00" id="error">
                                <input type="text" value="0.00" id="absolute_error">
                                <input type="text" value="0.00" id="error2">
                                <input type="text" value="0.00" id="percent_error">
                                <input type="text" value="0.00" id="percent_accuracy">
                            </div>
                            
                            <div class="d-flex justify-content-center">
                                <table  class='w-50 rounded shadow table table-responsive mt-5 d-flex justify-content-center' id="forecast_error_table2" style="background:rgb(212,145,87);color:white">
                                    <tr>
                                        <td></td>
                                        <td>%&nbsp;Error</td>
                                        <td>%&nbsp;Accuracy</td>
                                    </tr>

                                    <tr>
                                        <td>BIAIS</td>
                                        <td id="BIAS_error">%&nbsp;Error</td>
                                        <td id="BIAS_accuracy"></td>
                                    </tr>

                                    <tr>
                                        <td>MAPE</td>
                                        <td id="MAPE_error">%&nbsp;Error</td>
                                        <td id="MAPE_accuracy">%&nbsp;Accuracy</td>
                                    </tr>

                                    <tr>
                                        <td>MAE</td>
                                        <td id="MAE_error">%&nbsp;Error</td>
                                        <td id="MAE_accuracy">%&nbsp;Accuracy</td>
                                    </tr>

                                    <tr>
                                        <td>MSE</td>
                                        <td id="MSE_error">%&nbsp;Error</td>
                                        <td id="MSE_accuracy">%&nbsp;Accuracy</td>
                                    </tr>

                                    <tr>
                                        <td>RMSE</td>
                                        <td id="RMSE_error">%&nbsp;Error</td>
                                        <td id="RMSE_accuracy">%&nbsp;Accuracy</td>
                                    </tr>
                                
                                </table>
                            </div>
                           
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-sm-6">

                
                    <!-- <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Sales Forecast</li>
                    </ol> -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
       
    
    </div>
    <!-- /.content-wrapper -->


</body>

<?php include('footer.php'); ?>

<script>
    
    $(function () {


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

                //start of get total sales
                var get_month = [];
                var get_monthly_sales = [];
                var sales_percentage_since_last_month = 0;

                var total_sales = 0;
                var sales_forecast = 0;
                var forecast_error = 0;

                var sales_forecast_array = [];
                var sales_forecast_arrayV2 = [];
                var forecast_error_array = [];

                obj.get_monthly_sales.forEach(element => {
                    get_month.push(element[0]); //months
                    var sales_this_month = element[1];
                    get_monthly_sales.push(parseFloat(sales_this_month).toFixed(2));//sales this month

                    total_sales+=parseFloat(element[1]);

                    // sales_forecast+=parseFloat(element[1]);
                    // sales_forecast = parseFloat(sales_forecast) / parseFloat(get_monthly_sales.length);
                    sales_forecast_array.push(element[1]);

                    //F = aA + (1-a) B
                    // var a = 0.7; //standard
                    var a = 0.1; //standard
                    var bigA = get_monthly_sales[get_monthly_sales.length-2]; //previous sales
                    // var bigB = (parseFloat(bigA) * 0.2) + parseFloat(bigA); //forecast sales = previous sales + 20%
                    var bigB = sales_forecast_arrayV2[sales_forecast_arrayV2.length-1]; //previous forecast
                    if(bigB=='NaN'){
                        bigB = get_monthly_sales[0];
                    }
                    var sales_forecastV2 = (parseFloat(a)*parseFloat(bigA)) + ((1-parseFloat(a)) * parseFloat(bigB)) ;
                    sales_forecast_arrayV2.push(sales_forecastV2.toFixed(2));

                    // console.log("@@@@@@@@@@@@@@@@@@@@@@");
                    // console.log("bigB: "+bigB);
                    // // console.log(get_monthly_sales);
                    // console.log(sales_forecast_arrayV2);
                    // console.log("previous sales: "+bigA);
                    // console.log("forecast sales = previous sales + 20%: "+bigB);
                    // console.log("sales_forecastV2: "+sales_forecastV2);
                    
                    // console.log("get_monthly_sales: "+get_monthly_sales);
                    // console.log("sales_forecast_array: " + sales_forecast_array);
                    // console.log("sales_forecast_arrayV2: "+sales_forecast_arrayV2);
                    // console.log("@@@@@@@@@@@@@@@@@@@@@@");

                    forecast_error = sales_this_month - sales_forecastV2;
                    forecast_error_array.push(forecast_error.toFixed(2));

                    
                    
                });


                
                // console.log('---------');
                // console.log(sales_forecast_arrayV2);
                // console.log(forecast_error_array);
                // console.log('---------');

                var Total_Forecasted_Revenue = 0;
                var percent_error_hidden_total = 0;
                var percent_accuracy_hidden_total = 0;
                get_month.forEach(element => {
                    
                    // console.log(element); // month
                    // console.log(get_monthly_sales[get_month.indexOf(element)]) // actual
                    var actual = get_monthly_sales[get_month.indexOf(element)];
                    // console.log(sales_forecast_arrayV2[get_month.indexOf(element)]) // forecasted last month
                    var forecasted_last_month = sales_forecast_arrayV2[get_month.indexOf(element)];
                    // console.log(forecast_error_array[get_month.indexOf(element)]) // forecast error
                    var forecast_error = forecast_error_array[get_month.indexOf(element)];

                    if(forecasted_last_month=="NaN" || forecast_error=="NaN"){
                        forecasted_last_month=0;
                        forecast_error=0;
                    }

                   
                    
                    Total_Forecasted_Revenue+=parseFloat(forecasted_last_month);

                    var absolute_error = Math.abs(parseFloat(forecast_error));
                    new_absolute_error = absolute_error.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    var error2 = parseFloat(forecast_error) * parseFloat(forecast_error);
                    new_error2 = error2.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    var percentage_error = Math.round((parseFloat(absolute_error)/parseFloat(actual))*100);
                    var percentage_accuracy = Math.round((1-parseFloat(absolute_error)/parseFloat(actual))*100);


                    var new_forecast_error = parseFloat(forecasted_last_month) - parseFloat(actual);
                    console.log(element);
                    if(element=="July"){
                        new_forecast_error = (0).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }else{
                        new_forecast_error =  new_forecast_error.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }

                    var actual_hidden = $('#actual').val();
                    $('#actual').val(actual_hidden = parseFloat(actual_hidden) + parseFloat(actual));

                    var forecasted_hidden = $('#forecasted').val();
                    $('#forecasted').val(forecasted_hidden = parseFloat(forecasted_hidden) + parseFloat(forecasted_last_month));

                    var error_hidden = $('#error').val();
                    $('#error').val(error_hidden= parseFloat(error_hidden) + parseFloat(forecast_error));

                    var absolute_error_hidden = $('#absolute_error').val();
                    $('#absolute_error').val(absolute_error_hidden = parseFloat(absolute_error_hidden) + parseFloat(absolute_error));
                    
                    var error2_hidden = $('#error2').val();
                    $('#error2').val(error2_hidden= parseFloat(error2_hidden) + parseFloat(error2));

                    var percent_error_hidden = $('#percent_error').val();
                    $('#percent_error').val(percent_error_hidden_total = parseFloat(percent_error_hidden_total) + parseFloat(percentage_error));
                    
                    var percent_accuracy_hidden = $('#percent_accuracy').val();
                    $('#percent_accuracy').val(percent_accuracy_hidden_total = parseFloat(percent_accuracy_hidden_total) + parseFloat(percentage_accuracy));

                    actual = parseFloat(actual).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    forecasted_last_month = parseFloat(forecasted_last_month).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    forecast_error = parseFloat(forecast_error).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    
                   
                  
                    $('#forecast_error_table').append(`
                        <tr>
                            <td>`+element+`</td>
                            <td>₱`+actual+`</td>
                            <td>₱`+forecasted_last_month+`</td>
                            <td>₱`+new_forecast_error+`</td>
                            <td>`+new_absolute_error+`</td>
                            <td>`+new_error2+`</td>
                            <td>`+percentage_error+`%</td>
                            <td>`+percentage_accuracy+`%</td>
                        </tr>
                    `);
                });

                var set_actual = $('#actual').val();
                set_actual = parseFloat(set_actual).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                var set_forecasted = $('#forecasted').val();
                set_forecasted = parseFloat(set_forecasted).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                var set_error = $('#error').val();
                set_error = parseFloat(set_error).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                var set_absolute_error = $('#absolute_error').val();
                set_absolute_error = parseFloat(set_absolute_error).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                var set_error2 = $('#error2').val();
                set_error2 = parseFloat(set_error2).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                
                var get_actual_average = parseFloat($('#actual').val()) / parseFloat(get_month.length);
                var get_error2_average = parseFloat($('#error2').val()) / parseFloat(get_month.length);

                var set_percent_error = $('#percent_error').val();
                set_percent_error = parseFloat(set_percent_error) / parseFloat(get_month.length);
                set_percent_error = parseFloat(set_percent_error).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                var set_percent_accuracy = $('#percent_accuracy').val();
                console.log("set_percent_accuracy"+set_percent_accuracy);
               
                $('#forecast_error_table').append(`
                    <tr>
                        <td>`+"TOTAL"+`</td>
                        <td>₱`+set_actual+`</td>
                        <td>₱`+set_forecasted+`</td>
                        <td>₱`+set_error+`</td>
                        <td>`+set_absolute_error+`</td>
                        <td>`+set_error2+`</td>
                    </tr>
                `);

                $('#BIAS_error').text(parseFloat(set_error)/parseFloat(set_actual).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"%");

                $('#MAPE_error').text(set_percent_error+"%");
                var set_MAPE_percent_error_divided_by_100 = parseFloat(set_percent_error/100)
                set_MAPE_percent_error_divided_by_100 = (parseFloat(1)-parseFloat(set_MAPE_percent_error_divided_by_100) )* 100;
                $('#MAPE_accuracy').text(set_MAPE_percent_error_divided_by_100.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"%");

                $('#MAE_error').text((parseFloat(set_absolute_error)/parseFloat(set_actual)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"%");
                var set_MAE_percent_error_divided_by_100 = (parseFloat(set_absolute_error)/parseFloat(set_actual))/100;
                 set_MAE_percent_error_divided_by_100 = (parseFloat(1)-parseFloat(set_MAE_percent_error_divided_by_100))*100;
                $('#MAE_accuracy').text(set_MAE_percent_error_divided_by_100.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"%");

                $('#MSE_error').text((parseFloat(get_error2_average)/parseFloat(get_actual_average)).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"%");
                var set_MSE_percent_error_divided_by_100 = (parseFloat(get_error2_average)/parseFloat(get_actual_average))/100;
                 set_MSE_percent_error_divided_by_100 = (parseFloat(1)-parseFloat(set_MSE_percent_error_divided_by_100))*100;
                $('#MSE_accuracy').text(set_MSE_percent_error_divided_by_100.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"%");
                
                var sqrt_rmse = Math.sqrt(parseFloat(get_error2_average) / parseFloat(get_actual_average));
                $('#RMSE_error').text(parseFloat(sqrt_rmse).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"%");
                var set_RMSE_percent_error_divided_by_100 = parseFloat(sqrt_rmse)/100;
                 set_RMSE_percent_error_divided_by_100 = (parseFloat(1)-(parseFloat(set_RMSE_percent_error_divided_by_100))) * 100;
                $('#RMSE_accuracy').text(set_RMSE_percent_error_divided_by_100.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+"%");



                $('#Total_Forecasted_Revenue').text("₱"+parseFloat(Total_Forecasted_Revenue).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                
                $('#total_sales').text("₱"+ parseFloat(total_sales).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                // console.log("sales_forecast_arrayV2:" + sales_forecast_arrayV2);
                // console.log("get_month:"+get_month);
                // console.log("sales_forecast_array:"+sales_forecast_array);
                // console.log("sales_forecast:"+sales_forecast);
            
                // console.log("sales_forecast_array.length:" +sales_forecast_array.length)

                //F = aA + (1-a) B
                // var a = 0.7; //standard //removed
                var a = 0.1; //standard //replaced
                var bigA = sales_forecast_array[sales_forecast_array.length-2]; //previous sales
                // var bigB = (parseFloat(bigA) * 0.2) + parseFloat(bigA); //forecast sales = previous sales + 20% //removed
                var bigB = parseFloat(bigA); //replaced
                var sales_forecastV2 = parseFloat(a)*parseFloat(bigA) + (1-parseFloat((a))) * parseFloat(bigB) ;
                // console.log("-");
                // console.log(a);
                // console.log(bigA);
                // console.log(bigB);
                // console.log(sales_forecastV2);
                // console.log("-");
                // console.log("sales_forecast: "+sales_forecast);


                var get_sales_this_month = get_monthly_sales[get_monthly_sales.length-1];
                var get_sales_last_month = get_monthly_sales[get_monthly_sales.length-2];
                // console.log("get_sales_last_month: "+get_sales_last_month);
                // console.log("get_sales_this_month: "+get_sales_this_month);
                get_sales_this_month /= get_sales_last_month;
                get_sales_this_month *= 100;
                get_sales_this_month = Number(Math.round(get_sales_this_month + 'e' + 2) + 'e-' + 2);
                // console.log('percentage: '+get_sales_this_month); // meaning pecentage to ng kita ngayong month based sa kota last month
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
                        {
                        backgroundColor: '#ced4da',
                        borderColor: '#ced4da',
                        //   data: [700, 1700] //sales forecast
                        data: sales_forecast_arrayV2 //sales forecast
                        }
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
                    // hover: {
                    //     mode: mode,
                    //     intersect: intersect // comment coz nag fflicker yung data
                    // },
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

                // var manual_sales_forecast = 0;
                // var manual_sales_forecast_array = [];
                // var manual_sales_forecast_arrayV2 = [];
                // obj.get_monthly_manual_sales.forEach(element => {
                //     get_manual_sales_month.push(element[0]); //months
                //     get_manual_sales_monthly.push(element[1]);//sales this month
                    
                //     manual_sales_forecast+=parseFloat(element[1]);
                //     manual_sales_forecast = parseFloat(manual_sales_forecast/get_manual_sales_month.length);
                //     manual_sales_forecast_array.push(manual_sales_forecast);


                //     //F = aA + (1-a) B
                //     var a = 0.7; //standard
                //     var bigA = manual_sales_forecast_array[manual_sales_forecast_array.length-2]; //previous sales
                //     var bigB = (parseFloat(bigA) * 0.2) + parseFloat(bigA); //forecast sales = previous sales + 20%
                //     var sales_forecastV2 = parseFloat(a)*parseFloat(bigA) + (1-parseFloat((a))) * parseFloat(bigB) ;

                //     manual_sales_forecast_arrayV2.push(parseFloat(sales_forecastV2).toFixed(2));
                // });

                // // console.log(manual_sales_forecast_arrayV2);

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
                //             backgroundColor: '#ff8a5d',
                //             borderColor: '#ff8a5d',
                //             // data: [10000, 20000, 30000, 25000, 27000, 25000, 30000] // sale data this year
                //             data: get_manual_sales_monthly
                //         },
                //         {
                //             backgroundColor: '#ced4da',
                //             borderColor: '#ced4da',
                //         //   data: [700, 1700] //sales data last year
                //             data: manual_sales_forecast_arrayV2
                //         }
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

                //start of get total sales
                var get_month = [];
                var get_monthly_sales = [];
                var sales_percentage_since_last_month = 0;

                var total_sales = 0;
                var sales_forecast = 0;
                var forecast_error = 0;

                var sales_forecast_array = [];
                var sales_forecast_arrayV2 = [];
                var forecast_error_array = [];

                obj.get_monthly_sales.forEach(element => {
                    get_month.push(element[0]); //months
                    var sales_this_month = element[1];
                    get_monthly_sales.push(parseFloat(sales_this_month).toFixed(2));//sales this month

                    total_sales+=parseFloat(element[1]);

                    // sales_forecast+=parseFloat(element[1]);
                    // sales_forecast = parseFloat(sales_forecast) / parseFloat(get_monthly_sales.length);
                    sales_forecast_array.push(element[1]);

                    //F = aA + (1-a) B
                    // var a = 0.7; //standard
                    var a = 0.1; //standard
                    var bigA = get_monthly_sales[get_monthly_sales.length-2]; //previous sales
                    // var bigB = (parseFloat(bigA) * 0.2) + parseFloat(bigA); //forecast sales = previous sales + 20%
                    var bigB = sales_forecast_arrayV2[sales_forecast_arrayV2.length-1]; //previous forecast
                    if(bigB=='NaN'){
                        bigB = get_monthly_sales[0];
                    }
                    var sales_forecastV2 = (parseFloat(a)*parseFloat(bigA)) + ((1-parseFloat(a)) * parseFloat(bigB)) ;
                    sales_forecast_arrayV2.push(sales_forecastV2.toFixed(2));

                    // console.log("@@@@@@@@@@@@@@@@@@@@@@");
                    // console.log("bigB: "+bigB);
                    // // console.log(get_monthly_sales);
                    // console.log(sales_forecast_arrayV2);
                    // console.log("previous sales: "+bigA);
                    // console.log("forecast sales = previous sales + 20%: "+bigB);
                    // console.log("sales_forecastV2: "+sales_forecastV2);
                    
                    // console.log("get_monthly_sales: "+get_monthly_sales);
                    // console.log("sales_forecast_array: " + sales_forecast_array);
                    // console.log("sales_forecast_arrayV2: "+sales_forecast_arrayV2);
                    // console.log("@@@@@@@@@@@@@@@@@@@@@@");

                    forecast_error = sales_this_month - sales_forecastV2;
                    forecast_error_array.push(forecast_error.toFixed(2));

                    
                    
                });


                
                // console.log('---------');
                // console.log(sales_forecast_arrayV2);
                // console.log(forecast_error_array);
                // console.log('---------');

                var Total_Forecasted_Revenue = 0;

                get_month.forEach(element => {
                    
                    // console.log(element); // month
                    // console.log(get_monthly_sales[get_month.indexOf(element)]) // actual
                    var actual = get_monthly_sales[get_month.indexOf(element)];
                    // console.log(sales_forecast_arrayV2[get_month.indexOf(element)]) // forecasted last month
                    var forecasted_last_month = sales_forecast_arrayV2[get_month.indexOf(element)];
                    // console.log(forecast_error_array[get_month.indexOf(element)]) // forecast error
                    var forecast_error = forecast_error_array[get_month.indexOf(element)];

                    if(forecasted_last_month=="NaN" || forecast_error=="NaN"){
                        forecasted_last_month=0;
                        forecast_error=0;
                    }
                    
                    Total_Forecasted_Revenue+=parseFloat(forecasted_last_month);

                    actual = parseFloat(actual).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    forecasted_last_month = parseFloat(forecasted_last_month).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    forecast_error = parseFloat(forecast_error).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    
                  

                    $('#forecast_error_table').append(`
                        <tr>
                            <td>`+element+`</td>
                            <td>₱`+actual+`</td>
                            <td>₱`+forecasted_last_month+`</td>
                            <td>₱`+forecast_error+`</td>
                        </tr>
                    `);
                });

                $('#Total_Forecasted_Revenue').text("₱"+parseFloat(Total_Forecasted_Revenue).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                
                $('#total_sales').text("₱"+ parseFloat(total_sales).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                // console.log("sales_forecast_arrayV2:" + sales_forecast_arrayV2);
                // console.log("get_month:"+get_month);
                // console.log("sales_forecast_array:"+sales_forecast_array);
                // console.log("sales_forecast:"+sales_forecast);
            
                // console.log("sales_forecast_array.length:" +sales_forecast_array.length)

                //F = aA + (1-a) B
                // var a = 0.7; //standard //removed
                var a = 0.1; //standard //replaced
                var bigA = sales_forecast_array[sales_forecast_array.length-2]; //previous sales
                // var bigB = (parseFloat(bigA) * 0.2) + parseFloat(bigA); //forecast sales = previous sales + 20% //removed
                var bigB = parseFloat(bigA); //replaced
                var sales_forecastV2 = parseFloat(a)*parseFloat(bigA) + (1-parseFloat((a))) * parseFloat(bigB) ;
                // console.log("-");
                // console.log(a);
                // console.log(bigA);
                // console.log(bigB);
                // console.log(sales_forecastV2);
                // console.log("-");
                // console.log("sales_forecast: "+sales_forecast);


                var get_sales_this_month = get_monthly_sales[get_monthly_sales.length-1];
                var get_sales_last_month = get_monthly_sales[get_monthly_sales.length-2];
                // console.log("get_sales_last_month: "+get_sales_last_month);
                // console.log("get_sales_this_month: "+get_sales_this_month);
                get_sales_this_month /= get_sales_last_month;
                get_sales_this_month *= 100;
                get_sales_this_month = Number(Math.round(get_sales_this_month + 'e' + 2) + 'e-' + 2);
                // console.log('percentage: '+get_sales_this_month); // meaning pecentage to ng kita ngayong month based sa kota last month
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
                        {
                        backgroundColor: '#ced4da',
                        borderColor: '#ced4da',
                        //   data: [700, 1700] //sales forecast
                        data: sales_forecast_arrayV2 //sales forecast
                        }
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
                    // hover: {
                    //     mode: mode,
                    //     intersect: intersect // comment coz nag fflicker yung data
                    // },
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


