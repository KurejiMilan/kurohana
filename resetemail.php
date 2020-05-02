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
  $mail->Port = 465;//587;
  $mail->SMTPSecure ='ssl';//'tls';
  $mail->SMTPAuth = true;
  $mail->Username = "kakumeistudios.55@gmail.com";
  $mail->Password = "kakumei5555";
  $email="";
 
  $sql="SELECT useremail FROM users WHERE username = ?;";
	$stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) == 1){
      $content=mysqli_fetch_assoc($result);
      $email=$content['useremail'];
    } 
  }
	
  $mail->setFrom('kakumeistudios.55@gmail.com', 'KakumeiStudios');
  $mail->addAddress($email);
  $mail->Subject = 'Password has been reset';  
  $mail->Body = "
  <html>
  <head>
  </head>
  <body>
    <h2 style='text-align:center;'>Password has been reset</h2><br>
    <section><p>Hello <b>".$user."</b>.,your password has been reset through this device .If you are the who reset the password then you can
    ignore this meassage,but if you haven't reset your password using using this device then you can report it to us.</p></section>
    <section><b>From Kuronaha</b></section>
  </body>
  </html>
  ";
  $mail->IsHTML(true);
  if(!$mail->send()){ 
  echo "failure";
  }else {
  echo"success";
	}
		 	 
?>