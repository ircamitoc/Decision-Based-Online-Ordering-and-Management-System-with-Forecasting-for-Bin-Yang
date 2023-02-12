
<?php 

    include('db_connection.php'); 
    
    if(isset($_GET['order_id'])){
        $order_id =  $_GET['order_id'];
    }
    
    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d h:i:s');

    $order_check_query = "
        SELECT * 
        FROM order_tbl 
        WHERE order_id='$order_id'
    ";
    $result = mysqli_query($db, $order_check_query);
    $row = mysqli_fetch_assoc($result);
    $order_by = $row['order_by'];
    $order_discount = $row['order_discount'];
    $order_amount = $row['order_amount'];
    $order_payment = $row['order_payment'];
    $order_change = $row['order_change'];
    $date_create= date_create($row['order_date']);
    $order_date = date_format($date_create,"Y-m-d");
    $order_time = date_format($date_create,"h:i a");
    $payment_method = $row['payment_method'];
    $delivery_address = $row['delivery_address'];
    $order_message = $row['order_message'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | BIN-YANG </title>
  <link rel="icon" type="image/png" href="../icon.png">

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'PT Sans', sans-serif;
        }

        @page {
            size: 2.8in 11in;
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
        }

        table {
            width: 100%;
        }

        tr {
            width: 100%;

        }

        h1 {
            text-align: center;
            vertical-align: middle;
        }

        #logo {
            width: 60%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            padding: 5px;
            margin: 2px;
            display: block;
            margin: 0 auto;
        }

        header {
            width: 100%;
            text-align: center;
            -webkit-align-content: center;
            align-content: center;
            vertical-align: middle;
        }

        .items thead {
            text-align: center;
        }

        .center-align {
            text-align: center;
        }

        .bill-details td {
            font-size: 12px;
        }

        .receipt {
            font-size: medium;
        }

        .items .heading {
            font-size: 12.5px;
            text-transform: uppercase;
            border-top:1px solid black;
            margin-bottom: 4px;
            border-bottom: 1px solid black;
            vertical-align: middle;
        }

        .items thead tr th:first-child,
        .items tbody tr td:first-child {
            width: 47%;
            min-width: 47%;
            max-width: 47%;
            word-break: break-all;
            text-align: left;
        }

        

        .items td {
            font-size: 12px;
            text-align: right;
            vertical-align: bottom;
        }

        .price::before {
             content: "₱";
            font-family: Arial;
            text-align: right;
        }

        .sum-up {
            text-align: right !important;
        }
        .total {
            font-size: 13px;
            border-top:1px dashed black !important;
            border-bottom:1px dashed black !important;
        }
        .total.text, .total.price {
            text-align: right;
        }
        .total.price::before {
            content: "₱"; 
        }
        .line {
            border-top:1px solid black !important;
        }
        .heading.add-ons {
            width: 20%;
            text-align: left;
        }
        .heading.rate {
            width: 20%;
        }
        .heading.amount {
            width: 25%;
        }
        .heading.qty {
            width: 10%
        }
        p {
            padding: 1px;
            margin: 0;
        }
        section, footer {
            font-size: 12px;
        }
    </style>
</head>

<body style="max-width:500px;">
    <header>
        <div id="logo" class="media" data-src="logo.png" src="./logo.png"></div>

    </header>
    <p>Order ID : <?=$order_id?></p>
    <table class="bill-details">
        <tbody>
            <tr>
                <td>Date : <span><?= $order_date ?></span></td>
                <td>Time : <span><?= $order_time ?></span></td>
            </tr>
            <!-- <tr>
                <td>Table #: <span>3</span></td>
                <td>Bill # : <span>4</span></td>
            </tr> -->
            <tr>
                <th class="center-align" colspan="2"><span class="receipt">Original Receipt</span></th>
            </tr>
        </tbody>
    </table>
    
    <table class="items">
        <thead>
            <tr>
                <th class="heading name">Product</th>
                <th class="heading add-ons">&nbsp;&nbsp;&nbsp;Add&nbsp;ons&nbsp;&nbsp;&nbsp;</th>
                <th class="heading qty" >Qty</th>
                <th class="heading rate">Rate</th>
                <th class="heading amount">Amount</th>
            </tr>
        </thead>
       
        <tbody>
            <?php 
                $availed_product_list_query = "SELECT * FROM availed_product_tbl WHERE order_id = '$order_id' " ;
                $result_list = $con->query($availed_product_list_query);
                if ($result_list->num_rows>0) {
                    $sub_total = 0;
                    while ($availed_row = $result_list->fetch_assoc()){ 
                        $availed_id = $availed_row['availed_id'];
                        $availed_product = $availed_row['availed_product'];
            ?>
                        <tr>
                            <td><?= $availed_product?></td>
                            <td class="add-ons-class" >
                                <?php 
                                    $add_ons_total = 0;
                                    $add_ons_list = "   
                                        SELECT * 
                                        FROM add_ons_tbl
                                        WHERE order_id = $order_id
                                        AND product='$availed_product' 
                                        AND availed_id='$availed_id' 
                                    "; 
                                    $add_ons_result_list = $con->query($add_ons_list);
                                    if ($add_ons_result_list->num_rows>0) {
                                        while ($add_ons_row = $add_ons_result_list->fetch_assoc()){ 
                                        echo $add_ons_row['add_ons']."<br>";
                                        //get addons total
                                        $add_ons_total += $add_ons_row['add_ons_price'];
                                        }
                                    }

                                    $add_ons_display = '';
                                    $add_ons_display_total = '';
                                    if($add_ons_total>0){
                                        $add_ons_display = "<br> + ₱$add_ons_total add ons";
                                        
                                        $add_ons_display_total .= "+ ₱" . $add_ons_total;
                                    }
                             
                                ?>
                            </td>
                            <td><?= $availed_row['availed_quantity'] ?></td>
                            <td class="price"><?= $availed_row['availed_price'] ?> <?= $add_ons_display_total ?></td>
                            <td class="price"><?= setNumberFormat($availed_row['availed_amount']+$add_ons_total);  ?></td>
                        </tr>
            <?php       
                        $sub_total+=$availed_row['availed_amount'];
                        $sub_total+=$add_ons_total;
                    }//end while
                }//end if

                function setNumberFormat($number){
                    $setNumberFormat =  number_format($number, 2, ".", ",");
                    $get_decimal_number = substr($setNumberFormat, -2);
                    if($get_decimal_number == "00"){
                        echo substr($setNumberFormat, 0, -3);
                    }else{
                        echo $setNumberFormat;
                    }

                }
            ?>
            
            <tr>
                <td colspan="4" class="sum-up line">Subtotal</td>
                <td class="line price"><?= setNumberFormat($sub_total) ?></td>
            </tr>
            

            <tr>
                <td colspan="4" class="sum-up">Discount</td>
                <td class="price"><?= setNumberFormat($order_discount) ?></td>
            </tr>

            <tr>
                <td colspan="4" class="sum-up">To pay</td>
                <td class="price"><?= setNumberFormat($order_amount) ?></td>
            </tr>
            
            <tr>
                <td colspan="4" class="sum-up">Payment</td>
                <td class="price"><?= setNumberFormat($order_payment) ?></td>
            </tr>

            <tr>
                <td colspan="4" class="sum-up">Change</td>
                <td class="price"><?= setNumberFormat($order_change) ?></td>
            </tr>
            <tr>
                <th colspan="4" class="total text">Total</th>
                <th class="total price"><?= setNumberFormat($order_amount) ?></th>
            </tr>
        </tbody>
    </table>
    <section>
        <p>
            Cashier : <span><?= strtoupper($payment_method) ?></span>
        </p>
        <p>
            Message : <span><?= $order_message ?></span>
        </p>
       
    </section>
    <footer style="text-align:center;margin-top:20px">
        <p style="text-align:center">
            Thank you for your visit!
        </p>
        <p>@Bin Yang Coffee & Tea</p>
        <p>92 Mercado St, Platero Biñan City, Laguna</p>
        <p>Everyday: 2:00 PM - 10:00 PM</p>
        <p>Experience #BinYang ,The Coffee & Tea of Life</p>
        <p><a href="https://binyang.online/">www.binyang.online</a></p>
    </footer>
</body>

</html>