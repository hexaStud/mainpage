<?php

session_start();

if (!$_SESSION["logged"]) {
    header("location: /login?name=");
}

use HexaStudio\Page\Component;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaStudio - Home</title>
    <link rel="stylesheet" href="/assets/css/home.css">
    <script src="/assets/js/i18n.js"></script>
    <script src="/assets/js/i18n-interface.js"></script>
    <script src="/assets/js/home.js"></script>
</head>
<body>
<div class="navbar" id="navbar">
    <nav>
        <img src="/assets/img/logo.png" alt="Logo">
    </nav>
    <nav>
        <button>
            <span id="logout" i18n="navbar>button1"></span>
        </button>
    </nav>
</div>
<section>
    <div class="container">
        <div class="grid size-m" id="productList">
        </div>
        <div class="container center">
            <div class="linkBox">
                <a onclick="window.location.href = '/home/new' + window.location.search" i18n="product>new"></a>
            </div>
        </div>
    </div>
</section>
<section class="padding-150px container colored-secondary margin-0px">
    <div class="grid size-m">
        <div class="grid-item center">
            <div class="subsubtitle light">
                &nbsp;
            </div>
            <div class="textBox light">
                <p>&nbsp;</p>
            </div>
            <div class="textBox light">
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="grid-item center">
            <div class="subsubtitle light">
                <span i18n="footer>copyright"></span>
            </div>
            <div class="textBox light">
                <p i18n="footer>item>1"></p>
            </div>
            <div class="textBox light">
                <p i18n="footer>item>2"></p>
            </div>
        </div>
        <div class="grid-item center">
            <div class="subsubtitle light">
                &nbsp;
            </div>
            <div class="textBox light">
                <p>&nbsp;</p>
            </div>
            <div class="noteText light">
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
