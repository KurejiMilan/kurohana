<?php
 include("../includefiles/header.inc.php");
 $error="";
  if(isset($_POST['forgot']))
  {
      $input=mysqli_real_escape_string($conn,@$_POST['input']);
       if(!empty($input))
	   {
	     $sql="SELECT username FROM users WHERE username="."'$input'"." OR useremail="."'$input'".";";
		 $result=mysqli_query($conn,$sql);
		  if(mysqli_num_rows($result)==1)
		  {
		    $content=mysqli_fetch_assoc($result);
			$username=$content['username'];
		    header("Location:../token_for_forgotpassword.php?user='$username'");
		    exit();
		  }
		  else
			  $error="Error with the username or email";
	   }
	   else
	   $error="This field cannot be empty";
  }
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/forms.css">
    <title>Forgot</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
</head>

<body>
	<nav class="top-nav">
        <a class="nav__main-link" href="../index.php"><img src="../assets/kurohana-logo.svg" alt="Kurohana Logo"></a>
		<section class="nav__section--right">
			<a href="../index.php#/login">
				<button class="button-text">Log In</button>
			</a>
			<a href="../signup/signup.php">
				<button class="button-text--primary">Sign Up</button>
			</a>
		</section>
    </nav>
    <div class="form-page">
        <main class="form-container">
            <h3 class="form__title">Forgot Your Password</h3>
            <h3 class="form__description">Enter your email and we'll send you a verification code</h3>
            <form action="forgot.php" method="POST" id="forgot-form">
                <section class="field-container">
                    <label id="label" class="field__label">Email</label>
                    <input id="input" class="field__input" type="email" name="input">
                    <p id="error-text" class="field__error"><?php echo $error;?></p>
                </section>             
            </form>
            <button id="confirm-button" form="forgot-form" type="submit" name="forgot" class="button-filled--primary">Confirm</button>
        </main>
    </div>
</body>

<script src="../js/forgot.js"></script>

</html>