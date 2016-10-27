<?php
namespace Pionl\Laravel\Support\Loader;

/**
 * Class ClassGate
 *
 * Enables to get class representation from the config file and call static methods on it
 *
 * @package Pion\Laravel\Support\Loader
 */
class ClassGate
{
    //region Settings
    static protected $configPath = "classes";

    /**
     * @return string
     */
    public static function getConfigPath()
    {
        return static::$configPath;
    }

    /**
     * @param string $configPath
     */
    public static function setConfigPath($configPath)
    {
        static::$configPath = $configPath;
    }
    //endregion

    //region Shortcuts

    /**
     * Returns the class gate of given config key
     *
     * @param string $configKey
     *
     * @return static
     */
    static public function gate($configKey) {
        return new static($configKey);
    }

    /**
     * Shortcut for model class
     *
     * @param string $configKey
     *
     * @return string
     */
    static public function objectClass($configKey) {
        return static::gate($configKey)->theClass();
    }

    /**
     * Builds the models instance from the key
     *
     * @param string $configKey
     *
     * @return Object
     */
    public static function instance($configKey)
    {
        return static::gate($configKey)->newInstance();
    }

    //endregion

    /**
     * The objects class name
     * @var string
     */
    protected $class;

    /**
     * ConfigModel constructor.
     *
     * @param $configKey
     */
    public function __construct($configKey)
    {
        $this->class = config(static::getConfigPath().".".$configKey);
    }

    /**
     * Returns the model class
     * @return string
     */
    public function theClass()
    {
        return $this->class;
    }

    /**
     * Creates the model instance
     *
     * @return Object
     */
    public function newInstance()
    {
        $class = $this->class;
        return new $class();
    }

    /**
     * Pass any call to the original class
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    function __call($name, $arguments)
    {
        // call as static call
        return call_user_func_array([$this->class, $name], $arguments);
    }

    /**
     * Return the class of the model
     */
    function __toString()
    {
        return $this->class;
    }
}