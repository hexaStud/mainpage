<?php

namespace HexaStudio\Library\System;

class OS
{
    public static function getOS(): int
    {
        if (PHP_OS_FAMILY == "Linux") {
            return LINUX;
        } else if (PHP_OS_FAMILY == "Darwin") {
            return MACOS;
        } else {
            return WIN32;
        }
    }
}