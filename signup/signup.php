<?php
  include('../includefiles/header.inc.php'); 	   
  $name = "";
  $username = "";
  $email = "";
  $nameErr="";
  $emailErr="";
  $passwordErr="";
  $usernameErr="";  
  if(isset($_POST['signup']))
		{
			 $createbool=false;
			 $userbio='Say something about yourself';
			 $int=1;
			 $setfollow=0;
			 $d = date("Y-m-d");
		     $username=mysqli_real_escape_string($conn,@$_POST['username']);	
			 $name=mysqli_real_escape_string($conn,@$_POST['name']);
			 $email=mysqli_real_escape_string($conn,@$_POST['email']);
			 $password=mysqli_real_escape_string($conn,@$_POST['password']);
			 $passwordagain=mysqli_real_escape_string($conn,@$_POST['passwordagain']);
			   
                    if(empty($username)||empty($name)||empty($email)||empty($password)||empty($passwordagain))
					{
                         $nameErr="User must privoide all the field input";					
	                     goto down;              			
					}					
                    else
					{
						   if((!filter_var($email,FILTER_VALIDATE_EMAIL))&&(!preg_match("/^[a-zA-Z0-9_~\-]*$/",$username)))
						   {
							  $emailErr="Please enter valid email.";
							  $usernameErr="Please enter valid username.";
                               goto down;						      
						   }
						   
						   if(!filter_var($email,FILTER_VALIDATE_EMAIL))
						   {
							  $emailErr="Please enter a valid email address";
							  goto down; 
						   }
						   
						   if(!preg_match("/^[a-zA-Z0-9_~\-]*$/",$username))
						   {
							   $usernameErr="Please enter valid username.";
							   goto down;
						   }
						   
						   if((strlen($password)<8) || strlen($password>20))
						   {
							   $passwordErr="Password length has to be between 8 to 20 characters.";
							   goto down;
						   }
						   if($password!=$passwordagain)
						   {
							   $passwordErr="Passwords don’t match.";
							   goto down;
						   }
						   
						   $sql="SELECT * FROM users WHERE useremail="."'$email'".";";
						   $result=mysqli_query($conn,$sql);
						   $num=mysqli_num_rows($result);
						   if($num!=0)
						    {
							  	$sql="SELECT userid,emailvar FROM users WHERE useremail="."'$email'"."";
								$result=mysqli_query($conn,$sql);
								$content=mysqli_fetch_assoc($result);
								if($content['emailvar']==false)
								{
									 $id=$content['userid'];
									 $sql="DELETE FROM users WHERE useremail="."'$email'"." AND userid='$id';";
									 mysqli_query($conn,$sql);
									 goto newacc;	
								}
							    else
								{    
						      	$emailErr="This email is already taken.";								
								goto down;
								}		 
							}
							$sql="SELECT * FROM users WHERE username="."'$username'".";";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)!=0)
							{
								$usernameErr="This username is already taken.";
							}
		                	  else
									   {
										        newacc:
										        $str="1234567890";	
			                                    $str=str_shuffle($str);
	                                            $varcode=substr($str,0,7);	
												$hasedpassword=hash('sha256',Salt::get_presalt().$password.Salt::get_postsalt());
												$sql="INSERT INTO users (userid,name,username,useremail,userpassword,sign_up_date,varifiedbadge,badgeoverride,bio,activated,token,emailvar,followers,following) VALUES('','$name','$username','$email','$hasedpassword','$d','$createbool','$createbool','$userbio','$int','$varcode','$createbool','$setfollow','$setfollow')";
												mysqli_query($conn,$sql);
												$_SESSION["user"]=$username; 													
												header("Location:../emailvar.inc.php?user=$username");
												exit();									
									   }										  				         													   						 
					}		
		}	
		down:
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/forms.css">
    <title>Sign Up | Kurohana</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
</head>

<body>
	<nav class="top-nav">
        <a class="nav__main-link" href="../index.php"><img src="../assets/kurohana-logo.svg" alt="Kurohana Logo"></a>
		<section class="nav__section--right">
			<h3 class="nav__text">Already have an account?</h3>
			<a href="../index.php#/login">
				<button class="button-text--primary">Log In</button>
			</a>
		</section>
    </nav>
    <div class="form-page">
        <main class="form-container">
            <h3 class="form__title">Sign Up</h3>
            <h3 class="form__description">Join the community<br>and share your talents <br> absolutely free</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="signup">
                <section class="field-container">
                    <label class="field__label">Full Name</label>
                    <?php echo ("<input id='signup-name' class='field__input' type='text' name='name' value='$name'>");?>
                    <p id="name-error" class="field__error"><?php if($nameErr!="")echo $nameErr; ?></p>
                </section>
                <section class="field-container">
                    <label class="field__label">Email</label>
                    <?php echo ("<input id='signup-email' class='field__input' type='email' name='email' value='$email'>");?>
                    <p id="email-error" class="field__error"><?php if($emailErr!="") echo $emailErr;?></p>
                </section>
                <section class="field-container">
                    <label class="field__label" >Username</label>
                    <div style="position:relative;">
                    	<?php echo ("<input id='signup-username' class='field__input--username' type='text' name='username' value='$username'>");?>						
						<svg class="field__input-icon--left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
							<path fill-opacity=".9" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10h5v-2h-5c-4.34 0-8-3.66-8-8s3.66-8 8-8 8 3.66 8 8v1.43c0 .79-.71 1.57-1.5 1.57s-1.5-.78-1.5-1.57V12c0-2.76-2.24-5-5-5s-5 2.24-5 5 2.24 5 5 5c1.38 0 2.64-.56 3.54-1.47.65.89 1.77 1.47 2.96 1.47 1.97 0 3.5-1.6 3.5-3.57V12c0-5.52-4.48-10-10-10zm0 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
						</svg>
					</div>
					<p id="username-error" class="field__error"><?php if($usernameErr!="") echo $usernameErr;?></p>
                </section>
                <section class="field-container">
                    <label class="field__label" >Password &bull; Between 8 - 20 characters</label>
					<div style="position:relative;">
                    	<input id="signup-password" class="field__input--password" type="password" name="password">
						<svg id="signup-password-toggle" class="field__input-icon--right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#212121">
							<path d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z"/>
						</svg>
					</div>
                    <p id="password-error" class="field__error"><?php if($passwordErr!="") echo $passwordErr;?></p>
                </section>
                <section class="field-container">
                    <label class="field__label" >Confirm Password</label>
					<div style="position:relative;">
						<input id="signup-confirmPassword" class="field__input--password" type="password" name="passwordagain">
						<svg id="signup-confirmPassword-toggle" class="field__input-icon--right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#212121">
							<path d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z"/>
						</svg>
					</div>
                    <p id="confirmPassword-error" class="field__error"><?php if($passwordErr!="") echo $passwordErr;?></p>     
				</section>
                <section class="field-container">
                    <label class="checkbox">
                        <input id="terms-checkbox" name="check" type="checkbox" />
                        <span></span>
                    </label>
                    <label class="checkbox__label">I hereby agree with the <a href="../terms_and_conditions.php" class="link">Terms of Use</a></label>
                </section>
				<p id="checkBox-error" class="field__error"></p>
            </form>
			<button form="signup" id="signup-button" type="submit"  name="signup" class="button-filled--primary">Create Account</button>
        </main>
    </div>
</body>

<script src="../js/signup.js"></script>
</html>