<?php
include("includefiles/header.inc.php");
if(!isset($_SESSION['user'])) {
    header("Location:index.php");
    exit();
}

$sql = "SELECT creator FROM about WHERE creator = 1;";
$query = mysqli_query($conn, $sql);
if(mysqli_num_rows($query) < 3){
    header("Location:profile.php?user=$user");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/suggestions.css">
    <title>Suggestions | Kurohana</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
</head>

<body>
    <nav class="top-nav">
        <a class="nav__main-link" href="./index.php"><img src="./assets/kurohana-logo.svg" alt="Kurohana Logo"></a>
        <section class="nav__section--right">
            <button class="button-filled--primary" form="about" name="about" type="submit" data-username = "<?php echo $user;?>" id="skip">Skip</button>
        </section>
    </nav>
    <div class="form-page">
        <main class="form-container--wide">
            <h3 class="form__title">Get Started</h3>
            <h3 class="form__description">Here are some creators you might like</h3>
            <section id="suggestions-container">
            </section>
            <button class="button-text" id="btn-load-more">Load More</button>
        </main>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
<script src="./js/suggestions.js"></script>

</html>