<?php

namespace HexaStudio\Library\IO;

use HexaStudio\Library\Structure\Index;

class Path
{
    public static function join(string $root, array $args, $flags = FORE_SLASHES): string
    {
        $root = preg_replace("/\\\\/i", "/", $root);
        $root = explode("/", $root);

        $parts = new Index($root);

        foreach ($args as $arg) {
            $arg = preg_replace("/\\\\/i", "/", $arg);
            $arg = explode("/", $arg);

            $parts->addRange(new Index($arg));
        }

        $path = new Index();

        for ($i = 0; $i < $parts->length(); $i++) {
            $part = $parts->get($i);
            if ($part === "") {
                continue;
            }

            if ($part === "..") {
                if ($path->length() !== 0) {
                    $path->removeAt($path->length() - 1);
                }
            } else {
                $path->add($part);
            }
        }

        $str = "";

        for ($i = 0; $i < $path->length(); $i++) {
            $str .= $path->get($i);
            if ($flags === BACK_SLASHES) {
                if ($i !== $path->length() - 1) {
                    $str .= "\\";
                }
            } else {
                if ($i !== $path->length() - 1) {
                    $str .= "/";
                }
            }
        }

        if (PHP_OS !== "WINNT") {
            $str = "/".$str;
        }

        return $str;
    }

    public static function isAbsolute(string $path, int $os): bool
    {
        if ($os === WIN32) {
            return substr($path, 1, 1) === ":";
        } else {
            return str_starts_with($path, "/") || str_starts_with($path, "\\");
        }
    }
}