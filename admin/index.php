<?php 

  include('header.php'); 


  if(!isset($_SESSION['username'])){
      echo '<script> 
          // alert("please login");
          window.location = "login.php";
      </script> '; 
  } 

  //count active products
  $sql = "SELECT COUNT(*) AS total_products  FROM products_tbl WHERE is_active=1 ";
  $query=mysqli_query($con,$sql);
  $row=mysqli_fetch_array($query);
  $total_products = $row['total_products'];

  //count pending orders
  $sql = "SELECT COUNT(*) AS pending_order FROM order_tbl WHERE order_status='pending'";
  $query=mysqli_query($con,$sql);
  $row=mysqli_fetch_array($query);
  $pending_order = $row['pending_order'];

  //count users
  $sql = "SELECT COUNT(*) AS registered_users FROM users_tbl ";
  $query=mysqli_query($con,$sql);
  $row=mysqli_fetch_array($query);
  $registered_users = $row['registered_users'];

  
  //count visit
  // $sql = "SELECT  COUNT(*) AS unique_visit FROM activity_logs  WHERE action='visit' ";
  // $query=mysqli_query($con,$sql);
  // $row=mysqli_fetch_array($query);
  // $unique_visit = $row['unique_visit'];

?>




        <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">BIN-YANG Coffee & Tea</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main contentv2 -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="pending_order"><?= $pending_order ?></h3>
                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
                <a href="/admin/order_management.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>
                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->

          <div class="col-lg-3 col-6" >
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="unique_visit"><?=$total_products?></h3>
                <p>Products</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="inventory" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $registered_users ?></h3>
                <p>Registered Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="/admin/user_management.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6" hidden>
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="unique_visit"><?=$unique_visit?></h3>
                <p>Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          

        </div>
      </div>
    </div>

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row d-flex justify-content-center">

            <!-- <div class=" col-lg-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>150</h3>
                  <p>New Orders</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div> -->
            
            <div class="col-lg-6">

              <div class="card" hidden>
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Weekly Visit</h3>
                    <!-- <a href="salesforcast.html">View Report</a> -->
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg" id="total_visit_chart_count"></span>
                      <span>Visitors Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                      <span class="text-success">
                        <i class="fas fa-arrow-up"></i> <span id="visit_percentage_this_week"></span>
                      </span>
                      <span class="text-muted">Since last week</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <canvas id="visitors-chart-v2" height="200"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> This Week
                    </span>

                    <span>
                      <i class="fas fa-square text-gray"></i> Last Week
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->

              <div class="card" style="min-height:419px;">
                <div class="card-header border-0">
                  <h3 class="card-title">Top Products</h3>
                  <!-- <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-bars"></i>
                    </a>
                  </div> -->
                </div>
                <div class="card-body table-responsive p-3">
                  <table id="top_products_table" class="table table-striped table-valign-middle table-hover " >
                    <thead>
                    <tr>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Sales</th>
                      <!-- <th>More</th> -->
                    </tr>
                    </thead>
                  </table>
                </div>
              </div>

              <div class="card" hidden>
                <div class="card-header border-0">
                  <h3 class="card-title">Products</h3>
                  <div class="card-tools">
                    <a href="#" class="btn btn-tool btn-sm">
                      <i class="fas fa-bars"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Sales</th>
                      <th>More</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Bin-yang's Signiture Coffee
                      </td>
                      <td>₱95.00</td>
                      <td>
                        <small class="text-success mr-1">
                          <i class="fas fa-arrow-up"></i>
                          12%
                        </small>
                        401 Sold
                      </td>
                      <td>
                        <a href="#" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Honey Peach
                      </td>
                      <td>₱90.00</td>
                      <td>
                        <small class="text-warning mr-1">
                          <i class="fas fa-arrow-down"></i>
                          0.5%
                        </small>
                        123 Sold
                      </td>
                      <td>
                        <a href="#" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Okinawa
                      </td>
                      <td>₱95.00</td>
                      <td>
                        <small class="text-danger mr-1">
                          <i class="fas fa-arrow-down"></i>
                          6%
                        </small>
                        198 Sold
                      </td>
                      <td>
                        <a href="#" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Oreo Cream Cheese
                        <span class="badge bg-danger">NEW</span>
                      </td>
                      <td>₱110.00</td>
                      <td>
                        <small class="text-success mr-1">
                          <i class="fas fa-arrow-up"></i>
                          63%
                        </small>
                        87 Sold
                      </td>
                      <td>
                        <a href="#" class="text-muted">
                          <i class="fas fa-search"></i>
                        </a>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card -->

            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
              <div class="card" style="min-height:400px;">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Overall Sales</h3>
                   
                    <a href="sales_reports.php">View Report</a>
                  </div>

                  <div class="d-flex justify-content-between">
                      <input type="hidden" class="date_filter">
                      <a href="#" id="refresh_sales_filter" style="font-size:25px;margin-right:5px" title="Refresh Graph"><i class="ion-ios-refresh text-dark"></i></a>
                      <div id="reportrange" class="pull-left " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
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
                      <span class="text-bold text-lg" id="total_sales">₱<?= $total_sales ?></span>
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
                  <div class="position-relative ">
                    <canvas id="total-sales-chart" height="200"></canvas>
                    <canvas id="total-sales-chart-filtered" height="200" hidden></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end" >
                    <span class="mr-2" >
                      <i class="fas fa-square text-primary" ></i> This year
                    </span>

                    <!-- <span>
                      <i class="fas fa-square text-gray"></i> Last year
                    </span> -->
                  </div>
                </div>
              </div>

              <!-- /.card -->
              <div class="card">

                <div class="card-header border-0">
                  <h3 class="card-title float-left">Feedback Report</h3>
                  <a href="feedback_reports.php" class="float-right">View Report</a>
                </div>

                <div class="container">
                  <div class="row row-cols-12">
                    <div class="col m-2">
                     
                      <div class="d-flex justify-content-center mt-2 ">
                        <nobr>
                          <span id="average_star_rating" style="font-weight:800;font-size:35px"></span> <br>
                          <span id="stars"> </span><br>
                          <span id="total_ratings" class='text-secondary' style="font-weight:800;font-size:18px"> </span>
                        </nobr>
                      </div>
                    </div>
                    <div class="col ">
                      <div class="d-flex  justify-content-start  " >
                        
                        <table style="width:500px;margin:10px;">
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
              
              <!-- orcerall sales  template-->
              <div class="card" hidden>
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Overall Sales</h3>
                    <a href="salesreports.html">View Report</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg" >₱101, 230.00</span>
                      <span>Sales Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                      <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 33.1%
                      </span>
                      <span class="text-muted">Since last month</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <canvas id="sales-chart" height="200"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> This year
                    </span>

                    <span>
                      <i class="fas fa-square text-gray"></i> Last year
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->

              <div class="card" hidden>
                <div class="card-header border-0">
                  <h3 class="card-title">Online Store Overview</h3>
                  <div class="card-tools">
                    <a href="#" class="btn btn-sm btn-tool">
                      <i class="fas fa-bars"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                  <!-- /.d-flex -->
                  <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="text-warning text-xl">
                      <i class="ion ion-ios-cart-outline"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                      <span class="font-weight-bold">
                        <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
                      </span>
                      <span class="text-muted">SALES RATE</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->
                  <!-- <div class="d-flex justify-content-between align-items-center mb-0">
                    <p class="text-danger text-xl">
                      <i class="ion ion-ios-people-outline"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                      <span class="font-weight-bold">
                        <i class="ion ion-android-arrow-down text-danger"></i> 1%
                      </span>
                      <span class="text-muted">REGISTRATION RATE</span>
                    </p>
                  </div> -->
                  <!-- /.d-flex -->
                </div>
              </div>
            </div>
            <!-- /.col-md-6 -->

            
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

</body>


<?php include('footer.php'); ?>


<script>
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
        $('#pending_order').text(obj.pending_order); // meaning new order in dashboard
        $('#unique_visit').text(obj.unique_visit);
        // console.log(obj.total_notif);

        //COMMENT NALANG NASA FOOTER NA YUNG DATA NITO
        // $('#total_notif').text(obj.total_notif);
        // $('#inside_total_notif').text(obj.total_notif+" Notifications");
        // $('#inside_body_total_notif').text(obj.total_notif+" products are required to restock.");
        // console.log(obj.check_stocks_data);

        // console.log(obj.total_sales);
        // $('#total_sales').text("₱"+obj.total_sales);
        
      }
    });
  }

  // setInterval(function () {getdata()}, 1000);




  showVisitGraph();
  //for charts
  function showVisitGraph(from, to)
  {
    $('.fa-spinner').attr('hidden',false);

    $.ajax({
      type: 'post',
      url: 'index_data.php',
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
          var total_visit_chart_count = 0;
          obj.data.forEach(element => {
            
              data.push(element[1]);//monday
              data.push(element[2]);//tuesday
              data.push(element[3]);//wed
              data.push(element[4]);//th
              data.push(element[5]);//f
              data.push(element[6]);//sat
              data.push(element[0]);//sunday


              total_visit_chart_count = element[7];
              created_at.push(element[8]);
          });

         

          var data_last_week = [];
          var total_visit_chart_count_last_week = 0;
          obj.data2.forEach(element => {
              data_last_week.push(element[1]);//monday
              data_last_week.push(element[2]);//tuesday
              data_last_week.push(element[3]);//wed
              data_last_week.push(element[4]);//th
              data_last_week.push(element[5]);//f
              data_last_week.push(element[6]);//sat
              data_last_week.push(element[0]);//sunday

              total_visit_chart_count_last_week = element[7];
          });
          // console.log(data_last_week);


          $('#total_visit_chart_count').text(total_visit_chart_count);
          total_visit_chart_count /= total_visit_chart_count_last_week;
          total_visit_chart_count *= 100;
          total_visit_chart_count = Number(Math.round(total_visit_chart_count + 'e' + 2) + 'e-' + 2);
          $('#visit_percentage_this_week').text(total_visit_chart_count+"%");


          // var check_stocks_data = [];
          // obj.check_stocks_data.forEach(element => {
          //   check_stocks_data.push(element[0]);
          // });
          // console.log("check_stocks_data_id: ");
          // console.log(check_stocks_data);


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

          var visitorsChartv2 = $('#visitors-chart-v2');
          var visitorsChart = new Chart(visitorsChartv2, {
              data: {
                labels: [ 'M', 'T', 'W', 'TH', 'F', 'Sat','S'],
                // labels: s,
                datasets: [{
                    type: 'line',
                    // data: [100, 120, 170, 167, 180, 177, 160],
                    data: data,
                    backgroundColor: 'transparent',
                    borderColor: '#ff8a5d',
                    pointBorderColor: '#ff8a5d',
                    pointBackgroundColor: '#ff8a5d',
                    fill: false,
                    // pointHoverBackgroundColor: '#007bff',
                    // pointHoverBorderColor    : '#007bff'
                  },
                  {
                      type: 'line',
                      // data: [60, 80, 70, 67, 80, 77, 100],
                      data: data_last_week,
                      backgroundColor: 'tansparent',
                      borderColor: '#ced4da',
                      pointBorderColor: '#ced4da',
                      pointBackgroundColor: '#ced4da',
                      fill: false
                      // pointHoverBackgroundColor: '#ced4da',
                      // pointHoverBorderColor    : '#ced4da'
                  }
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
                    intersect: intersect
                },
                legend: {
                    display: false
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
                            suggestedMax: 200
                        }, ticksStyle)
                      }
                    ],
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        ticks: ticksStyle
                      }
                    ]
                }
              }
          });
          // 


          var total_sales_chartv2 = $('#total-sales-chart');
          var total_sales_chart = new Chart(total_sales_chartv2, {
            type: 'bar',
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



  function showVisitGraphFilter(from, to)
  {
    $('.fa-spinner').attr('hidden',false);

    $.ajax({
      type: 'post',
      url: 'index_data.php',
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

<script>
  $(document).ready(function () {
    $('#top_products_table').DataTable({
      "processing":true,
      "serverSide": true,
      // scrollX:true,
      scrollY:'63vh',
      // "ordering":false,
      "lengthChange": false,
      "searching": false,
      "pageLength": 100,
      // "pagingType": "numbers",
      // lengthMenu:[[5,10,25,50,100,500],[5,10,25,50,100,500]],
      order: [[ 2, "DESC" ]],
      "ajax":{
      url:"fetch_top_products.php",
      type:"post",
      },  
      "columnDefs": [ 
      {
          "targets": 0,
          // "orderable": false,
          // "width": "25%", 
      },
      {
          "targets": 1,
          // "orderable": false,
          // "className": "order_id",
      },
      {
          "targets": 2,
          // "orderable": false,
      },
      // {
      //     "targets": 3,
      //     "orderable": false,
      // },
      
      ]
    });//end of #top_products_table

    $('.dataTables_paginate paging_simple_numbers').hide();
    // $(document).on('change','.date_filter', function  (e) {
    //   e.preventDefault();
    //   console.log('tignan mo sila iyak pre');
    //   console.log($('.date_filter').val());
    //   // $('#total-sales-chart').hide();
    //   console.log('changed_date_filter' + $(this).val());
    // });

   

    // date time picker
    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    var start = moment();
    var end = moment();
    var from_date,to_date;

    function cb(start, end) 
    {
        $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        from_date = start.format('YYYY-MM-DD');
        to_date = end.format('YYYY-MM-DD');
        // console.log(from_date +' '+to_date);
        $('.date_filter').val(from_date +' '+to_date)
        // console.log('tignan mo sila iyak pre');
        console.log($('.date_filter').val());
        $('#total-sales-chart').attr('hidden', true);
        $('#total-sales-chart-filtered').attr('hidden', false);
        showVisitGraphFilter(from_date, to_date);
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            // 'Today': [moment(), moment()],
            'Today': [moment().subtract(0, 'days'), moment().subtract(0, 'days')],
            // 'Today': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
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
      // $('#reportrange span').html('');

      // showVisitGraph();
      window.location="";

    });


  });


 
</script>