<?php


namespace HexaStudio\HTML;


class HTMLTextNode extends Element
{
    private string $value;

    /**
     * @param string $value Text Content
     */
    public function __construct(string $value)
    {
        parent::__construct("text");
        $this->value = $value;
    }

    /**
     * Parse the Element and his children to an HTML String
     *
     * @return string
     */
    public function parse(): string
    {
        return $this->value;
    }
}