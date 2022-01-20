<?php

$arr = explode("/", $_SERVER["REQUEST_URI"]);
$file = $arr[count($arr) - 1];
array_pop($arr);
$id = $arr[count($arr) - 1];
array_pop($arr);

$p = __DIR__ . "/../../data/projects/$id/$file";
if (file_exists($p)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($p) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($p));
    readfile($p);
}