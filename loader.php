<?php

$serverConf = json_decode(file_get_contents(__DIR__."/conf.json"), true);

use HexaStudio\Data\ServerConfig;

function includeFiles($path)
{
    $dirs = scandir($path);
    foreach ($dirs as $dir) {
        if ($dir === "." || $dir === "..") {
            continue;
        }

        if (is_file($path . "/" . $dir)) {
            if (mime_content_type($path . "/" . $dir) === "text/x-php") {
                include $path . "/" . $dir;
            }
        } else if (is_dir($path . "/" . $dir)) {
            includeFiles($path . "/" . $dir);
        }
    }
}


foreach ($serverConf["includes"] as $include) {
    includeFiles(__DIR__ . "/" . $include);
}

ServerConfig::$conf = $serverConf;
$serverConf = false;

