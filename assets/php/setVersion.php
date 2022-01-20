<?php

if (isset($_FILES["file"]) && isset($_GET["id"]) && isset($_GET["t"]) && isset($_GET["i"])) {
    $p = __DIR__ . "/../../data/projects/{$_GET["id"]}/" . time() . "-" . $_FILES["file"]["name"];
    move_uploaded_file($_FILES["file"]["tmp_name"], $p);
    $conf = json_decode(file_get_contents(__DIR__ . "/../../data/projects/{$_GET["id"]}/conf.json"), true);

    for ($i = 0; $i < count($conf["versions"]); $i++) {
        if ($conf["versions"][$i]["tag"] === $_GET["t"]) {
            if (file_exists(dirname($p) . "/" . $conf["versions"][$i]["downloads"][$_GET["i"]]["file"])) {
                unlink(dirname($p) . "/" . $conf["versions"][$i]["downloads"][$_GET["i"]]["file"]);
            }

            $conf["versions"][$i]["downloads"][$_GET["i"]]["file"] = basename($p);
            break;
        }
    }

    file_put_contents(__DIR__ . "/../../data/projects/{$_GET["id"]}/conf.json", json_encode($conf, JSON_PRETTY_PRINT));
}