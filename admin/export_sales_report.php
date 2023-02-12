<?php 


    include('db_connection.php');

    $output = '';

    if(isset($_POST["export_sales"])){

        $date = $_POST['date'];
        $product_filter = $_POST['product_filter'];
        $user_filter = $_POST['user_filter'];

        $search = array(
            'date' =>  ($date!='')?$date:'',
            'product_filter' =>  ($product_filter!='')?$product_filter:'ALL',
            'user_filter' =>  ($user_filter!='')?$user_filter:'ALL',
        );

        $condition = " 1=1 AND order_status = 'delivered' AND order_payment>0 ";

        if($search['product_filter'] != 'ALL'){

            $condition .= ' AND (';

            $product_filter = str_replace(",", "','", $search['product_filter']);

            $condition .= "availed_product IN ('$product_filter') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        if($search['user_filter'] != 'ALL'){

            $condition .= ' AND (';

            $user_filter = str_replace(",", "','", $search['user_filter']);

            $condition .= "order_by IN ('$user_filter') ";

            $condition .= ')';
        }
        else{
            $condition .= '';
        }

        $condition .= ($search['date'] != '')? " AND DATE(updated_at) BETWEEN '".substr($search['date'], 0,10)."' AND '".substr($search['date'], 11,10)."' " : '';

        $sql = "
            SELECT *
            FROM order_tbl 
            LEFT JOIN availed_product_tbl 
            ON order_tbl.order_id = availed_product_tbl.order_id 
            WHERE $condition
        ";


        $result = mysqli_query($con, $sql);

        if(mysqli_num_rows($result)>0){
            $output .= '
                <table class="table" border="1">
                    <tr>
                        <th>DATE</th>
                        <th>PRODUCT</th>
                        <th>ADD-ONS</th>
                        <th>ORDER FROM</th>
                        <th>QUANTITY</th>
                        <th>PRICE</th>
                        <th>TOTAL</th>
                    </tr>
            ';
            $total_sales = 0;
            while($row = mysqli_fetch_array($result)){
                //add-ons details
                $availed_product = $row[16]; // availed_product
                $add_ons_list_query = "
                    SELECT * 
                    FROM add_ons_tbl
                    WHERE order_id = $row[0]
                    AND product='$availed_product' 
                    AND availed_id=$row[15]
                ";
                $add_ons_list = '';
                $add_ons_total = 0;
                $add_ons_result_list = $con->query($add_ons_list_query);
                if ($add_ons_result_list->num_rows>0) {
                    while ($add_ons_row = $add_ons_result_list->fetch_assoc()){
                        $add_ons_list .= $add_ons_row['add_ons']."<br>";
                        $add_ons_total += $add_ons_row['add_ons_price'];
                    }
                }

                $add_ons_display = '';
                if($add_ons_total>0){
                    $add_ons_display = "<br> + &#8369;".str_replace('.00', '', number_format($add_ons_total, 2, '.', '')) . " add ons";
                }

                $output .= '
                    <tr>
                        <td>'.$row["updated_at"].'</td>
                        <td>'.$row["availed_product"].'</td>
                        <td>'.$add_ons_list.'</td>
                        <td>'.$row["order_by"].'</td>
                        <td>'.$row["availed_quantity"].'</td>
                        <td align="left"> &#8369;'.str_replace('.00', '', number_format($row["availed_price"], 2, '.', '')).$add_ons_display.'</td>
                        <td>'.str_replace('.00', '', number_format($row["availed_amount"]+$add_ons_total, 2, '.', '')).'</td>
                    </tr>
                ';
                $total_sales += $row["availed_amount"] + $add_ons_total;
            }

            $output .='
                <tfoot>
                    <tr>
                        <th colspan="6" align="left">Total</th>
                        <th >&#8369;'.str_replace('.00', '', number_format($total_sales, 2, '.', '')).'</th>
                    </tr>
                </tfoot>
            ';
            $output .= '</table>';

            header("Content-Type: application/xls"); // orig
            header("Content-Disposition:attachment; filename=export/export_sales.xls");

            // header("Content-Type: application/vnd.ms-excel");
            // header("Content-disposition: attachment; filename=spreadsheet.xls");

            // header("Content-type: application/text/x-csv");
            // header("Content-disposition: attachment; filename=export_sales.csv");

            // echo $sql;
            echo $output;

        }
    }// end isset


?>