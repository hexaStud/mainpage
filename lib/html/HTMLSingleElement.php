<?php


namespace HexaStudio\HTML;


class HTMLSingleElement extends Element
{
    /**
     * @param string $tag HTML Tag
     */
    public function __construct(string $tag)
    {
        parent::__construct($tag);
    }

    /**
     * Parse the Element and his children to an HTML String
     *
     * @return string
     */
    public function parse(): string
    {
        $html = "<" . $this->tag;
        $html .= $this->buildAttr();
        $html .= ">";
        return $html;
    }
}