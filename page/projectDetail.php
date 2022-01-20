<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HexaStudio - </title>
    <link rel="stylesheet" href="/assets/css/projectDetail.css">
    <script src="/assets/js/i18n.js"></script>
    <script src="/assets/js/i18n-interface.js"></script>
    <script src="/assets/js/projectDetail.js"></script>
</head>
<body>
<div class="navbar transparent" id="navbar">
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
    <div class="container">
        <div class="center">
            <div class="iconBox" style="height: 120px; width: 120px; padding: 30px">
                <img style="height: 120px; width: 120px;" id="projectIcon" src="">
            </div>
        </div>
        <div class="title padding-b-100px">
            <span id="projectTitle"></span>
        </div>
        <div class="container">
            <div class="imgContainer center">
                <img id="projectWallpaper" src="">
            </div>
        </div>
        <div class="container margin-t-100px margin-b-50px">
            <div class="noteText left">
                <span id="projectLicense"></span>
            </div>
            <div class="textBox left">
                <p id="projectDescription"></p>
            </div>
            <div class="noteText left">
                <span id="projectSign"></span>
            </div>
        </div>
        <div class="container">
            <div class="title color:black">
                <span i18n="release>title"></span>
            </div>
            <div class="listBox">
                <ul id="productList">
                </ul>
            </div>
        </div>
    </div>
</section>
</body>
</html>
