<?php

include "loader.php";

use HexaStudio\Server\PageHandler;
use HexaStudio\Server\PageCompiler;
use HexaStudio\Data\ServerConfig;
use HexaStudio\Data\Path;

$pageHandler = new PageHandler();
$pageHandler->setStatic(ServerConfig::$conf["enableStaticAccess"]);
$pageHandler->setDisableDirs(ServerConfig::$conf["disableDirs"]);

foreach (ServerConfig::$conf["pages"] as $page) {
    $pageHandler->register($page["url"], $page["file"]);
}

$keys = array_keys(ServerConfig::$conf["paths"]);
foreach ($keys as $key) {
    Path::setPath($key, ServerConfig::$conf["paths"][$key]);
}

$_SERVER["REQUEST_URI"] = explode("?", $_SERVER["REQUEST_URI"])[0];


$page = $pageHandler->exec($_SERVER["REQUEST_URI"]);

$compiler = new PageCompiler($page["path"], $page["key"]);
$compiler->build();