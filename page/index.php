<?php

use HexaStudio\Page\Component;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaStudio</title>
    <link rel="stylesheet" href="/assets/css/index.css">
    <script src="/assets/js/i18n.js"></script>
    <script src="/assets/js/i18n-interface.js"></script>
    <script src="/assets/js/index.js"></script>
</head>
<body>
<div class="navbar transparent" id="navbar">
    <nav>
        <img src="/assets/img/logo.png" alt="Logo">
    </nav>
    <nav>
        <button>
            <span id="login" i18n="navbar>button1">Login</span>
        </button>
    </nav>
</div>

<header>
    <div class="content">
        <h1 i18n="header>title"></h1>
        <h4 i18n="header>subtitle"></h4>
    </div>
</header>
<section class="build">
    <div class="title">
        <span i18n="build>title"></span>
    </div>
    <div class="subtitle">
        <span i18n="build>subtitle"></span>
    </div>
    <div class="imgContainer">
        <img class="size-l" src="/assets/img/code.png" alt="">
    </div>
</section>
<section>
    <div class="container">
        <div class="subtitle">
            <span i18n="build>future>title"></span>
        </div>
        <div class="grid size-m">
            <div class="grid-item center">
                <div class="iconBox">
                    <img src="/assets/img/icon-editing.png">
                </div>
                <div class="subsubtitle">
                        <span i18n="build>future>grid1>title">
                            Working
                        </span>
                </div>
                <div class="textBox">
                    <p i18n="build>future>grid1>text"></p>
                </div>
            </div>
            <div class="grid-item center">
                <div class="iconBox">
                    <img src="/assets/img/icon-global.png">
                </div>
                <div class="subsubtitle">
                    <span i18n="build>future>grid2>title"></span>
                    <div class="textBox">
                        <p i18n="build>future>grid2>text"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container colored-secondary margin-t-50px">
        <div class="subtitle light">
            <span i18n="build>everyone>title"></span>
        </div>
        <div class="grid size-m">
            <div class="grid-item center">
                <div class="subsubtitle light">
                    <span i18n="build>everyone>grid>grid1>title"></span>
                </div>
                <div class="textBox light">
                    <p i18n="build>everyone>grid>grid1>text"></p>
                </div>
                <div class="noteText light">
                    <span i18n="build>everyone>grid>grid1>node"></span>
                </div>
            </div>
            <div>
                <div class="subsubtitle light">
                    <span i18n="build>everyone>grid>grid2>title"></span>
                </div>
                <div class="textBox light">
                    <p i18n="build>everyone>grid>grid2>text"></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="title">
        <span i18n="products>title"></span>
    </div>
    <div class="subtitle">
        <span i18n="products>subtitle"></span>
    </div>
    <div class="container">
        <div class="grid size-m" id="productList">
        </div>
        <div class=" container center">
            <div class="linkBox">
                <a href="/project" i18n="products>link" target="_blank"></a>
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
