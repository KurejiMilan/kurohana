<!DOCTYPE html>
<?php
	include('./includefiles/header.inc.php');
	$email = "";
	$emailErr = "";
	$passwordErr = "";

   
	if(isset($_COOKIE['logid'])){
            $hashedtoken=hash('sha256', $_COOKIE['logid']);
	  		$result=mysqli_query($conn,"SELECT userid FROM token WHERE logid="."'$hashedtoken'".";") or die("Server Error!");
             if (mysqli_num_rows($result)>0) {
                                $content=mysqli_fetch_assoc($result);
                                $userid = $content['userid'];
                                if (isset($_COOKIE['logid_'])) {
                                           $result=mysqli_query($conn,"SELECT username FROM users WHERE userid=$userid");
        	                               $content=mysqli_fetch_assoc($result);
        	                               $username=$content['username'];
        	                               $_SESSION["user"]=$username;
        	                               header("Location:profile.php?user=$username"); 
			                               exit();
                                } else {
                                        $cstrong = True;
                                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                        $newhashedtoken=hash('sha256',$token);
                                        mysqli_query($conn,"INSERT INTO token (id,logid,userid) VALUES('','$newhashedtoken','$userid')") or die("ERROR 204!");
                                        mysqli_query($conn,"DELETE FROM token WHERE logid="."'$hashedtoken'".";") or die("ERROR 204!");
                                        setcookie("logid", $token, time() + 60 * 60 * 24 * 30, '/', NULL, NULL, TRUE);
                                        setcookie("logid_", '1', time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                                           $result=mysqli_query($conn,"SELECT username FROM users WHERE userid=$userid");
        	                               $content=mysqli_fetch_assoc($result);
        	                               $username=$content['username'];
        	                               $_SESSION["user"]=$username;
        	                               header("Location:profile.php?user=$username"); 
			                               exit();
                                }
	  		}	  		
	  	}
	  	
    if(isset($_POST['login']))
	{
		 $password = mysqli_real_escape_string($conn,@$_POST['password']);
		 $email = mysqli_real_escape_string($conn,@$_POST['email']);
		 
		 if(empty($email)&&empty($password))
		 {
            $passwordErr="This field can not be empty";			
			$emailErr="This field can not be empty";
		    goto down;
		 }
		 
		 if(empty($email))
	   	  {
			$emailErr="This field can not be empty";
			  goto down;
		  }
		 if(empty($password))
		 {
			 $passwordErr="This field can not be empty";
			 goto down;
		 }
		 if((!filter_var($email,FILTER_VALIDATE_EMAIL)))
		  {
		     $emailErr="Enter valid email address.";	
             goto down;
    	  }
		   
		 else
		 {	 
		   $hashedpassword=hash('sha256',Salt::get_presalt().$password.Salt::get_postsalt());		 
	       $query="SELECT * FROM users WHERE useremail=? AND userpassword=?";	
           $stmt=mysqli_stmt_init($conn);
           if(!mysqli_stmt_prepare($stmt,$query))
		   {
			   
		   }
            else
			{
				mysqli_stmt_bind_param($stmt,"ss",$email,$hashedpassword);
				mysqli_stmt_execute($stmt);
				$result=mysqli_stmt_get_result($stmt);
				$num=mysqli_num_rows($result);
			      if($num!=1)
				  {
					      $emailErr="Invalid email or password";
			              $passwordErr="Invalid email or password";
						  
						  goto down;
				  }
				  else
				  {
					  while($content=mysqli_fetch_assoc($result))
					  {
						  $username=$content['username'];
						  $userid=$content['userid'];
						  $_SESSION["user"]=$username;
						  $activated=$content['activated'];
						  $emailvar=$content['emailvar'];
						  if($emailvar==false)
						  {
							  header("Location:emailvar.inc.php?user=$username");
							  exit();
						  }
						  else if($activated==false) 
						  { 
					         header("Location:reactivate.php?user=$username"); 
							 exit();  
						  }	
                          else
						  {
						     $cstrong = True;
                             $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                             $hashedtoken=hash('sha256',$token);
                             mysqli_query($conn,"INSERT INTO token (id,logid,userid) VALUES('','$hashedtoken','$userid')") or die("ERROR 204!");              
                             setcookie("logid", $token, time() + 60 * 60 * 24 * 30, '/', NULL, NULL, TRUE);
                             setcookie("logid_", '1', time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE); 
							 header("Location:profile.php?user=$username"); 
						     exit();
						  }							  
					  }
				  }
					  
			}
		 }			
	}
 down:
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/index.css">
	<title>Home | Kurohana</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
</head>

<body>
	<nav class="top-nav">
		<a class="nav__main-link" href="./index.php"><img src="./assets/kurohana-logo.svg" alt="Kurohana Logo"><span>Kurohana</span></a>
		<section id="nav__home-buttons" class="nav__section--right">
			<a href="#/login">
				<button class="button-text">Log In</button>
			</a>
			<a href="./signup/signup.php">
				<button class="button-text--primary">Sign Up</button>
			</a>
		</section>
		<section id="nav__login-buttons" class="nav__section--right">
			<h3 class="nav__text">Don't have an account?</h3>
			<a href="./signup/signup.php">
				<button class="button-text--primary">Get Started</button>
			</a>
		</section>
    </nav>
    <div id="login-page" class="form-page">
        <main class="form-container">
            <h3 class="form__title">Log In</h3>
            <h3 class="form__description">Welcome back!</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>#/login" method="POST" id="login">
                <section class="field-container">
                    <label class="field__label" >Email</label>
					<?php echo("<input id='login-email' name='email' class='field__input' type='email' value='$email'></input>");?>
                    <p id="email-error" class="field__error"><?php if($emailErr!="") echo $emailErr;?></p>
                </section>
                <section class="field-container">
					<label class="field__label">Password</label>
					<div style="position:relative;">
						<input id="login-password" name="password" class="field__input--password" type="password"></input>
						<svg id="login-password-toggle" class="field__input-icon--right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#212121">
							<path d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z"/>
						</svg>
					</div>
                    <p id="password-error" class="field__error"><?php if($passwordErr!="") echo $passwordErr;?></p>
                </section>
            </form>
			<button id="login-button" form="login" type="submit" name="login" class="button-filled--primary">Log In</button>
            <div class="link-group">
                <a href="./forgot/forgot.php" class="link">Forgot Password?</a>
            </div>
        </main>
	</div>
	<section id="home-page">
		<h1 class="home__heading">Welcome to Kurohana</h1>
		<h4 class="home__subheading">Platform to showcase your skills</h4>
	</section>
</body>

<script src="js/login.js"></script>

</html>