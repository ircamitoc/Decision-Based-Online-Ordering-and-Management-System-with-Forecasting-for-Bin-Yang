<?php 
include('db_connection.php'); 

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
  
//count visit
// $sql = "SELECT  COUNT(*) AS unique_visit FROM activity_logs  WHERE action='visit' ";
// $query=mysqli_query($con,$sql);
// $row=mysqli_fetch_array($query);
// $unique_visit = $row['unique_visit'];

//count notif for products
$sql = "SELECT  COUNT(*) AS total_notif FROM products_tbl WHERE product_quantity <=10 AND product_quantity >0 AND is_active=1 ";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$total_notif = $row['total_notif'];

//count notif for 0 products
$sql = "SELECT  COUNT(*) AS total_zero_quantity FROM products_tbl WHERE product_quantity <=0 AND is_active=1 ";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$total_zero_quantity = $row['total_zero_quantity'];

//count notif for new pending orders
$sql = "SELECT  COUNT(*) AS total_orders_notif FROM order_tbl  WHERE payment_status='pending' AND order_status!='on-going' ";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$total_orders_notif = $row['total_orders_notif'];

//count notif for new pending orders
$sql = "SELECT  COUNT(*) AS total_cancelled_paid_orders_notif FROM order_tbl  WHERE proof_of_payment!='' AND payment_status='approved' AND order_status='cancelled' ";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$total_cancelled_paid_orders_notif = $row['total_cancelled_paid_orders_notif'];


$all_notif_count = $total_notif  + $total_zero_quantity + $total_orders_notif + $total_cancelled_paid_orders_notif ;

// get stocks less than 10
$check_stocks_sql = "
    SELECT *
    FROM products_tbl
    WHERE product_quantity <=10
    AND is_active=1
    ORDER BY product_quantity
";

$result = mysqli_query($con,$check_stocks_sql);
$check_stocks_data=array();
while($row=mysqli_fetch_array($result)){
    $subdata=array();

    $subdata[] = $row['product_id'];
    
    $check_stocks_data[]=$subdata;
}





// ------------------------------ratings
$sql = "SELECT  AVG(ratings) AS average_ratings FROM rates_tbl";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$average_ratings =  number_format($row['average_ratings'], 2, ".", ",");

$sql = "SELECT  COUNT(ratings) AS five_star_ratings FROM rates_tbl WHERE ratings=5";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$five_star_ratings =  $row['five_star_ratings'];

$sql = "SELECT  COUNT(ratings) AS four_star_ratings FROM rates_tbl WHERE ratings=4";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$four_star_ratings =  $row['four_star_ratings'];

$sql = "SELECT  COUNT(ratings) AS three_star_ratings FROM rates_tbl WHERE ratings=3";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$three_star_ratings =  $row['three_star_ratings'];

$sql = "SELECT  COUNT(ratings) AS two_star_ratings FROM rates_tbl WHERE ratings=2";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$two_star_ratings =  $row['two_star_ratings'];

$sql = "SELECT  COUNT(ratings) AS one_star_ratings FROM rates_tbl WHERE ratings=1";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$one_star_ratings =  $row['one_star_ratings'];


$sql = "SELECT  COUNT(ratings) AS total_ratings FROM rates_tbl";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$total_ratings =  $row['total_ratings'];

$five_star_ratings_percentage =    ($five_star_ratings / $total_ratings) * 100;
$four_star_ratings_percentage =    ($four_star_ratings / $total_ratings) * 100 ;
$three_star_ratings_percentage =    ($three_star_ratings / $total_ratings) * 100 ;
$two_star_ratings_percentage =    ($two_star_ratings / $total_ratings) * 100 ;
$one_star_ratings_percentage =    ($one_star_ratings / $total_ratings) * 100 ;

$data = [
    // 'unique_visit' =>  $unique_visit,
    'pending_order' =>  $pending_order,
    'preparing_order' =>  $preparing_order,
    'delivering_order' =>  $delivering_order,
    'delivered_order' =>  $delivered_order,
    'cancelled_order' =>  $cancelled_order,
    'total_notif' =>  $total_notif,
    'total_zero_quantity' => $total_zero_quantity,
    'check_stocks_data' =>  $check_stocks_data,
    // 'total_sales' =>$total_sales,
    'total_orders_notif' => $total_orders_notif,
    'total_cancelled_paid_orders_notif' => $total_cancelled_paid_orders_notif,
    'all_notif_count' => $all_notif_count,
    'average_ratings' => $average_ratings,
    'five_star_ratings' =>$five_star_ratings_percentage,
    'four_star_ratings' => $four_star_ratings_percentage,
    'three_star_ratings' => $three_star_ratings_percentage,
    'two_star_ratings' => $two_star_ratings_percentage,
    'one_star_ratings' => $one_star_ratings_percentage,
    'total_ratings' =>$total_ratings,

];

echo json_encode($data);
?>