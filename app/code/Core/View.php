<?php

namespace Core;

/**
 * Class View
 * @package Core
 */
class View {

    /**
     * @var string
     */
    protected $title = "";

    /**
     * @var string
     */
    private $_linkTags = "";

    /**
     * @var string
     */
    private $_scriptTags = "";

    /**
     * @param $files
     */
    public function addCSS($files) {

        // Cast the value of $files to type array if it is not already.
        if (!is_array($files)) {
            $files = (array) $files;
        }
        foreach ($files as $file) {

            // Check that the file exists in the public directory, creating the
            // <link> tag if it true.
            if (file_exists(PUB_ROOT . $file)) {
                $this->_linkTags .= '<link type="text/css" rel="stylesheet" href="' . $this->makeURL($file) . '" />' . "\n";
            }
        }
    }

    /**
     * @param array $data
     */
    public function addData(array $data) {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * @param $files
     */
    public function addJS($files) {

        // Cast the value of $files to type array if it is not already.
        if (!is_array($files)) {
            $files = (array) $files;
        }
        foreach ($files as $file) {

            // Check that the file exists in the public directory, creating the
            // <script> tag if it true.
            if (file_exists(PUB_ROOT . $file)) {
                $this->_scriptTags .= '<script type="text/javascript" src="' . $this->makeURL($file) . '"></script>' . "\n";
            }
        }
    }

    /**
     * @param $string
     * @return string
     */
    public function escapeHTML($string) {
        return(htmlentities($string, ENT_QUOTES, 'UTF-8', false));
    }

    /**
     * @return string
     */
    public function getCSS() {
        return($this->_linkTags);
    }

    /**
     * @param $filepath
     */
    public function getFile($filepath) {
        $filename = VIEW_PATH . $filepath . ".phtml";

        if (file_exists($filename)) {
            require $filename;
        }
    }

    /**
     * @return string
     */
    public function getJS() {
        return($this->_scriptTags);
    }

    /**
     * @param string $path
     * @return string
     */
    public function makeURL($path = "") {
        if (is_array($path)) {
            return(APP_URL . implode("/", $path));
        }

        return(APP_URL . $path);
    }

    /**
     * @param $filepath
     * @param array $data
     */
    public function render($filepath, array $data = []) {
        $this->addData($data);
        $this->getFile('core/header');
        $this->getFile($filepath);
        $this->getFile('core/footer');
    }

    /**
     * @param array $filepaths
     * @param array $data
     */
    public function renderMultiple(array $filepaths, array $data = []) {
        $this->addData($data);
        $this->getFile('core/header');

        foreach ($filepaths as $filepath) {
            $this->getFile($filepath);
        }

        $this->getFile('core/footer');
    }

    /**
     * @param $filepath
     * @param array $data
     */
    public function renderWithoutHeaderAndFooter($filepath, array $data = []) {
        $this->addData($data);
        $this->getFile($filepath);
    }
}