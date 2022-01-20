<?php


namespace HexaStudio\Server;


use HexaStudio\Data\ServerConfig;

class PageCompiler
{
    /**
     * @var string
     */
    private string $path;
    private string $key;

    /**
     * @param string $path The path of the target File
     */
    public function __construct(string $path, string $key)
    {
        $this->path = $path;
        $this->key = $key;
    }

    /**
     * Run the PageCompiler
     */
    public function build()
    {
        if ($this->key === "404") {
            http_response_code(404);
        }

        if (mime_content_type($this->path) === "text/x-php") {
            include $this->path;
        } else {
            $encodings = ServerConfig::$conf["encodings"];
            $header = "";
            $extension = pathinfo($this->path, PATHINFO_EXTENSION);
            foreach ($encodings as $encoding) {
                if ($extension === $encoding["extension"]) {
                    $header = $encoding["mime"];
                }
            }

            if ($header === "") {
                $header = match ($extension) {
                    "css" => "text/css",
                    "js" => "application/javascript",
                    default => mime_content_type($this->path),
                };
            }

            header("Content-Type: $header");
            print file_get_contents($this->path);
        }
    }
}



