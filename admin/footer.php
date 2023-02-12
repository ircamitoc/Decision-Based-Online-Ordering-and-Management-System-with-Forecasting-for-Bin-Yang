<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="#">BIN-YANG Coffee & Tea</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 1.0.0
    </div>
</footer>


</div>


<!-- !!!!!!!!!!!!!!!! -->
<!-- SCRIPTS! -->
<!-- !!!!!!!!!!!!!!!! -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- <script src="dist/js/pages/dashboard3.js"></script> -->
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"> </script>
<!-- swal -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script>
    $(document).ready(function () {
        console.log($(location).attr('pathname').match(/([^\/]*)\/*$/)[1]);
        var page_location = $(location).attr('pathname').match(/([^\/]*)\/*$/)[1];
        if(page_location=="index" || page_location=='admin'){
            console.log('index')
            $('#Dashboard').addClass( "active" );
        }
        if(page_location=="inventory"){
            console.log('inventory')
            $('#Inventory').addClass( "active" );
        }
        if(page_location=="user_management"){
            console.log('user_management')
            $('#User_management').addClass( "active" );
        }
        if(page_location=="order_management"){
            console.log('order_management')
            $('#Order_management').addClass( "active" );
        }
        
        if(page_location=="sales_reports"){
            console.log('sales_reports')
            $('#Sales_report').addClass( "active" );
        }

        if(page_location=="sales_forecast"){
            console.log('sales_forecast')
            $('#Sales_forecast').addClass( "active" );
        }

        if(page_location=="feedback_reports"){
            console.log('feedback_reports')
            $('#Feedback_reports').addClass( "active" );
        }

        if(page_location=="activity_logs"){
            console.log('activity_logs')
            $('#Activity_logs').addClass( "active" );
        }

        // script to get the currentnotif
        function getdata(){
            $.ajax({
            type: 'post',
            url: 'get_order_count.php',
            success: function (response) {
                // console.log(response);
                // $('#pending_order').text(response);

                var obj = JSON.parse(response);

                $('#pending_order').text(obj.pending_order); // meaning new order in dashboard
                $('#unique_visit').text(obj.unique_visit); // meaning unique visit in dashboard

                
                $('#total_notif').text(obj.all_notif_count);
                $('#inside_total_notif').text(obj.all_notif_count+" Notifications");
              
                $('#inside_body_total_zero_qty_notif').text(obj.total_zero_quantity+" Product(s) are out of stock.");
                if(obj.total_zero_quantity==0){
                    $('#inside_body_total_zero_qty_notif').parent().attr('hidden',true);
                }else{
                    $('#inside_body_total_zero_qty_notif').parent().attr('hidden',false);
                }

                $('#inside_body_total_notif').text(obj.total_notif+" Product(s) are required to restock.");
                if(obj.total_notif==0){
                    $('#inside_body_total_notif').parent().attr('hidden',true);
                }else{
                    $('#inside_body_total_notif').parent().attr('hidden',false);
                }

                $('#order_management_notif').text(obj.total_orders_notif+" Pending proof of payment(s).");
                if(obj.total_orders_notif==0){
                    $('#order_management_notif').parent().attr('hidden',true);
                }else{
                    $('#order_management_notif').parent().attr('hidden',false);
                }

                $('#order_management_cancel_paid_order_notif').text(obj.total_cancelled_paid_orders_notif+" Pending refund cancelled orders.");
                // console.log("obj.total_cancelled_paid_orders_notif" +obj.total_cancelled_paid_orders_notif);
                if(obj.total_cancelled_paid_orders_notif==0){
                    $('#order_management_cancel_paid_order_notif').parent().attr('hidden',true);
                }else{
                    $('#order_management_cancel_paid_order_notif').parent().attr('hidden',false);
                }

                $('#average_star_rating').text(obj.average_ratings);
                var star = '<i class="fas fa-star text-warning"></i>';
                var stars = '';
                for (let index = 1; index <= Math.ceil(obj.average_ratings); index++) {
                    stars+=star;
                }
                $('#stars').html(stars);

                

                var fire_star_ratings = parseFloat(obj.five_star_ratings).toFixed(2);
                var four_star_ratings = parseFloat(obj.four_star_ratings).toFixed(2);
                var three_star_ratings = parseFloat(obj.three_star_ratings).toFixed(2);
                var two_star_ratings = parseFloat(obj.two_star_ratings).toFixed(2);
                var one_star_ratings = parseFloat(obj.one_star_ratings).toFixed(2);
                // console.log('-');
                // console.log(fire_star_ratings);
                // console.log(four_star_ratings);
                // console.log(three_star_ratings);
                // console.log(two_star_ratings);
                // console.log(one_star_ratings);
                // console.log('-');

                $('#five_star_rating').text(fire_star_ratings+"%");
                $('#four_star_rating').text(four_star_ratings+"%");
                $('#three_star_rating').text(three_star_ratings+"%");
                $('#two_star_rating').text(two_star_ratings+"%");
                $('#one_star_rating').text(one_star_ratings+"%");
                $('#total_ratings').text(obj.total_ratings+" ratings");

                $('#five_star_rating').css('width', fire_star_ratings+"%");
                $('#four_star_rating').css('width', four_star_ratings+"%");
                $('#three_star_rating').css('width', three_star_ratings+"%");
                $('#two_star_rating').css('width', two_star_ratings+"%");
                $('#one_star_rating').css('width', one_star_ratings+"%");
            }
            });
        }

        setInterval(function () {getdata()}, 1000);

       
    });
</script>

</html>