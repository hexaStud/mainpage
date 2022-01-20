<?php


namespace HexaStudio\Page;


use HexaStudio\Data\Path;

abstract class Component
{
    /**
     * @var array
     */
    private static array $components = array();
    /**
     * @var array|array[]
     */
    private static array $includeAssets = array(
        "js" => array(),
        "css" => array()
    );
    /**
     * A complete Dictionary of the Variable $_GET & $_POST
     *
     * @var array
     */
    public static array $queryStack = array();
    /**
     * The Path of the Request
     *
     * @var string
     */
    public static string $request;
    /**
     * @var array
     */
    protected array $query;
    /**
     * @var array
     */
    protected array $data;
    /**
     * @var Path
     */
    protected Path $path;
    /**
     * @var array
     */
    public array $assets;

    /**
     * @param array $values A Dictionary to give Parameters to the Component
     */
    public function __construct(array $values = array())
    {
        $this->query = Component::$queryStack;
        $this->data = $values;
        $this->path = new Path();
        $this->assets = array();
    }

    /**
     * Create a one existing ID
     *
     * @return int
     */
    protected function createId(): int
    {
        return DataManager::getNewId();
    }

    /**
     * @param string $caller
     * @param $component
     */
    private static function addComponent(string $caller, $component): void
    {
        Component::$components[$caller] = $component;
    }

    /**
     * @param string $data
     * @return string
     */
    private static function buildCSSInclude(string $data): string
    {
        return <<<EOF
        <script>
        window.addEventListener("load", () => {
            const promises = [];
            for (const asset of $data) {
                let link  = document.createElement('link');
                link.rel  = 'stylesheet';
                link.href = asset;
                promises.push(new Promise((resolve, reject) => {
                   const t = setTimeout(() => reject("Timeout!"), 2000);
                   link.addEventListener("load", () => {
                       clearTimeout(t);
                       resolve();
                   });
                }));
                document.getElementsByTagName("head")[0].appendChild(link);
                Promise.all(promises).finally(() => window.dispatchEvent(new Event("StylesLoaded")));
            }
        });
        </script> 
        EOF;
    }

    /**
     * @param array $assets
     *      IAsset = [
     *          css: string[],
     *          js: string[]
     *      ]
     *
     *      $assets = IAsset
     */
    public static function addAssets(array $assets): void
    {
        if (array_key_exists("js", $assets)) {
            foreach ($assets["js"] as $js) {
                if (!in_array($js, Component::$includeAssets["js"])) {
                    array_push(Component::$includeAssets["js"], $js);
                }
            }
        }

        if (array_key_exists("css", $assets)) {
            foreach ($assets["css"] as $js) {
                if (!in_array($js, Component::$includeAssets["css"])) {
                    array_push(Component::$includeAssets["css"], $js);
                }
            }
        }
    }

    /**
     * Call a component with his component name
     *
     * @param string $caller
     * @param array $values A Dictionary with values to send to the component
     * @return string
     */
    public static function callComponent(string $caller, array $values = array()): string
    {
        /**
         * @var Component
         */
        $component = new Component::$components[$caller]($values);
        Component::addAssets($component->assets);
        return $component->main();
    }

    /**
     *
     * Get a Component with his name
     *
     * @param string $caller
     * @param array $values
     * @return Component
     */
    public static function getComponent(string $caller, array $values = array()): Component
    {
        /**
         * @var Component
         */
        return new Component::$components[$caller]($values);
    }

    /**
     * Check if a component exists
     *
     * @param string $caller
     * @return bool
     */
    public static function exists(string $caller): bool
    {
        return array_key_exists($caller, Component::$components);
    }

    /**
     * Build a Component after the build it's accessible with Component::callComponent;
     *
     * @param string $caller The Component Name
     * @param string $className The className of the Component
     * @param string $namespace (Optional) The namespace of the Component
     */
    public static function buildComponent(string $caller, string $className, string $namespace = "\\"): void
    {
        Component::addComponent($caller, $namespace . $className);
    }

    /**
     * Builds the Asset to an HTML String
     *
     * @return string
     */
    public static function buildAssets(): string
    {
        $jsAssets = "";
        if (array_key_exists("css", Component::$includeAssets)) {
            $cssAssets = array();

            foreach (Component::$includeAssets["css"] as $css) {
                array_push($cssAssets, $css);
            }

            if (count($cssAssets) !== 0) {
                $jsAssets .= Component::buildCSSInclude(json_encode($cssAssets));
            }
        }

        if (array_key_exists("js", Component::$includeAssets)) {
            foreach (Component::$includeAssets["js"] as $js) {
                $jsAssets .= "<script src='$js'></script>";
            }
        }

        return $jsAssets;
    }

    /**
     * @return string
     */
    abstract public function main(): string;

}

Component::$queryStack = (empty($_POST)) ? $_GET : $_POST;
Component::$request = $_SERVER["REQUEST_URI"];