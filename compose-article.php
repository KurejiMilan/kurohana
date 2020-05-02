<?php

include('./includefiles/header.inc.php');
if (!isset($_SESSION['user'])) {
    header("Location:index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Compose | Kurohana</title>
    <link rel="stylesheet" href="./assets/simpleMDE/simplemde.min.css">
    <link rel="stylesheet" href="./css/compose.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,700,700i" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="top-nav">
            <a class="nav__main-link" href="home.php"><img src="./assets/kurohana-logo.svg" alt="Kurohana Logo"></a>
            <button class="button-outlined" onclick="openTagDialog()">Select Tag</button>
        </div>
    </nav>
    <main>
        <div id="progress-bar--primary">
            <span></span>
        </div>
        <section class="compose__input-container">
            <textarea id="compose__input-title" type="text" placeholder="Pick a suitable title" rows="2"></textarea>
            <textarea id="compose__input-subtitle" type="text" placeholder="Optional subtitle" rows="2"></textarea>
            <img id="compose__input-cover-preview" src="./assets/cover-placeholder.svg" alt="">
            <textarea id="compose__input-body"></textarea>
        </section>
    </main>
    <aside id="secondary-container" style="background: white;">
        <div id="tag-container" style="display: none;">
            <section class="tag-container__header">
                <div> 
                    <Span class="tag-group-title">Choose your Audience</Span>
                    <select name="audience" class="dropdown">
                        <option value="public">Everyone</option>
                        <option value="supporters">Supporters</option>
                    </select>
                </div>
                <div>
                    <Span class="tag-group-title">Select a Tag</Span>
                    <button id="btn-publish" class="button-outlined--icon-right">
                        <span>Post</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
            </section>
            <section class="tag-group">
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Art">
                    <span>
                        Art
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="FilmAnimation">
                    <span>
                        Film and Animation
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="News">
                    <span>
                        News
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Design">
                    <span>
                        Design
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Music">
                    <span>
                        Music
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Entertainment">
                    <span>
                        Entertainment
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Comedy">
                    <span>
                        Comedy
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Literature">
                    <span>
                        Literature
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Diy">
                    <span>
                        Diy
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Fashion">
                    <span>
                        Fashion
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="ScienceandTech">
                    <span>
                        Science and Technology
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Education">
                    <span>
                        Education
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Shortstories">
                    <span>
                        Short stories
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="MangaAnime">
                    <span>
                        Manga and Anime
                    </span>
                </label>
                <label class="radio-tag">
                    <input type="radio" name="tag" value="Comics">
                    <span>
                        Comics
                    </span>
                </label>
            </section>
        </div>
    </aside>
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

<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="./assets/simpleMDE/simplemde.min.js"></script>
<script src="./js/compose-article.js"></script>

</html>