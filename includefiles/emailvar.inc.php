<?php
  namespace PHPMailer\PHPMailer;
  //namespace PHPMailer\Exception;
  include('phpmailer/PHPMailer.php');
  include('phpmailer/SMTP.php'); 
  include('phpmailer/Exception.php');
  include('includefiles/header.inc.php');
  
  $mail = new PHPMailer;
  $mail->isSMTP();
  $mail->Host='smtp.gmail.com';
  //$mail->Host = gethostbyname('smtp.gmail.com');
  $mail->Port = 465;//587;
  $mail->SMTPSecure ='ssl';//'tls';
  $mail->SMTPAuth = true;
  $mail->Username = "kakumeistudios.55@gmail.com";
  $mail->Password = "kakumei5555";
  $email="";
  $varcode=0;
  if(isset($_GET['user']))
   {
	    $username=$_GET['user'];
    	$sql="SELECT useremail,token FROM users WHERE username="."'$username'".";";
		$result=mysqli_query($conn,$sql);
        if(1==mysqli_num_rows($result))
		{
			$content=mysqli_fetch_assoc($result);
			$email=$content['useremail'];
			$varcode=$content['token'];
		}		
   }
   echo $email;
   echo $varcode;
  $mail->setFrom('kakumeistudios.55@gmail.com', 'KakumeiStudios');
  $mail->addAddress($email);
  $mail->Subject = 'Verification Mail';  
  $mail->Body = "Your are one step away from having your own account.Please verifiy it is your own email with the verification code.</br>Your verficaton code is=".$varcode."</br></br> <b>KakumeiStudios<b>";
  $mail->IsHTML(true);
  if(!$mail->send()) 
   {
    echo "failure";
   } 
  else 
   {
     echo"success";
	 header("Location:verification.php?user='$username'");
   }	
		 	 
?>