<?php

use HexaStudio\Page\Component;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
    <link rel="stylesheet" href="/assets/css/404.css">
    <script src="/assets/js/i18n.js"></script>
    <script src="/assets/js/i18n-interface.js"></script>
    <script src="/assets/js/404.js"></script>
</head>
<body>
<section>
    <div class="container center">
        <div class="container">
            <div class="imgContainer">
                <img src="/assets/img/404.png">
            </div>
        </div>
        <div class="title">
            <span i18n="title"></span>
        </div>
        <div class="splitLine"></div>
        <div class="subtitle padding-t-25px">
            <span id="text"></span>
        </div>
        <div class="linkBox padding-t-25px" style="font-size: 1.5em;">
            <a id="back" i18n="btn1"></a>
        </div>
        <div class="linkBox padding-t-25px" style="font-size: 1.5em;">
            <a href="/" i18n="btn2"></a>
        </div>
    </div>

</section>
<?php
echo Component::buildAssets();
?>
</body>
</html>
