<?php

namespace HexaStudio\Library\Structure;

class Index
{
    private array $arr;

    public function __construct(array $values = array())
    {

        $this->arr = $values;
    }

    public function add($value): void
    {
        array_push($this->arr, $value);
    }

    public function addRange(Index $list): void
    {
        foreach ($list->arr as $value) {
            $this->add($value);
        }
    }

    public function get(int $index, $default = false): mixed
    {
        if (array_key_exists($index, $this->arr)) {
            return $this->arr[$index];
        } else {
            return $default;
        }
    }

    public function unshift($value): void
    {
        array_unshift($this->arr, $value);
    }

    public function unshiftRange(Index $list): void
    {
        foreach ($list->arr as $value) {
            $this->unshift($value);
        }
    }

    public function removeAt(int $index): void
    {
        array_splice($this->arr, $index, 1);
    }

    public function length(): int {
        return count($this->arr);
    }
}