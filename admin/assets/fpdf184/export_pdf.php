<?php 

require('fpdf.php');

class myPDF extends FPDF{
    function header(){

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
        $db = mysqli_connect('localhost','u195190308_user','Oe&6]U+N','u195190308_shop_database');
        $result = mysqli_query($db, $order_check_query);
        $row = mysqli_fetch_assoc($result);
        // $order_by = $row['order_by'];
        // $order_discount = $row['order_discount'];
        // $order_amount = $row['order_amount'];
        // $order_payment = $row['order_payment'];
        // $order_change = $row['order_change'];
        $date_create = date_create($row['order_date']);
        $order_date = date_format($date_create,"Y-m-d");
        $order_time = date_format($date_create,"h:i a");
    
        // $payment_method = $row['payment_method'];
        // $delivery_address = $row['delivery_address'];
        // $order_message = $row['order_message'];


        $this->Image('../../../img/logo.png', 70, 12,);
        $this->Ln();
        $this->SetFont('Arial', '', 14);
        $this->Cell(90,5,'Order ID: '.$order_id,0,0,'L');
        $this->Ln();
        $this->Cell(90,5,'Date: '.$order_date,0,0,'L');
        $this->Ln();
        $this->Cell(180,5,'Time: '.$order_time,0,0,'L');
        $this->Ln(8);
        $this->Cell(170,5,'Original Receipt',0,0,'C');
        $this->Ln();
        // $this->SetFont('Times','',12);
        // $this->Cell(276,10,'Street Address of Employee Office', 0 , 0, 'R');
        // $this->Ln(20);

    }
    function footer(){
        // $this->SetY(-15);
        // $this->SetFont('Arial','',8);
        // $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    function headerTable($id){

        $order_check_query = "
            SELECT * 
            FROM order_tbl 
            WHERE order_id='$id'
        ";
        $db = mysqli_connect('localhost','u195190308_user','Oe&6]U+N','u195190308_shop_database');
        $result = mysqli_query($db, $order_check_query);
        $row = mysqli_fetch_assoc($result);
        $order_by = $row['order_by'];
        $order_discount = $row['order_discount'];
        $order_amount = $row['order_amount'];
        $order_payment = $row['order_payment'];
        $order_change = $row['order_change'];
        $date_create= date_create($row['order_date']);
        // $order_date = date_format($date_create,"Y-m-d");
        // $order_time = date_format($date_create,"h:i a");
        // $payment_method = $row['payment_method'];
        // $delivery_address = $row['delivery_address'];
        $order_message = $row['order_message'];

        $this->SetFont('Arial','',12);
        $this->Cell(60,7,'PRODUCT',1,0,'C');
        $this->Cell(30,7,'ADD ONS',1,0,'C');
        $this->Cell(20,7,'QTY',1,0,'C');
        $this->Cell(30,7,'RATE',1,0,'C');
        $this->Cell(25,7,'AMOUNT',1,0,'C');

        $con = new mysqli('localhost','u195190308_user','Oe&6]U+N','u195190308_shop_database');
        $availed_product_list_query = "SELECT * FROM availed_product_tbl WHERE order_id = '$id' " ;
        $result_list = $con->query($availed_product_list_query);
        if ($result_list->num_rows>0) {
            $total_sales = 0;
            $total_row_lines = 42;
            while ($availed_row = $result_list->fetch_assoc()){ 
                $availed_id = $availed_row['availed_id'];
                $availed_product = $availed_row['availed_product'];
                $availed_price = $availed_row['availed_price'];
                $availed_quantity = $availed_row['availed_quantity'];
                $availed_amount = $availed_row['availed_amount'];

                $this->Ln(8);
                $this->Cell(60,7,$availed_row['availed_product'],0,0,'L');

                    //get add ons details
                    $add_ons_total = 0;
                    $add_ons_list = "   
                        SELECT * 
                        FROM add_ons_tbl
                        WHERE order_id = $id
                        AND product='$availed_product' 
                        AND availed_id='$availed_id' 
                    "; 
                    $add_ons_result_list = $con->query($add_ons_list);
                    if ($add_ons_result_list->num_rows>0) {
                        $add_ons = '';
                        while ($add_ons_row = $add_ons_result_list->fetch_assoc()){ 
                            $add_ons .= $add_ons_row['add_ons'];
                            //get addons total
                            $add_ons_total += $add_ons_row['add_ons_price'];
                            $add_ons_price = $add_ons_row['add_ons_price']/$availed_quantity;
                        }
                        $this->Cell(30,7,$add_ons,0,0,'L');
                    }else{
                        $this->Cell(30,7,'',0,0,'R');
                    }

                    $add_ons_display_total = '';
                    if($add_ons_total>0){
                        $add_ons_display_total .= " + P" . $add_ons_price;
                    }

                $this->Cell(20,7,$availed_row['availed_quantity'],0,0,'R');
                $this->Cell(30,7,"P".$availed_price.$add_ons_display_total,0,0,'R');
                $this->Cell(25,7,"P".$this->setNumberFormat($availed_amount+$add_ons_total),0,0,'R');

                $total_sales += $availed_row["availed_amount"] + $add_ons_total;

                $total_row_lines+=8;
            }
           

            $this->SetDash(); //restores no dash
            $this->Line(10,$total_row_lines,170,$total_row_lines);
            $this->Ln(12);
            $this->Cell(60,0,'',0,0,'R');
            $this->Cell(30,0,'',0,0,'R');
            $this->Cell(20,0,'',0,0,'R');
            $this->Cell(30,0,'Subtotal ',0,0,'R');
            $this->Cell(25,0,"P".str_replace('.00', '', number_format($order_amount, 2, '.', '')),0,0,'R');
            
            $this->Ln(5);
            $this->Cell(60,0,'',0,0,'R');
            $this->Cell(30,0,'',0,0,'R');
            $this->Cell(20,0,'',0,0,'R');
            $this->Cell(30,0,'Discount ',0,0,'R');
            $this->Cell(25,0,"P".str_replace('.00', '', number_format($order_discount, 2, '.', '')),0,0,'R');
            
            $this->Ln(5);
            $this->Cell(60,0,'',0,0,'R');
            $this->Cell(30,0,'',0,0,'R');
            $this->Cell(20,0,'',0,0,'R');
            $this->Cell(30,0,'To Pay ',0,0,'R');
            $this->Cell(25,0,"P".str_replace('.00', '', number_format($order_amount, 2, '.', '')),0,0,'R');
            
            $this->Ln(5);
            $this->Cell(60,0,'',0,0,'R');
            $this->Cell(30,0,'',0,0,'R');
            $this->Cell(20,0,'',0,0,'R');
            $this->Cell(30,0,'Payment ',0,0,'R');
            $this->Cell(25,0,"P".str_replace('.00', '', number_format($order_payment, 2, '.', '')),0,0,'R');
            
            $this->Ln(5);
            $this->Cell(60,0,'',0,0,'R');
            $this->Cell(30,0,'',0,0,'R');
            $this->Cell(20,0,'',0,0,'R');
            $this->Cell(30,0,'Change ',0,0,'R');
            $this->Cell(25,0,"P".str_replace('.00', '', number_format($order_change, 2, '.', '')),0,0,'R');
            
           
            $this->Ln(3);
            $this->SetDash(2,2); //5mm on, 5mm off
            $this->Line(10,$total_row_lines+27,169,$total_row_lines+27);

            $this->Ln(5);
            $this->Cell(60,0,'',0,0,'R');
            $this->Cell(30,0,'',0,0,'R');
            $this->Cell(20,0,'',0,0,'R');
            $this->Cell(30,0,'Total ',0,0,'R');
            $this->Cell(25,0,"P".str_replace('.00', '', number_format($order_amount, 2, '.', '')),0,0,'R');

            $this->SetDash(2,2); //5mm on, 5mm off
            $this->Line(10,$total_row_lines+35,169,$total_row_lines+35);

            $this->Ln(10);
            $this->Cell(60,0,'Ordered By : '.$order_by,0,0,'L');
            $this->Ln(5);
            $this->Cell(60,0,'Message: '.$order_message,0,0,'L');
            // $this->Ln(5);
            // $this->WriteHTML(60,0,'Delivery Address: '.$delivery_address,0,0,'L');
            $this->Ln(10);
            $this->Cell(170,0,'Thank you for your visit! ',0,0,'C');
            $this->Ln(5);
            $this->Cell(170,0,'@Bin Yang Coffee & Tea',0,0,'C');
            $this->Ln(5);
            $this->Cell(170,0,'92 Mercado St, Platero Bi'.chr(241).'an City, Laguna',0,0,'C');
            $this->Ln(5);
            $this->Cell(170,0,'Everyday: 2:00 PM - 10:00 PM',0,0,'C');
            $this->Ln(5);
            $this->Cell(170,0,'Experience #BinYang ,The Coffee & Tea of Life',0,0,'C');
            $this->Ln(5);
            $this->Cell(170,0,'www.binyang.online',0,0,'C');

        }
       
        

       
       

    }

    function setNumberFormat($number){
        $setNumberFormat =  number_format($number, 2, ".", ",");
        $get_decimal_number = substr($setNumberFormat, -2);
        if($get_decimal_number == "00"){
            return substr($setNumberFormat, 0, -3);
        }else{
            return $setNumberFormat;
        }

    }

    function SetDash($black=null, $white=null)
    {
        if($black!==null)
            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }
}

$pdf = new myPDF();
// $pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$id = $_GET['order_id'];
$pdf->headerTable($id);
 // $this->SetDash(); //restores no dash
        // $this->Line(10,60,150,60);


$pdf->Output();

?>