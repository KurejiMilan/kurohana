<?php
include("includefiles/header.inc.php");
if(!isset($_SESSION['user'])){
    header("Location:index.php");
    exit();
}
$backPage = $_GET['backPage'];
$name = "";
$useremail = "";
$sql = "SELECT name, useremail FROM users WHERE username = ?";
$stmt = mysqli_stmt_init($conn);
if(mysqli_stmt_prepare($stmt, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);    
    if(mysqli_num_rows($result) == 1){
        $content = mysqli_fetch_assoc($result);
        $name = $content['name'];
        $useremail = $content['useremail'];
    }
    mysqli_stmt_close($stmt);
}
$creatorBool = false;
$creator = "false";
$sql = "SELECT creator, address, contact FROM about WHERE username = ?";
$stmt = mysqli_stmt_init($conn);
if(mysqli_stmt_prepare($stmt, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) == 1){
        $content = mysqli_fetch_assoc($result);
        if(boolval($content['creator']) == true){
            $creatorBool = true;
            $creator = "true";
            $address = htmlspecialchars($content['address']);
            $contact = htmlspecialchars($content['contact']);
        }
    }
}mysqli_stmt_close($stmt);

$sql = "SELECT likes, comments FROM settings WHERE username = ?";
$stmt = mysqli_stmt_init($conn);
if(mysqli_stmt_prepare($stmt, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($result) == 1){
        $content = mysqli_fetch_assoc($result);
        $likes = (bool)$content['likes'];
        $comments = (bool)$content['comments']; 
    }
    mysqli_stmt_close($stmt);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/settings.css">
    <link rel="stylesheet" href="./css/forms.css">
    <title>Settings | Kurohana</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
</head>

<body>
    <nav class="top-nav">
        <section class="nav__section--left">
            <button class="button-icon" id="backButton" data-backPage = "<?php echo $backPage;?>" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </button>
        </section>
        <span class="nav__section--center">Settings</span>
    </nav>
    <main class="help__main">
        <aside id="help__tabs">
            <article class="tab-item selected-tab" onclick="openGeneralSettings(this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tab-item__icon">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path
                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                    </path>
                </svg>
                <span class="tab-item__title">General Settings</span>
            </article>
            <article class="tab-item" onclick="openSecuritySettings(this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tab-item__icon">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z">

                    </path>
                </svg>
                <span class="tab-item__title">Security and Login</span>
            </article>
            <article class="tab-item" onclick="openNotificationSettings(this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tab-item__icon">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span class="tab-item__title">Notification</span>
            </article>
        </aside>
        <section id="settings__page">
            <article class="settings-form-container" id="general-page">
                <h3 class="form__title">General Settings</h3>
                <form>
                    <section class="field-container">
                        <label class="field__label">Full Name</label>
                        <input id='input-name' class='field__input' type='text' name='name' value='<?php echo $name;?>'>
                        <p id="name-error" class="field__error"></p>
                    </section>
                    <section class="field-container">
                        <label class="field__label">Email</label>
                        <input id='input-email' class='field__input' type='email' name='email' value='<?php echo $useremail;?>'>
                        <p id="email-error" class="field__error"></p>
                    </section>
                    <?php
                        if($creatorBool){
                            echo '
                                <section class="field-container">
                                <label class="field__label">Contact No.</label>
                                <input id="input-contact" class="field__input" type="tel" name="contact" value="'.$contact.'"">
                                <p id="email-error" class="field__error"></p>
                                </section>
                                <section class="field-container">
                                <label class="field__label">Address</label>
                                <input id="input-address" class="field__input" type="text" name="address" value="'.$address.'">
                                <p id="email-error" class="field__error"></p>
                                </section>
                            ';
                        }
                    ?>
                </form>
			    <button class="button-filled--primary" id="generalSettings" data-creator="<?php echo $creator;?>"
                    data-validity="invalid">Saved</button>
            </article>
            <article class="settings-form-container" id="security-page">
                <h3 class="form__title">Security and Login</h3>
                <section class="field-container">
                    <label class="field__label">Password</label><br>
                    <button class="button-outlined--neutral" onclick="openPasswordForm()">Change Password</button>
                </section>
                <form id="security-page__form">
                    <section class="field-container">
                        <label class="field__label">Old Password</label>
                        <div style="position:relative;">
                            <input id="input-oldpassword" class="field__input--password" type="password"
                                name="oldpassword">
                            <svg id="signup-password-toggle" class="field__input-icon--right"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="#212121">
                                <path
                                    d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z" />
                            </svg>
                        </div>
                        <p id="email-error" class="field__error"></p>
                    </section>
                    <section class="field-container">
                        <label class="field__label">New Password</label>
                        <div style="position:relative;">
                            <input id="input-newpassword" class="field__input--password" type="password"
                                name="newpassword">
                            <svg id="signup-password-toggle" class="field__input-icon--right"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="#212121">
                                <path
                                    d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z" />
                            </svg>
                        </div>
                        <p id="email-error" class="field__error"></p>
                    </section>
                    <section class="field-container">
                        <label class="field__label">Confirm Password</label>
                        <div style="position:relative;">
                            <input id="input-confirmpassword" class="field__input--password" type="password"
                                name="confirmpassword">
                            <svg id="signup-password-toggle" class="field__input-icon--right"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="#212121">
                                <path
                                    d="M12 6c3.79 0 7.17 2.13 8.82 5.5C19.17 14.87 15.79 17 12 17s-7.17-2.13-8.82-5.5C4.83 8.13 8.21 6 12 6m0-2C7 4 2.73 7.11 1 11.5 2.73 15.89 7 19 12 19s9.27-3.11 11-7.5C21.27 7.11 17 4 12 4zm0 5c1.38 0 2.5 1.12 2.5 2.5S13.38 14 12 14s-2.5-1.12-2.5-2.5S10.62 9 12 9m0-2c-2.48 0-4.5 2.02-4.5 4.5S9.52 16 12 16s4.5-2.02 4.5-4.5S14.48 7 12 7z" />
                            </svg>
                        </div>
                        <p id="email-error" class="field__error"></p>
                    </section>
                </form>
                <button class="button-filled--primary" id="confirmPasswordButton">Confirm</button>
            </article>
            <article class="settings-form-container" id="notification-page">
                <h3 class="form__title">Notification</h3>
                <form>
                    <section class="field-container--toggle">
                        <label class="toggle__label">Likes Notifications</label>
                        <label class="toggle">
                            <input type="checkbox" name="likes" value="likes" <?php if($comments){echo "checked";}?> />
                            <span></span>
                        </label>
                    </section>
                    <section class="field-container--toggle">
                        <label class="toggle__label">Comments Notifications</label>
                        <label class="toggle">
                            <input type="checkbox" name="comments" value="comments" <?php if($comments){echo "checked";}?> />
                            <span></span>
                        </label>
                    </section>
                </form>
            </article>
        </section>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="./js/settings.js"></script>

</html>