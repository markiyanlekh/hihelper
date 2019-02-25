<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if  ($_POST["first-name"])
    $f_name=$_POST["first-name"];
  else $f_name="Empty";
  
    if  ($_POST["last-name"])
    $l_name=$_POST["last-name"];
  else $l_name="Empty";
  
  if  ($_POST["email"]) 
    $email=$_POST["email"];
   else 
    $email = "Empty";
  
    
  if ($_POST["message"])
    $msg=$_POST["message"];
   else $msg="Empty"; 

    $to = "markiyan.lekh@gmail.com";

    $subject = "Form submission";
    $message = $f_name . " " . $l_name . " wrote the following:" . "\n\n" . $msg;

    $header = "From: ".$email."\r\n"; 
$header.= "MIME-Version: 1.0\r\n"; 
$header.= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
$header.= "X-Priority: 1\r\n"; 
 

    mail($to,$subject,$message);
    echo "Mail Sent. Thank you " . $f_name . ", we will contact you shortly.";
    


}
?>