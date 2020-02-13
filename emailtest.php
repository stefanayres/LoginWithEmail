<?php 
date_default_timezone_set('Europe/London');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'include/PHPMailer/src/Exception.php';
require 'include/PHPMailer/src/PHPMailer.php';
require 'include/PHPMailer/src/SMTP.php';

$email      = $_GET['email'];
$name       = $_GET['name'];

date_default_timezone_set('Europe/London');
$newTimestamp = date("d-m-Y H:i:s");

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;
    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
   

    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587; // 465
    $mail->SMTPAuth = true;


    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "*******@gmail.com";
    //Password to use for SMTP authentication
    $mail->Password = "Sales19!";
    //Set who the message is to be sent from - person registering 
    $mail->setFrom("*********@gmail.com", "CompanyForms");
    //Set who the message is to be sent to
    ////$mail->addAddress('*****@Company.ie', 'Company');
    
    $mail->addAddress('*******@Company.ie', 'Company'); //test email
    
    //Set the subject line
    $mail->Subject = 'FreeNow Drivers Form Reg';
    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    // $mail->msgHTML(file_get_contents('contents.html'), __DIR__);
    $mail->isHTML(true);
    //Replace the plain text body with one created manually
    $mail->Body = 'Driver List has a new register. '.$name.' wants access. Email: '.$email.'. Timestamp: '.$newTimestamp.'.';
    //Attach an image file
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
       echo "Message sent!";
    }
  
    
