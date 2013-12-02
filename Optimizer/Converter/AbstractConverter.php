<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 01.12.13
 * Time: 23:56
 */

abstract class AbstractConverter {

    protected $_Optimizer = null;

    /**
     * Configurations
     *
     * @var array
     */
    protected $_config = array();

    /**
     * Constructor
     *
     * @param $Optimizer
     */
    public function __construct(CakeOptimizer $Optimizer) {
        $this->_Optimizer = $Optimizer;
    }

    /**
     * Implement in subclass to return raw pdf data.
     *
     */
    abstract public function convert();

    /**
     * Set the config
     *
     * @param mixed $config Null, string or array. Pass array of configs to set.
     * @return mixed Returns Returns config value if $config is string, else returns config array.
     */
    public function config($config = null) {
        if (is_array($config)) {
            $this->_config = $config;
        } elseif (is_string($config)) {
            if (!empty($this->_config[$config])) {
                return $this->_config[$config];
            }
            return false;
        }
        return $this->_config;
    }
} 