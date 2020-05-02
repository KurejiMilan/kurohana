<?php
require('./includefiles/header.inc.php');
if(!isset($_SESSION['user'])) {
    header("Location:index.php");
    exit();
}
if(!isset($_GET['action'])&&!isset($_GET['backPage'])&&!isset($_GET['postid'])){
    header("Location:index.php");
    exit();
}else{
    $action = htmlspecialchars($_GET['action']);
    $backPage = htmlspecialchars($_GET['backPage']);
    $postid = htmlspecialchars($_GET['postid']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/help.css">
    <link rel="stylesheet" href="./css/forms.css">
    <title>Help | Kurohana</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
</head>

<body>
    <nav class="top-nav">
        <section class="nav__section--left">
            <button class="button-icon backbutton" data-backpage="<?php echo $backPage;?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </button>
        </section>
        <span class="nav__section--center" data-action="<?php echo $action;?>" data-postid="<?php echo $postid?>">Help</span>
    </nav>
    <main class="help__main">
        <aside id="help__tabs">
            <article class="tab-item selected-tab" onclick="openFAQPage(this)">
                <span class="tab-item__title">FAQ</span>
            </article>
            <article class="tab-item" onclick="openSupportPage(this)">
                <span class="tab-item__title">Contact Support</span>
            </article>
            <article class="tab-item" onclick="openReportPage(this)">
                <span class="tab-item__title">Report a Problem</span>
            </article>
            <article class="tab-item" onclick="openTermsPage(this)">
                <span class="tab-item__title">Terms and Policies</span>
            </article>
            <article class="tab-item" onclick="openComplainPage(this)">
                <span class="tab-item__title">File a Complain</span>
            </article>
        </aside>
        <section id="settings__page">
            <article class="form-container" id="faq-page">
                <h3 class="form__title">FAQ</h3>
            </article>
            <article class="form-container" id="complain-page">
                <h3 class="form__title">File a Complain</h3>
                <section id="complain-page-container">

                    <form>
                        <section class="field-container">
                            <label class="field__label">Username or user post link</label>
                            <input id='input-name' class='field__input' type='text' name='subject' value="<?php 
                            if($postid != "none"){echo "www.kurohana.com/post.php?id=".$postid;}else{echo "";}?>">
                        </section>
                        <span class="form__tip">The username or link of user post or profile will be used to evaluate
                            your
                            complain</span>
                        <section class="field-container">
                            <label class="field__label">Your complain</label>
                            <section class="field-container">
                                <label class="radio">
                                    <input id="radio-steal" type="radio" name="complain-type" value="stealing" />
                                    <span></span>
                                </label>
                                <label class="radio__label">Stealing other people's content or mine (If it's your
                                    original
                                    work, copyright claim their post)</label>
                            </section>
                            <section class="field-container">
                                <label class="radio">
                                    <input id="radio-offensive" type="radio" name="complain-type" value="offensive" />
                                    <span></span>
                                </label>
                                <label class="radio__label">Using offensive and vulgar language to hurt other
                                    users</label>
                            </section>
                            <section class="field-container">
                                <label class="radio">
                                    <input id="radio-impersonation" type="radio" name="complain-type"
                                        value="impersonating" />
                                    <span></span>
                                </label>
                                <label class="radio__label">Impersonating someone I know or me (Link of the original
                                    person)</label>
                            </section>
                            <section class="field-container">
                                <label class="radio">
                                    <input id="radio-illegal" type="radio" name="complain-type" value="illegal" />
                                    <span></span>
                                </label>
                                <label class="radio__label">Doing illegal activities (Specify)</label>
                            </section>
                            <section class="field-container">
                                <label class="radio">
                                    <input id="radio-underage" type="radio" name="complain-type" value="underage" />
                                    <span></span>
                                </label>
                                <label class="radio__label">User is under 13 years of age</label>
                            </section>
                            <section class="field-container">
                                <label class="radio">
                                    <input id="radio-other" type="radio" name="complain-type" value="other" />
                                    <span></span>
                                </label>
                                <label class="radio__label">Other reasons (Specify)</label>
                            </section>
                            <section id="report-additional_details" class="field-container">
                                <label class="field__label">Additional Details</label>
                                <textarea rows="6" class="field__input--large complain-details"></textarea>
                            </section>
                        </section>
                    </form>
                    <button class="button-filled" onclick="sendComplain(this)">Send Complain</button>
                </section>
                <aside id="complain__success-page">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none"
                        stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-check">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg><br>
                    Thank you for your complain! The complain will be evaluated and necessary actions will be taken.
                </aside>
            </article>
            <article class="form-container" id="terms-page">
                <h3 class="form__title">Terms and Policies</h3>
                <div>
                    <br>
                    <div class="row container-fluid">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <h1>Terms And Condition</h1>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <br>
                    <div><img src="./photos/legal-terms.jpg" class="mx-auto d-block"></div>
                    <br>
                    <div class="jumbotron">
                        <h1 style="text-align:center;">PLease read all the terms and condition</h1>
                        <p>PLease read all the terms and conditions before making a account.The terms and conditions are
                            written in simplest
                            way possible and keept as short as possible.
                            There are some community guideliness and condition which you must follow.In case if any of
                            the guideliness and
                            conditions are broken we(we refering the company)
                            will take <b>necessary action</b>.<br>These guideliness and conditions are for the benifits
                            of the users.</p>
                    </div>
                    <div class="row container-fluid">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8" style="border:1px solid black;">
                            <h2>Basic community guideliness</h2>
                            <p><b>1.</b>Do not use any kind of <b>bad language</b> thay may offend or hurt other.If any
                                kind of offensive word
                                are used report to us.</p>
                            <P><b>2.</b>Do not <b>steal</b> other people content or let other people use your content
                                without your consent.
                            </p>
                            <P><b>3.</b>Do not use <b>other people Username and impersonate</b>("pretend to be someone
                                else") other people.If
                                any kind of these activity are noticed report it to us.</p>
                            <p><b>4.</b>Do not allow other people to use your account or provide <b>detail</b> of your
                                account to other.</p>
                            <p><b>5.</b>Do not share your earnings,earned from the donation/support of the viewers, with
                                other creator unless
                                you have worked together.</p>
                            <p><b>6.</b>Do not start a <b>fight</b> with other creator or user.</p>
                            <p><b>7.</b>Do not <b>interfare</b> with the public life of the creators.</p>
                            <p><b>8.</b>Do not <b>spam</b> other.</p>
                            <p><b>9.</b>You are not allowed to post or share anything that involves <b>adult content or
                                    nudity</b> that may
                                make other uncomfortable or may affect thier social life.
                                Unless it is for the content you are creating which should not portray real people.</p>
                            <p><b>10.</b>We encourage you to <b>support creators</b> so they can make creative content
                                for living.</p>
                            <p><b>11.</b>Do not provide <b>wrong and missleading</b> information.</p>
                            <p><b>12.No bullying and hate speech</b>.You are not allowed to bully other users and
                                creators,we do not support
                                this kind of activity.If you find these kind of
                                activity report it to us so we will take action immediately.
                            </p>
                            <p><b>13.No illeagal</b> stuff.</p>
                            <p><b>14.No frauds</b></p>
                            <br>
                            <div class="jumbotron">
                                <h3>The community guideliness is fairly simple and understandable.</h3>
                                <p>Do not do bad stuff and you will be fine.Don't be stupid be <b>responsible</b>.</p>
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <br>
                    <p style="margin: 2px 55px 2px 55px; padding:4px 2px 2px 4px;"><b>These are the basic community
                            guideliness that we
                            are imposing for the benifits for all our users.But there may be updates in the future to
                            these guideliness
                            .If any kinds of updates are made we will inform you.These guideliness can be easily meet by
                            just using common
                            sense so we do not expect any guideliness to be
                            broken.
                        </b></p><br><br>
                    <div class="row container-fluid">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2"><img src="./photos/sadbird.jpg" style="height:250px;width:250px;"></div>
                        <div class="col-sm-8">
                            <div class="jumbotron">
                                <h4 style="text-align:center;">About creating account</h4>
                                <p>As much as we support all types of creators and every kind of creative content,but
                                    sadly you must be at least
                                    13 years of age to make a account.
                                    And you must be at least 18 years old so that you can use the donation service.
                                </p>
                            </div>
                        </div>
                    </div>
                    <p style="margin:5px 55px 5px 55px;">If anyone who is under 13 with a account report it to us.You
                        can not use the
                        donation services from the
                        supporters unless you at 18 years of age or you must be have your parent concent to use this
                        service.
                    </p><br><br>
                    <div class="row container-fluid">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8" style="border:1px solid black">
                            <div class="jumbotron" style="height:25px; margin-top:25px;">
                                <h4 style="text-align:center;">Who is a Creator?</h4>
                            </div>
                            <p style="padding:25px;"><b>Creators</b> are the ones who creates content and uploads it so
                                the viewers can enjoy
                                it.How can you be a creator?
                                You just have to upload your own <b>original content</b> and that's it.It's very easy to
                                be creator as long as
                                the content belongs to you. We take 5% of
                                what the creators makes from the support/donation of the viewers.This is so that we can
                                run the company and make
                                the services great in coming future.
                                It's completely upto the creator for making a earning from the website.We just provide
                                the platfrom but we won't
                                help more than that to make a living.
                                The creator are provided the money from their supporters at the end of the month,but
                                sometimes there might be
                                delay in the process.<br>
                                We will suggest every creator to ther viewers regardless of who they are and depending
                                on what the viewer is
                                interested in.
                            </p>
                            <div class="jumbotron" style="height:25px; margin-top:25px;">
                                <h4 style="text-align:center;">Who is a viewer?</h4>
                            </div>
                            <p style="padding:25px;"><b>Viewers</b> are the one who enjoys the original content of a
                                creator,a <b>creator</b>
                                is also a viewer if he/she enjoys other
                                creator content.So basically all the users of the website is a viewer.Viewers can
                                support their favourate
                                creators by donating.We encourage viewers to
                                support the creators so that they can make a living from doing what they love.But we do
                                not encourage a large
                                trasnsaction to be donated.
                            </p>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <br><br>
                    <h4 style="text-align:center;">Important Stuff</h4>
                    <br>
                    <p style="text-align:center;"><b>You are not allowed use the site logo and other copyright material
                            anywhere unless
                            you are promoting your page.</b></p>
                    <p style="text-align:center;"><b>Any kind of attact to the website will be consider as a cyber crime
                            and corresponding
                            action will be taken.<br>
                            You can not use any material from the website to make your own website.<br>If you want to
                            help improve owr website
                            then you are always welcome
                            since we are always looking for hardworking engineers.
                        </b></p>
                    <br>
                    <div class="row container-fluid">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8" style="border:1px solid black;">
                            <h4 style="text-align:center; padding:25px;">How to make a living?</h4>
                            <p>We are making this wesite so that the creators can make a living by doing what they
                                love.This feature may not
                                be added immediately as soon as
                                the Site goes Live but this feature will soon be added,since we("creator of the
                                website") are just
                                students.After the feature is added we will inform you.
                            </p>
                            <h4 style="text-align:center; padding:25px;">Uploading others content</h4>
                            <p>This site was created so that people can make a living from their original work.So we do
                                not support any kind
                                of property theft of the creators.
                                In such cases it should be immediately reported to us.But in such cases we do not take
                                action lightly .We look
                                through it carefully and after understaning
                                the whole situation we take the necessary action.
                            </p>
                            <h4 style="text-align:center; padding:25px;">Breaking the law?</h4>
                            <p><b>Don't do anything</b> that breaks the law.We won't be responsible and will take action
                                to delete your
                                account.</p>
                            <h4 style="text-align:center; padding:25px;">Hurting other financially?</h4>
                            <p><b>Don't do anyhting</b> that might hurt other people in anyway.These type of action
                                should be repoted so we
                                can take acton.</p>
                            <br>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <br>
                    <a href="./signup/signup.php" class="btn btn-info" role="button" style="margin-left:250px;">Back to
                        Signup</a>
                    <br><br><br>
                </div>
            </article>
            <article class="form-container" id="report-page">
                <h3 class="form__title">Report a Problem</h3>
                <section id="report-page-container">
                    <form>
                        <span class="form__tip">Please report us about any bugs and problem related to the site. For any
                            complaint related to user or user content please refer to 'File a Complain'</span>
                        <section class="field-container">
                            <label class="field__label">Report</label>
                            <textarea rows="6" class="field__input--large" placeholder="What happened?"
                                name="report"></textarea>
                        </section>
                    </form>
                    <button class="button-filled" onclick="sendReport(this)">Send Report</button>
                </section>

                <aside id="report__success-page">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none"
                        stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-check">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg><br>
                    Thank you for the report! Your report might help make the other user's experience better in future.
                </aside>
            </article>
            <article class="form-container" id="support-page">
                <h3 class="form__title">Contact Support</h3>
                <section id="support-page-container">
                    <form>
                        <section class="field-container">
                            <label class="field__label">Inquiry Subject</label>
                            <input id='input-name' class='field__input' type='text' name='subject'>
                        </section>
                        <section class="field-container">
                            <label class="field__label">Email</label>
                            <input id='input-email' class='field__input' type='email' name='email'>
                        </section>
                        <span class="form__tip">This email will be used to contact you on your inquiry</span>
                        <section class="field-container">
                            <label class="field__label">Inquiry</label>
                            <textarea rows="6" class="field__input--large" placeholder="Tell us about your problem"
                                name="inquiry"></textarea>
                        </section>
                    </form>
                    <button class="button-filled" onclick="sendInquiry()">Send Inquiry</button>
                </section>
                <aside id="support__success-page">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none"
                        stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-check">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg><br>
                    Thank you! Your Inquiry has been received and will be processed shortly.
                </aside>
            </article>
        </section>
    </main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="./js/help.js"></script>
</html>