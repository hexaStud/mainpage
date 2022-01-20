<?php

if (isset($_FILES["file"]) && isset($_GET["id"]) && isset($_GET["k"])) {
    $p = __DIR__ . "/../../data/projects/{$_GET["id"]}/" . time() . "-" . $_FILES["file"]["name"];
    move_uploaded_file($_FILES["file"]["tmp_name"], $p);
    $conf = json_decode(file_get_contents(__DIR__ . "/../../data/projects/{$_GET["id"]}/conf.json"), true);

    if (file_exists(dirname($p) . "/" . $conf[$_GET["k"]])) {
        unlink(dirname($p) . "/" . $conf[$_GET["k"]]);
    }
    $conf[$_GET["k"]] = basename($p);


    file_put_contents(__DIR__ . "/../../data/projects/{$_GET["id"]}/conf.json", json_encode($conf, JSON_PRETTY_PRINT));
}