<?php


namespace HexaStudio\Server;

use HexaStudio\Data\Path;
use HexaStudio\Data\ServerConfig;

class PageHandler
{
    /**
     * @var array
     */
    private array $pages;
    /**
     * @var bool
     */
    private bool $static;

    /**
     * @var array
     */
    private array $disableDirs;

    public function __construct()
    {
        $this->pages = array();
        $this->disableDirs = array();
        $this->static = false;
    }

    /**
     * Register a new Page
     *
     * @param string $call The URL path necessary for the execution
     * @param string $file The file what will be executed
     */
    public function register(string $call, string $file): void
    {
        if (str_starts_with($file, "/") || str_starts_with($file, "\\")) {
            $path = Path::$root . $file;
        } else {
            $path = Path::$root . "/" . $file;
        }

        if (!file_exists($path)) {
            echo "File not exists $file";
            exit;
        } else if (is_dir($path)) {
            echo "Path must be a file $file";
            exit;
        }

        $this->pages[$call] = $file;
    }

    /**
     * Check if $call is registered, and return the associated file path.
     *
     * @param string $call URL Path
     * @return array {path: string, key: string}
     */
    public function exec(string $call): array
    {
        $item = $this->getItem($call);

        if ($item) {
            if ($this->isForbidden($item)) {
                if (ServerConfig::$conf["error"]["301"]) {
                    return array(
                        "path" => (str_starts_with(ServerConfig::$conf["error"]["301"], "/") || str_starts_with(ServerConfig::$conf["error"]["301"], "\\")) ? Path::$root . ServerConfig::$conf["error"]["301"] : Path::$root . "/" . ServerConfig::$conf["error"]["301"],
                        "key" => "301"
                    );
                } else {
                    echo "<h1>Error 301. Request forbidden</h1>";
                }
                exit;
            }

            return array(
                "path" => (str_starts_with($item, "/") || str_starts_with($item, "\\")) ? Path::$root . $item : Path::$root . "/" . $item,
                "key" => $call);
        } else if ($this->static && file_exists(Path::$root . $call) && is_file(Path::$root . $call)) {
            if ($this->isForbidden($call)) {
                if (ServerConfig::$conf["error"]["301"]) {
                    return array(
                        "path" => (str_starts_with(ServerConfig::$conf["error"]["301"], "/") || str_starts_with(ServerConfig::$conf["error"]["301"], "\\")) ? Path::$root . ServerConfig::$conf["error"]["301"] : Path::$root . "/" . ServerConfig::$conf["error"]["301"],
                        "key" => "301");
                } else {
                    echo "<h1>Error 301. Request forbidden</h1>";
                }
                exit;
            }

            return array("path" => Path::$root . $call,
                "key" => $call);
        } else {
            if (ServerConfig::$conf["error"]["404"]) {
                return array(
                    "path" => (str_starts_with(ServerConfig::$conf["error"]["404"], "/") || str_starts_with(ServerConfig::$conf["error"]["404"], "\\")) ? Path::$root . ServerConfig::$conf["error"]["404"] : Path::$root . "/" . ServerConfig::$conf["error"]["404"],
                    "key" => "404");
            } else {
                echo "<h1>Error 404 Key not found</h1>";
            }
            exit;
        }
    }

    /**
     * Set a list of folders that are disabled for requests
     *
     * @param bool $flag
     */
    public function setStatic(bool $flag)
    {
        $this->static = $flag;
    }

    /**
     * Prohibition of access from a list of folders
     *
     * @param array $arr
     */
    public function setDisableDirs(array $arr)
    {
        $this->disableDirs = $arr;
    }

    /**
     * @param string $call
     * @return string|false
     */
    private function getItem(string $call): string|false
    {
        if ($call === "/") {
            if (array_key_exists("/", $this->pages)) {
                return $this->pages["/"];
            }
        } else {
            $urlThree = explode("/", $call);

            $keys = array_keys($this->pages);

            for ($i = 0; $i < count($keys); $i++) {
                $dataThree = explode("/", $keys[$i]);

                $isDataCase = true;

                if (count($dataThree) !== count($urlThree)) {
                    continue;
                }

                for ($k = 0; $k < count($urlThree); $k++) {
                    if ($dataThree[$k] !== "*") {
                        if ($urlThree[$k] !== $dataThree[$k]) {
                            $isDataCase = false;
                            break;
                        }
                    }
                }

                if ($isDataCase) {
                    return $this->pages[$keys[$i]];
                }
            }

        }

        return false;
    }

    private function isForbidden(string $call): bool
    {
        if (!str_starts_with($call, "/")) {
            $call = "/$call";
        }

        foreach ($this->disableDirs as $dir) {
            if (!str_starts_with($dir, "/")) {
                $dir = "/$dir";
            }

            if (str_starts_with($call, $dir)) {
                return true;
            }
        }

        return false;
    }
}