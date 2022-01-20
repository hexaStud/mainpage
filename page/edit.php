<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaStudio - Edit</title>
    <link rel="stylesheet" href="/assets/css/edit.css">
    <script src="/assets/js/i18n.js"></script>
    <script src="/assets/js/i18n-interface.js"></script>
    <script src="/assets/js/axios.min.js"></script>
    <script src="/assets/js/edit.js"></script>
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
    <div class="container center">
        <div class="title color:black">
            <span i18n="general>title"></span>
        </div>

        <input id="projectName" i18n="general>name" i18nattr="placeholder">
        <input id="projectLicense" i18n="general>license" i18nattr="placeholder">
        <div class="splitLine">

        </div>
        <div class="subtitle margin-t-25px">
            <span i18n="general>subtitle0"></span>
        </div>
        <div id="descriptionContainer">
            <textarea lang="en" id="projectDescription" i18n="general>description" i18nattr="placeholder"></textarea>
        </div>
        <div class="linkBox">
            <a id="addTranslation" i18n="general>addTranslation"></a>
        </div>
    </div>
    <div class="container center">
        <div class="title color:black">
            <span i18n="img>title"></span>
        </div>
        <div class="subtitle margin-b-50px">
            <span i18n="img>subtitle0"></span>
        </div>
        <div class="imgContainer">
            <img id="wallpaper" src="">
        </div>
        <div class="linkBox margin-b-50px margin-t-25px">
            <a id="changeWallpaper" i18n="img>changeWallpaper"></a>
        </div>
        <div class="subtitle">
            <span i18n="img>subtitle1"></span>
        </div>
        <div class="iconBox" style="height: 120px; width: 120px; padding: 30px">
            <img id="icon" style="height: 120px; width: 120px;">
        </div>
        <div class="linkBox margin-t-25px">
            <a id="changeIcon" i18n="img>changeIcon"></a>
        </div>
    </div>
    <div class="container center">
        <div class="title color:black">
            <span i18n="versions>title"></span>
        </div>
        <div id="versionsContainer">

        </div>
        <div class="linkBox">
            <a id="addVersionFile" i18n="versions>addVersion"></a>
        </div>
    </div>
    <div class="container">
        <button>
            <span i18n="controller>button" id="saveData"></span>
        </button>
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
</body>
</html>
