<?php
    //including the needed files
    require_once("includes/Exception.php");
    require_once("includes/PHPMailer.php");
    require_once("includes/SMTP.php");

    //Creating namespaces
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //funtion for sanitizing Form inputs
    function sanitizeString($var)
    {
        $var = stripslashes($var);
        $var = trim($var);
        $var = htmlspecialchars($var);
        return $var;
    }

    //Email Sender function
    function sendEmail($receiver, $subject, $message)
    {

        $agency_email_address = "peakspottech@gmail.com";

        //Creating instance of phpmailer;
        $mail = new PHPMailer();

        //setting mailer to use smtp
        $mail->isSMTP();

        //define smtp host
        $mail->Host = "smtp.gmail.com";

        //enable smtp authentication
        $mail->SMTPAuth = "true";

        //Setting type of encryption
        $mail->SMTPSecure = "tls";

        //Setting port to connect smtp
        $mail->Port = "587";

        //set gmail username 
        $mail->Username = $agency_email_address;

        //set gmail password
        $mail->Password = "presh1900";

        //set email subject 
        $mail->Subject = $subject;

        //set sender email
        $mail->setFrom($agency_email_address);

        //Enable HTMl sending
        $mail->isHTML(true);

        //adding Attachment
        if($receiver!=$agency_email_address){
            $mail->addAttachment("img/handshake.jpeg");
        }

        //set email Body
        $mail->Body = $message;

        //Add recever
        $mail->addAddress($receiver);

        //Sending Email
        if ($mail->Send()) {
            return true;
        } else {
            return false;
        }

        //Closing smtp connection
        $mail->smtpClose();
    }


    //Client message variables
    $client_name = sanitizeString($_REQUEST['name']);
    
    $email_to_client_subject = "Nice Meeting you";

    $receiver = sanitizeString($_REQUEST['email']);
    
    $message = <<<_HTML
    <div style="margin: 0; width: 250px ; height: 250px; background-color: rgba(240, 248, 255, 0.78);">

    <div style="padding: 40px;">
        <h3>Thank you</h3>
        <h4 style="color:rgb(218, 38, 68); font-style: italic;">Hi $client_name, I am so glad upon receipt of your email. Looking forward to smooth partnership with you!</h4>
    </div>
</div>
_HTML;

    //self messaging variable
    $my_email = "ayotunde1900@gmail.com";

    $mail_title = sanitizeString($_REQUEST['subject']);

    $mail_to_me_subject = "$client_name messaged you from Portfolio Page";

    $mail_message = sanitizeString($_REQUEST['message']);

    $mail_to_me_body = "<h1>$mail_title</h1>" . $mail_message;

   
    // //mail to the self
    $send_to_self = sendEmail($my_email, $mail_to_me_subject, $mail_to_me_body);

    if($send_to_self == true){
        // //Mail to client
        $send_for_client = sendEmail($receiver, $email_to_client_subject, $message);
        if($send_for_client == true){
            echo "1";
        }else{
            echo "0";
        }
    }else{
        echo "0";        
    }


?>