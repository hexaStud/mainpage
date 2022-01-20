<?php


namespace HexaStudio\HTML;


use HexaStudio\Page\Component;

class HTMLElement extends Element
{
    /**
     * @var <Component | Element>[]
     */
    private array $children;

    /**
     * @param string $tag HTML Tag
     */
    public function __construct(string $tag)
    {
        parent::__construct($tag);
        $this->children = array();
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

        $html .= $this->buildChildren();
        $html .= "</" . $this->tag . ">";

        return $html;
    }

    /**
     * @return string
     */
    private function buildChildren(): string
    {
        $children = "";

        foreach ($this->children as $child) {
            if ($child instanceof Element) {
                $children .= $child->parse();
            } else if ($child instanceof Component) {
                Component::addAssets($child->assets);
                $children .= $child->main();
            }
        }

        return $children;
    }

    /**
     * Append a new Element as a child to the existing element
     *
     * @param Element $element
     */
    public function appendChild(Element $element)
    {
        if ($element instanceof HTMLElement || $element instanceof HTMLSingleElement || $element instanceof HTMLTextNode) {
            array_push($this->children, $element);
        }
    }

    /**
     * Append a Component result as a child to the existing element
     *
     * @param Component $comp
     */
    public function appendComponent(Component $comp)
    {
        array_push($this->children, $comp);
    }

    /**
     * Append a Component result as a child to the existing element
     *
     * @param string $name
     * @param array $values (optional)
     */
    public function appendComponentByName(string $name, array $values = array())
    {
        array_push($this->children, Component::getComponent($name, $values));

    }
}