<?php


namespace HexaStudio\Data;

class ServerConfig
{
    /**
     * @var array
     *
     * IEncoding = [
     *   "mime": string,
     *   "extension": string
     * ]
     *
     * IPage = [
     *   "url": string,
     *   "file": string
     * ]
     *
     * [
     *   "static": boolean,
     *   "encodings": IEncoding[],
     *   "includes": string[],
     *   "disableDirs": string[],
     *   "pages": IPage[],
     *   "error": [
     *      "404": string | false,
     *      "301": string | false
     *   ],
     *   "paths": Dictionary<string, string>,
     * ]
     */
    public static array $conf = array(
        "static" => false,
        "encodings" => array(),
        "includes" => array(),
        "pages" => array(),
        "error" => array(),
        "paths" => array(),
        "disableDirs" => array()
    );
}