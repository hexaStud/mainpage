<?php


namespace HexaStudio\HTML;



abstract class Element
{
    /**
     *
     * HTML Tag
     *
     * @var string
     */
    protected string $tag;
    /**
     * Dictionary of HTML Attributes
     *
     * @var array
     */
    protected array $attr;

    /**
     * @param string $tag HTML Tag
     */
    public function __construct(string $tag)
    {
        $this->tag = $tag;
        $this->attr = array();
    }


    /**
     * Set a custom or html attribute for the Element
     *
     * @param string $key
     * @param string $value
     */
    public function setAttribute(string $key, string $value)
    {
        $this->attr[$key] = $value;
    }

    /**
     * Get an existing attribute of the Element
     *
     * @param string $key
     * @return string
     */
    public function getAttribute(string $key): string
    {
        if (array_key_exists($key, $this->attr)) {
            return $this->attr[$key];
        } else {
            return "";
        }
    }

    /**
     * @return string
     */
    protected function buildAttr(): string
    {
        $attr = "";

        foreach ($this->attr as $key => $item) {
            $attr .= " " . $key . "=\"" . $item . "\"";
        }

        return $attr;
    }


    /**
     * Parse the Element and his children to an HTML String
     *
     * @return string
     */
    public abstract function parse(): string;

    /**
     * Build an Element out of an Array
     *
     * @param array $element
     *      IElement = [
     *          "tag": "TextNode" | string,
     *          "single": boolean,
     *          "attr": Dictionary<string | string>
     *          "appends" ?: IElement[], (optional)
     *          "text" ?: string (optional)
     *      ]
     *      $element = IElement
     * @return Element
     */
    public static function parseByArray(array $element): Element
    {
        if (!isset($element["tag"]) || !isset($element["attr"]) || !isset($element["single"])) {
            throw new \Error("Error wrong object Type: parseByArray");
        }

        if ($element["tag"] === "TextNode") {
            return new HTMLTextNode($element["text"]);
        } else {
            if ($element["single"]) {
                $ele = new HTMLSingleElement($element["tag"]);
                foreach ($element["attr"] as $key => $attr) {
                    $ele->setAttribute($key, $attr);
                }
            } else {
                $ele = new HTMLElement($element["tag"]);
                foreach ($element["attr"] as $key => $attr) {
                    $ele->setAttribute($key, $attr);
                }

                if ($element["appends"]) {
                    foreach ($element["appends"] as $append) {
                        $ele->appendChild(self::parseByArray($append));
                    }
                }

            }
            return $ele;
        }
    }
}
