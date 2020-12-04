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
            <form method="POST" id="signup">
                <section class="field-container">
                    <label class="field__label">Full Name</label>
                    <input id='signup-name' class='field__input' type='text' name='name' value=''>
                    <p id="name-error" class="field__error"></p>
                </section>
                <section class="field-container">
                    <label class="field__label">Email</label>
                    <input id='signup-email' class='field__input' type='email' name='email' value=''>
                    <p id="email-error" class="field__error"></p>
                </section>
                <section class="field-container">
                    <label class="field__label" >Username</label>
                    <div style="position:relative;">
                      <input id='signup-username' class='field__input--username' type='text' name='username' value=''>
						              <svg class="field__input-icon--left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
							                     <path fill-opacity=".9" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10h5v-2h-5c-4.34 0-8-3.66-8-8s3.66-8 8-8 8 3.66 8 8v1.43c0 .79-.71 1.57-1.5 1.57s-1.5-.78-1.5-1.57V12c0-2.76-2.24-5-5-5s-5 2.24-5 5 2.24 5 5 5c1.38 0 2.64-.56 3.54-1.47.65.89 1.77 1.47 2.96 1.47 1.97 0 3.5-1.6 3.5-3.57V12c0-5.52-4.48-10-10-10zm0 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
						              </svg>
					          </div>
					          <p id="username-error" class="field__error"></p>
                </section>
                <section class="field-container">
                    <label class="field__label" >Password &bull; Between 8 - 20 characters</label>
            					<div style="position:relative;">
                                	<input id="signup-password" class="field__input--password" type="password" name="password">
            						<svg id="signup-password-toggle" class="field__input-icon--right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#212121">
            							<path d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z"/>
            						</svg>
            					</div>
                    <p id="password-error" class="field__error"></p>
                </section>
                <section class="field-container">
                    <label class="field__label" >Confirm Password</label>
            					<div style="position:relative;">
            						<input id="signup-confirmPassword" class="field__input--password" type="password" name="passwordagain">
            						<svg id="signup-confirmPassword-toggle" class="field__input-icon--right" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#212121">
            							<path d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z"/>
            						</svg>
            					</div>
                    <p id="confirmPassword-error" class="field__error"></p>
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
			      <button id="signup-button" type="submit"  name="signup" class="button-filled--primary">Create Account</button>
        </main>
    </div>
</body>
<script src="../js/signup.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</html>
