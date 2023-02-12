<?php 
include('db_connection.php'); 

$product_id = $_POST['id'];
$sql = "SELECT * FROM products_tbl WHERE product_id='$product_id' ";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
// $product_row = $row[0];
$product_row = $row['product'];
$price_row = $row['product_price'];
$quantity_row = $row['product_quantity'];



$add_ons_id = $_POST['add_ons'];
$sql = "SELECT * FROM add_ons_list_tbl WHERE add_ons_list_id='$add_ons_id' ";
$query=mysqli_query($con,$sql);
$row=mysqli_fetch_array($query);
$add_ons_name = $row['add_ons'];
$add_ons_price = $row['add_ons_price'];

$data = [
    'product_id' =>  $product_id,
    'product' =>  $product_row,
    'price' =>  $price_row,
    'quantity' =>  $quantity_row,
    'add_ons_name' => $add_ons_name,
    'add_ons_price' => $add_ons_price,
];

echo json_encode($data);
?>