<?php

namespace HexaStudio\Library\Structure;

class Map
{
    private array $arr;

    public function __construct()
    {
        $this->arr = array();
    }

    public function set(string $key, $value): void
    {
        $this->arr[$key] = $value;
    }

    public function get(string $key):mixed
    {
        return $this->arr[$key];
    }
    
    public function tryGet(string $key, $default):mixed {
        if (array_key_exists($key, $this->arr)) {
            return $this->arr[$key];
        } else {
            return $default;
        }
    }

    public function has(string $key): bool {
        return array_key_exists($key, $this->arr);
    }
}