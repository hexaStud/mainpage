<?php

session_start();

if (isset($_POST["p"]) && isset($_POST["u"])) {
    $accounts = json_decode(file_get_contents(__DIR__ . "/../../data/account.json"), true);
    foreach ($accounts as $account) {
        if ($account["username"] === $_POST["u"]) {
            if (password_verify($_POST["p"], $account["password"])) {
                echo base64_encode($account["id"]);
                $_SESSION["logged"] = true;
                $_SESSION["id"] = base64_encode($account["id"]);
                exit;
            }
        }
    }

    echo "fail";
} else {
    echo "fail";
}