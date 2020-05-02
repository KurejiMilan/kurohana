<?php
include('./includefiles/header.inc.php');
    
    if(!isset($_SESSION['user'])){
        header("Location:index.php");
        exit();
    }

    //getting interests
    $sql = "SELECT * FROM interest WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $content = mysqli_fetch_assoc($result);
        $interestString = $content['interest'];
        $interestArray = array();
        $interestArray = explode('//', $interestString);

        if(in_array('art', $interestArray)){
            $artBool = true; 
        }else{
            $artBool = false;
        }
        if(in_array('FilmAnimation', $interestArray)){
            $FilmAnimationBool = true;
        }else{
            $FilmAnimationBool = false;
        }
        if(in_array('news', $interestArray)){
            $newsBool =  true; 
        }else{
            $newsBool = false;
        }
        if(in_array('design', $interestArray)){
            $designBool = true;
        }else{
            $designBool = false;
        }
        if(in_array('music', $interestArray)){
            $musicBool = true;
        }else{
            $musicBool = false;
        }
        if(in_array('entertainment', $interestArray)){
            $entertainmentBool = true;
        }else{
            $entertainmentBool = false;
        }
        if(in_array('comedy', $interestArray)){
            $comedyBool = true;
        }else{
            $comedyBool = false;
        }
        if(in_array('literature', $interestArray)){
            $literatureBool = true;
        }else{
            $literatureBool = false;
        }
        if(in_array('diy', $interestArray)){
            $diyBool = true;
        }else{
            $diyBool =false;
        }
        if(in_array('fashion', $interestArray)){
            $fashionBool = true;
        }else{
            $fashionBool = false;
        }
        if(in_array('scienceandtech', $interestArray)){
            $scienceandtechBool = true;
        }else{
            $scienceandtechBool = false;
        }
        if(in_array('education', $interestArray)){
            $educationBool = true;
        }else{
            $educationBool = false;
        }
        if(in_array('shortstories', $interestArray)){
            $shortstoriesBool = true;
        }else{
            $shortstoriesBool = false;
        }
        if(in_array('MangaAnime', $interestArray)){
            $MangaAnimeBool = true;
        }else{
            $MangaAnimeBool = false;
        }
        if(in_array('comics', $interestArray)){
            $comicsBool = true;
        }else{
            $comicsBool = false;
        }
    }
    //content creator part
    mysqli_stmt_close($stmt);
    $query = "SELECT * FROM about WHERE username  = ?";
    $stmt =mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $content = mysqli_fetch_assoc($result);

        $creatorStatus = "unchecked";
        $individualStatus = "unchecked";
        $companyStatus = "unchecked";

        $creating = "";
        $address = "";
        $contact = (string)"9800000000";
        $companyurl = "";
        $companyname = "";

        $creatorBool = (bool)$content['creator'];
        $individualBool = (bool)$content['individual'];
        $companyBool = (bool)$content['company'];
        if($creatorBool){
            $creatorStatus = "checked";
            if($individualBool){
                $creating = htmlspecialchars($content['creating']);
                $address = htmlspecialchars($content['address']);
                $contact = htmlspecialchars($content['contact']);
                $individualStatus = "checked"; 
            }else{
                $creating = htmlspecialchars($content['creating']);
                $address = htmlspecialchars($content['address']);
                $contact = htmlspecialchars($content['contact']);
                $companyname = htmlspecialchars($content['companyname']);
                $companyurl = htmlspecialchars($content['companyurl']);
                $companyStatus = "checked"; 
            }
        }    
    }
    mysqli_stmt_close($stmt);

    //fetching Social Links
    $query = "SELECT * FROM sociallinks WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $facebook = "";
        $youtube = "";
        $twitter = "";
        $instagram = "";
        if(mysqli_num_rows($result) == 1){
            $content = mysqli_fetch_assoc($result);
            $facebook = htmlspecialchars($content['facebook']);
            $youtube = htmlspecialchars($content['youtube']);
            $twitter = htmlspecialchars($content['twitter']);
            $instagram = htmlspecialchars($content['instagram']);
        }   
    }
    mysqli_stmt_close($stmt);

    //fetching Bio
    $query = "SELECT bio FROM users WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $content = mysqli_fetch_assoc($result);
        $bio = htmlspecialchars($content['bio']);
    }
    mysqli_stmt_close($stmt);

    //fetching profile picture
    $query = "SELECT profileimage FROM userprofileimg WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) == 1){
            $content = mysqli_fetch_assoc($result);
            $profileImageSrc = "./uploadprofile/".$content['profileimage'];
        }else{
            $profileImageSrc = "./assets/default_avatar.jpg";
        } 
    }

    //fetching cover picture
    $query = "SELECT coverimage FROM coverimage WHERE username = ?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $query)){
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) == 1){
            $content = mysqli_fetch_assoc($result);
            $coverImageSrc = "./coverimage/".$content['coverimage'];
        }else{
            $coverImageSrc = "./assets/cover-background.jpeg";
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/edit_profile.css">
    <title>About You</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
</head>

<body>
    <nav class="top-nav">
        <a class="nav__main-link" href="./index.php"><img src="./assets/kurohana-logo.svg" alt="Kurohana Logo"></a>
        <!-- <section class="nav__section--right">
            <button id="submit-button" class="button-filled--primary" form="about" name="about"
                type="submit">Next</button>
        </section> -->
    </nav>
    <header class="about__header">
        <img id="cover-img" src="<?php echo $coverImageSrc; ?>" alt="default cover" />
        <img id="form__profile-img" src='<?php echo $profileImageSrc; ?>' alt="avatar" />
        <!-- <input id="input__file-select" class="input__file-select" type="file"> -->
        <button id="about__cover-upload" class="button-filled--primary">Upload
            Cover</button>
    </header>
    <div class="form-page">
        <main class="form-container--about-you">
            <!--<form action="about_you.php?user=<?php $username;?>" method="POST" id="about">-->
                <div class="group-container">
                    <aside>
                        <span class="group-container__title">Something about you</span>
                        <span class="group-container__subtitle">Let your visitors know about you. Express
                            yourself</span>
                    </aside>
                    <aside>
                        <section class="field-container">
                            <label class="field__label">Bio</label>
                            <textarea id="input-bio" rows="6" class="field__input--bio"
                                placeholder="Tell everyone about yourself" name="bio"><?php echo $bio;?></textarea>
                            <p id="bio-error" class="field__error"></p>
                            <button class="button-filled--primary-short" id="bio_Button" name="about" data-validity="invalid">Saved</button>
                        </section>
                    </aside>
                </div>
                <div class="group-container">
                    <aside>
                        <span class="group-container__title">What do you want to be?</span>
                        <span class="group-container__subtitle">You can choose to be a content creator or just enjoy
                            people's content. You can always change this after.</span>
                    </aside>
                    <aside>
                        <section class="field-container">
                            <label class="checkbox">
                                <input id="content-creator-checkbox" type="checkbox" name="creator" value="creator" 
                                data-status="<?php echo $creatorStatus; ?>" />
                                <span></span>
                            </label>
                            <label class="checkbox__label">Content Creator</label>
                            <div id="creator-input" class="field-container--creator">
                                <span class="group-container__subtitle">Creators are allowed to accept support from
                                    other users. If you choose to be a creator, all these fields must be filled. Creator
                                    are also allowed to be suggested by and suggest other fellow creators.</span>
                                <label class="form-container__label">How would you want to be identified as?</label>
                                <section class="field-container">
                                    <label class="radio">
                                        <input id="individual-creator-checkbox" class="role" type="radio"
                                            name="creator_type" value="individual" 
                                            data-status="<?php echo $individualStatus; ?>" />
                                        <span></span>
                                    </label>
                                    <label class="radio__label">Individual</label>
                                </section>
                                <section class="field-container">
                                    <label class="radio">
                                        <input id="company-creator-checkbox" class="role" type="radio"
                                            name="creator_type" value="company" 
                                            data-status="<?php echo $companyStatus;  ?>" />
                                        <span></span>
                                    </label>
                                    <label class="radio__label">Company</label>
                                </section>
                                <p id="creator_type-error" class="field__error"></p>
                                <div id="company-form">
                                    <section class="field-container">
                                        <label class="field__label">Company Name</label>
                                        <input id="input-companyname" class="field__input" type="text"
                                            name="companyname" value ="<?php echo $companyname;?>" >
                                        <p id="companyname-error" class="field__error"></p>
                                    </section>
                                    <section class="field-container">
                                        <label class="field__label">Official link to website</label>
                                        <input id="input-companysite" class="field__input" type="url" 
                                            name="companyurl" value = "<?php echo $companyurl;?>" >
                                        <p id="companysite-error" class="field__error"></p>
                                    </section>
                                </div>
                                <section class="field-container">
                                    <label class="field__label">What are you creating?</label>
                                    <input id="input-creating" class="field__input" type="text"
                                        placeholder="Ex. Art, Vlogs" name="creating" value="<?php echo $creating; ?>">
                                    <p id="creating-error" class="field__error"></p>
                                </section>
                                <section class="field-container">
                                    <label class="field__label">Address</label>
                                    <input id="input-address" class="field__input" type="text" 
                                        name="address"  value="<?php  echo $address;?>" >
                                    <p id="address-error" class="field__error"></p>
                                </section>
                                <section class="field-container">
                                    <label class="field__label">Contact Info(Mobile Number)</label>
                                    <input id="input-contact" class="field__input" type="number" 
                                        name="contact_info" value="<?php echo $contact ;?>" >
                                    <p id="contact-error" class="field__error"></p>
                                </section>
                            <button class="button-filled--primary-short" id="creatingButton" name="about" data-validity = "invalid">
                                Saved</button>
                            </div>
                            <p id="checkBox-error" class="field__error">Checkbox hasn’t been checked.</p>
                            <p class="field__error"></p>
                            <p class="field__error"></p>
                            <p class="field__error"></p>
                            <p class="field__error"></p>
                        </section>
                    </aside>
                </div>
                <div class="group-container">
                    <aside>
                        <span class="group-container__title">Social Links</span>
                        <span class="group-container__subtitle">Let your visitors connect with you</span>
                    </aside>
                    <aside>
                        <section class="field-container--social">
                            <svg class="field__input-icon--left" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="black">
                                <path
                                    d="M23.9981 11.9991C23.9981 5.37216 18.626 0 11.9991 0C5.37216 0 0 5.37216 0 11.9991C0 17.9882 4.38789 22.9522 10.1242 23.8524V15.4676H7.07758V11.9991H10.1242V9.35553C10.1242 6.34826 11.9156 4.68714 14.6564 4.68714C15.9692 4.68714 17.3424 4.92149 17.3424 4.92149V7.87439H15.8294C14.3388 7.87439 13.8739 8.79933 13.8739 9.74824V11.9991H17.2018L16.6698 15.4676H13.8739V23.8524C19.6103 22.9522 23.9981 17.9882 23.9981 11.9991Z" />
                            </svg>
                            <input class="field__input--social" type="url" name="facebook" value="<?php echo $facebook;?>">
                        </section>
                        <section class="field-container--social">
                            <svg class="field__input-icon--left" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="black">
                                <path
                                    d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z" />
                            </svg>
                            <input class="field__input--social" type="url" name="youtube" value="<?php echo $youtube;?>">
                        </section>
                        <section class="field-container--social">
                            <svg class="field__input-icon--left" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="black">
                                <path
                                    d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z" />
                            </svg>
                            <input class="field__input--social" type="url" name="twitter" value="<?php echo $twitter;?>">
                        </section>
                        <section class="field-container--social">
                            <svg class="field__input-icon--left" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="black">
                                <path
                                    d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z" />
                            </svg>
                            <input class="field__input--social" type="url" name="instagram" value="<?php echo $instagram;?>">
                        </section>
                        <button class="button-filled--primary-short" id="social_links_button" name="about" data-validity = "invalid">
                            Saved</button>
                    </aside>
                    
                </div>
                <div class="group-container">
                    <aside>
                        <span class="group-container__title">Interest</span>
                        <span class="group-container__subtitle">We'll filter content based on your interests</span>
                    </aside>
                    <aside>
                        <section class="field-container">
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="art"
                                    value="art" <?php if($artBool){echo "checked";}?>>
                                <span class="topic__title">Art</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="FilmAnimation"
                                    value="FilmAnimation" <?php if($FilmAnimationBool){echo "checked";}?>>
                                <span class="topic__title">Film & Animation</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="news"
                                    value="news" <?php if($newsBool){echo "checked";}?>>
                                <span class="topic__title">News</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="design"
                                    value="design" <?php if($designBool){echo "checked";}?>>
                                <span class="topic__title">Design</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="music"
                                    value="music" <?php if($musicBool){echo "checked";}?>>
                                <span class="topic__title">Music</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="entertainment"
                                    value="entertainment" <?php if($entertainmentBool){echo "checked";}?>>
                                <span class="topic__title">Entertainment</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="comedy" 
                                    value="comedy" <?php if($comedyBool){echo "checked";}?>>
                                <span class="topic__title">Comedy</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="literature" 
                                    value="literature" <?php if($literatureBool){echo "checked";}?>>
                                <span class="topic__title">Literature</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="diy" 
                                    value="diy" <?php if($diyBool){echo "checked";}?>>
                                <span class="topic__title">DIY</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="fashion"
                                    value="fashion" <?php if($fashionBool){echo "checked";}?>>
                                <span class="topic__title">Fashion</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="scienceandtech"
                                    value="scienceandtech" <?php if($scienceandtechBool){echo "checked";}?>>
                                <span class="topic__title">Science & Technology</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="education" 
                                    value="education" <?php if($educationBool){echo "checked";}?>>
                                <span class="topic__title">Education</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="shortstories" 
                                    value="shortstories" <?php if($shortstoriesBool){echo "checked";}?>>
                                <span class="topic__title">Short stories</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="MangaAnime" 
                                    value="MangaAnime" <?php if($MangaAnimeBool){echo "checked";}?>>
                                <span class="topic__title">Manga & Anime</span>
                            </label>
                            <label class="topic">
                                <input class="topic__checkbox" type="checkbox" name="comics" 
                                    value="comics" <?php if($comicsBool){echo "checked";}?>>
                                <span class="topic__title">Comics</span>
                            </label>
                            <p class="field__error"></p>
                        </section>
                        <button class="button-filled--primary-short" id = "interestButton" data-validity="invalid" 
                            name="about">Saved</button>
                    </aside>
                </div>
            <!--</form>-->
        </main>
    </div>
    <section id="dialog-container">
        <div id="photo-upload__dialog">
            <section class="dialog__header">
                <span class="dialog__title">Upload an image</span>
                <svg onclick="hidePhotoUploadDialog()" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="#757575" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </section>
            <section class="photo-upload__body">
                <img id="photo-upload__image" src="./assets/ic_photo-preview.svg" alt="upload_photo">
                <label for="photo-upload__button-choose">
                    <input id="photo-upload__button-choose" type="file">
                    <span class="button-outlined--secondary">Choose</span>
                </label>
            </section>
        </div>
    </section>
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src="js/edit_profile.js"></script>