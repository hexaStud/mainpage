<?php

if (isset($_GET["lang"])) {
    $obj = array();

    foreach (scandir(__DIR__ . "/../../data/projects") as $entry) {
        if ($entry === "." || $entry === "..") {
            continue;
        }
        $entryObj = array();
        $conf = json_decode(file_get_contents(__DIR__ . "/../../data/projects/$entry/conf.json"), true);
        $entryObj["name"] = $conf["name"];
        $entryObj["license"] = $conf["license"];
        $entryObj["id"] = $entry;
        $entryObj["icon"] = $conf["icon"];
        $entryObj["wallpaper"] = $conf["wallpaper"];
        $entryObj["author"] = $conf["author"];
        $entryObj["versions"] = $conf["versions"];
        $lang = json_decode(file_get_contents(__DIR__ . "/../../data/projects/$entry/lang.json"), true);
        if (isset($lang[$_GET["lang"]])) {
            $entryObj["lang"] = $lang[$_GET["lang"]];
        } else {
            $entryObj["lang"] = $lang["en"];
        }
        $entryObj["allLang"] = $lang;
        array_push($obj, $entryObj);
    }

    echo json_encode($obj);
} else {
    echo "[]";
}