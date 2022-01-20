<?php

if (isset($_GET["c"]) && isset($_GET["id"])) {
    $path = __DIR__."/../../data/projects/{$_GET["id"]}/{$_GET["c"]}";

    if (file_exists($path)) {
        readfile($path);
    }
}