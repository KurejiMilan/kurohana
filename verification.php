<?php
include("includefiles/header.inc.php");
$error="";

  if(isset($_POST['verify']))
  {
     $varcode=$_POST['varcode'];
	  if(empty($varcode))
	  {
		  $error="This field cannot be empty";
	  }
	  else
	  {
		  $username=$user;
		
		  $sql="SELECT token FROM users WHERE username="."'$username'".";";
		  $result=mysqli_query($conn,$sql);
		   if(mysqli_num_rows($result)==1)
		   {
			   $content=mysqli_fetch_assoc($result);
			   $token=$content['token'];
			   if($token==$varcode)
			   {
				   $emailvar=true;
				   $sql="UPDATE users SET emailvar='$emailvar' WHERE username="."'$username'".";";
				   mysqli_query($conn,$sql);
				   header("Location:about_you.php?user=$username");
				   exit();
			   }
			   else
			   {$error="Invalid verification code";
			   }
		   }
		   else
		   {
			   echo "There seems to be an error";
		   }
	  }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forms.css">
    <title>Verification</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
</head>

<body>
    <nav class="nav-container top-nav">
        <a href="#" class="nav__main-link">Kakumei Logo</a>
    </nav>
    <div  class="form-page" >
        <main class="form-container">
            <h3 class="form__title">Your account has been created</h3>
            <h3 class="form__description">A verification code has been sent to your email.</h3>
            <form action="verification.php" id="verify" method="POST">
                <section class="field-container">
                    <label class="field__label" >Enter the code</label>
                    <input class="field__input" type="number" name="varcode">
                    </input>
                    <p class="field__error"><?php echo $error;?></p>
                </section>
            </form>
			<button form="verify" class="form__button" name="verify" type="submit">Verify</button>
            <div class="link-group">
                <a href="resend.php" class="link">Resend Verification Code</a>
            </div>
        </main>
    </div>
</body>

</html>