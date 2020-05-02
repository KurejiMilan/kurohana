<?php
 include ("./includefiles/header.inc.php");
  $passwordErr="";
   if(isset($_POST['deactivate-button']))
   {
	   $password=mysqli_real_escape_string($conn,$_POST['password']);
	   if(empty($password))
	   {
		   $passwordErr="This field cannot be empty";
	   }
	   else
	   {
		   $false=false;
		   $username=$user;
		   $hasedpassword=hash('sha256',Salt::get_presalt().$password.Salt::get_postsalt());
		   $sql="SELECT userid FROM users WHERE username="."'$username'"." AND activated='$false';";
		   $result=mysqli_query($conn,$sql);
		    if(mysqli_num_rows($result)==1)
			{
				$content=mysqli_fetch_assoc($result);
				$id=$content['userid'];
				$true=true;
				$sql="UPDATE users SET activated='$true' WHERE userid='$id';";
				mysqli_query($conn,$sql);
				header("Location:profile.php?user=$username");
				exit();
			}
			else
				$passwordErr="Opps!something went wrong please try again";
	   }
   }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/forms.css">
    <title>Reactivate Account</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
</head>

<body>
    <nav class="top-nav">
        <a class="nav__main-link" href="./index.php"><img src="./assets/kurohana-logo.svg" alt="Kurohana Logo"></a>
    </nav>
    <div class="form-page">
        <main class="form-container">
            <h3 class="form__title">Your account was deactivated</h3>
            <h3 class="form__description">Want to reactivate?</h3>
            <form action="reactivate.php" method="POST" id="confirm-button">
                <section class="field-container">
                    <label class="field__label">Password</label>
                    <div style="position:relative;">
                        <input id="reactivate-password" class="field__input--password" type="password" name="password">
						<svg id="reactivate-password-toggle" class="field__input-icon--right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#212121">
							<path d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z"/>
						</svg>
					</div>
                    <p id="error-text" class="field__error"><?php echo $passwordErr;?></p>
                </section>              
            </form>
			<button id="reactivate-button" form="confirm-button" type="submit" name="deactivate-button" class="button-filled--primary">Reactivate</button>
        </main>
    </div>
</body>

<script src="./js/reactivate.js"></script>

</html>