<?php


namespace HexaStudio\Data;

class Path
{
    /**
     * Path of the Root
     *
     * @var string
     */
    public static string $root = __DIR__ . "/../..";
    /**
     * @var array
     */
    private static array $paths = array();


    /**
     * Store a path with a key
     *
     * @param string $name
     * @param string $value
     */
    public static function setPath(string $name, string $value)
    {
        Path::$paths[$name] = $value;
    }

    /**
     * Get a stored path with a key
     *
     * @param string $name
     * @return string|false
     */
    public function getPath(string $name): string|false
    {
        if (array_key_exists($name, Path::$paths)) {
            return Path::$paths[$name];
        } else {
            return false;
        }
    }
}