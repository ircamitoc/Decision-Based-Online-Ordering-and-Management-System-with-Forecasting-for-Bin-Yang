<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'admin/assets/phpmailer/src/Exception.php';
require 'admin/assets/phpmailer/src/PHPMailer.php';
require 'admin/assets/phpmailer/src/SMTP.php';

if(isset($_POST["send"])){
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'binyang.online@gmail.com'; // gmail
        $mail->Password = 'hhyznmnlpgeltdge'; // gmail app password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('binyang.online@gmail.com');// gmail

        $mail->addAddress($_POST["email"]);

        $mail->isHTML(true);

        // $mail->Subject = $_POST["subject"];
        // $mail->Body = $_POST["message"] ;

        //ph time
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d G:i:s");
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $db = mysqli_connect('localhost','u195190308_user','Oe&6]U+N','u195190308_shop_database');
        $con = new mysqli('localhost','u195190308_user','Oe&6]U+N','u195190308_shop_database');

        $generated_request_id_checker = 1;
        $email = $_POST["email"];


        while($generated_request_id_checker!=0){
            $generated_request_id = substr(sha1(mt_rand()),17,6);
            //get request detials
            $sql = "SELECT * FROM reset_request_tbl WHERE generated_request_id='$generated_request_id' LIMIT 1";
            $query=mysqli_query($con,$sql);
            $row=mysqli_fetch_assoc($query);

            if($row){ //existing

            }else{
                //not exsiting code.
                $generated_request_id_checker=0;

                $sql = "SELECT * FROM users_tbl WHERE username='$email' LIMIT 1";
                $query=mysqli_query($con,$sql);
                $row2=mysqli_fetch_assoc($query);

                if($row2){ //existing user
                    $query = "INSERT INTO reset_request_tbl (generated_request_id,email,request_date,request_user_ip) 
                    VALUES('$generated_request_id', '$email', '$date', '$user_ip')";
        
                    if(!mysqli_query($db, $query)){
                        
                    }else{
                        echo "
                            <script>
                                alert('Sent Successfully. Please check your Inbox or spam emails.'); 
                                document.location.href  ='login.php';
                            </script>
                        ";
                    }
                }else{
                    echo "
                        <script>
                            alert('Email is not existing.'); 
                            document.location.href  ='login.php';
                        </script>
                    ";
                }

                
            }
            
        }


        $mail->Subject = "Reset Password Link";
        $mail->Body = "Click this <a href='https://binyang.online/login?generated_request_id={$generated_request_id}'>Link</a> for your password reset.";

        $mail->send();


        
    }catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

?>