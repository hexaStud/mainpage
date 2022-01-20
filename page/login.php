<?php
session_start();

if ($_SESSION["logged"]) {
    header("location: /home?name=" . urlencode($_SESSION["id"]));
}

use HexaStudio\Page\Component;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaStudio - Login</title>
    <link rel="stylesheet" href="/assets/css/login.css">
    <script src="/assets/js/axios.min.js"></script>
    <script src="/assets/js/i18n.js"></script>
    <script src="/assets/js/i18n-interface.js"></script>
    <script src="/assets/js/login.js"></script>
</head>
<body>
<div class="navbar" id="navbar">
    <nav>
        <img src="/assets/img/logo.png" alt="Logo">
    </nav>
    <nav>
        <button>
            <span id="back" i18n="navbar>button1"></span>
        </button>
    </nav>
</div>
<section>
    <div class="container panel">
        <div class="subtitle">
            <span i18n="panel>title"></span>
        </div>
        <form id="login" class="center">
            <input required id="username" i18n="panel>username" i18nattr="placeholder">
            <input required id="password" i18n="panel>password" i18nattr="placeholder" type="password">
            <button type="submit" class="margin-t-25px">
                <span i18n="panel>submit"></span>
            </button>
        </form>
    </div>
</section>
<section class="padding-150px container margin-0px" style="background: white;">
    <div class="grid size-m">
        <div class="grid-item center">
            <div class="subsubtitle">
                &nbsp;
            </div>
            <div class="textBox">
                <p>&nbsp;</p>
            </div>
            <div class="textBox">
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="grid-item center">
            <div class="subsubtitle">
                <span i18n="footer>copyright"></span>
            </div>
            <div class="textBox ">
                <p i18n="footer>item>1"></p>
            </div>
            <div class="textBox ">
                <p i18n="footer>item>2"></p>
            </div>
        </div>
        <div class="grid-item center">
            <div class="subsubtitle ">
                &nbsp;
            </div>
            <div class="textBox ">
                <p>&nbsp;</p>
            </div>
            <div class="noteText ">
                <span i18n="footer>text"></span>
            </div>
        </div>
    </div>
</section>
<?php
echo Component::buildAssets();
?>
</body>
</html>
