<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 01.12.13
 * Time: 15:58
 */

class CakeOptimizer {

    protected $_filename = null;

    protected $_tempDir = null;
    /**
     * Encoding
     *
     * @var string
     */
    protected $_encoding = 'UTF-8';

    /**
     * Instance of PdfEngine class
     *
     * @var AbstractPdfEngine
     */
    protected $_engineClass = null;

    protected $_converterClass = null;
    /**
     * Pdf to be rendered
     *
     * @var string
     */
    protected $_pdf = null;

    /**
     * Get/Set Filename.
     *
     * @param null|string $encoding
     * @return mixed
     */
    public function filename($filename = null) {
        if ($filename === null) {
            return $this->_filename;
        }
        $this->_filename = $filename;
        return $this;
    }

    public function tempDir($dir = null) {
        if ($dir === null) {
            return $this->_tempDir;
        }
        $this->_tempDir = $dir;
        return $this;
    }

    /**
     * Get/Set Encoding.
     *
     * @param null|string $encoding
     * @return mixed
     */
    public function encoding($encoding = null) {
        if ($encoding === null) {
            return $this->_encoding;
        }
        $this->_encoding = $encoding;
        return $this;
    }

    /**
     * Get/Set Pdf.
     *
     * @param null|string $pdf
     * @return mixed
     */
    public function temp($pdf = null) {
        if ($pdf === null) {
            return $this->_pdf;
        }
        $this->_pdf = $pdf;
        return $this;
    }

    /**
     * Load OptimizeEngine
     *
     * @param string $name Classname of pdf engine without `Engine` suffix. For example `CakePdf.DomPdf`
     * @return object PdfEngine
     */
    public function engine($name = null) {
        if (!$name) {
            return $this->_engineClass;
        }

        list($pluginDot, $engineClassName) = pluginSplit($name, true);
        $engineClassName = $engineClassName . 'Optimizer';
        App::uses($engineClassName, $pluginDot . 'Optimizer/Engine');
        if (!class_exists($engineClassName)) {
            throw new CakeException(__d('cake_optimizer', 'Optimizer engine "%s" not found', $name));
        }
        if (!is_subclass_of($engineClassName, 'AbstractOptimizer')) {
            throw new CakeException(__d('cake_optimizer', 'Optimizer engines must extend "AbstractOptimizer"'));
        }
        $this->_engineClass = new $engineClassName($this);
        return $this->_engineClass;
    }

    public function converter($name = null){
        if (!$name) {
            return $this->_converterClass;
        }

        list($pluginDot, $engineClassName) = pluginSplit($name, true);
        $engineClassName = $engineClassName . 'Converter';
        App::uses($engineClassName, $pluginDot . 'Optimizer/Converter');
        if (!class_exists($engineClassName)) {
            throw new CakeException(__d('cake_optimizer', 'Optimizer engine "%s" not found', $name));
        }
        if (!is_subclass_of($engineClassName, 'AbstractConverter')) {
            throw new CakeException(__d('cake_optimizer', 'Optimizer engines must extend "AbstractConverter"'));
        }
        $this->_converterClass = new $engineClassName($this);
        return $this->_converterClass;
    }

    public function output($file = null){
        $Engine = $this->engine();
        if (!$Engine) {
            throw new CakeException(__d('cake_optimizer', 'Engine is not loaded'));
        }
        $Converter = $this->converter();
        if (!$Converter) {
            throw new CakeException(__d('cake_optimizer', 'Converter is not loaded'));
        }
        $Converter->convert();

        $output = $Engine->output();
        return $output;
    }

    public function optimize(){
        $this->converter('CakeOptimizePdf.Tiff');
        $this->engine('CakeOptimizePdf.Font');
        return $this->output();
    }

} 