<?php

session_start();
if ($_SESSION["logged"]) {
    $x = json_decode(base64_decode($_GET["d"]), true);
    $p = __DIR__ . "/../../data/projects/{$x["conf"]["id"]}/conf.json";
    file_put_contents($p, json_encode($x["conf"], JSON_PRETTY_PRINT));

    $p = __DIR__ . "/../../data/projects/{$x["conf"]["id"]}/lang.json";
    file_put_contents($p, json_encode($x["lang"], JSON_PRETTY_PRINT));
} else {
    header("location: /login");
}