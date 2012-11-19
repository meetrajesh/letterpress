<?php

class BaseController {

    protected $_errors = array();
    protected $_msgs = array();
    protected $_stylesheets = array();
    protected $_scripts = array();
    protected $_tpl;

    protected function __construct() {
        $this->_tpl = new template();

        if (!empty($_POST) || !empty($_GET) || !empty($_REQUEST)) {
            csrf::check();
        }
    }

    protected function _render($template, $data=array()) {
        $t = $this->_tpl;

        $data['errors'] = $this->_errors;
        $data['msgs'] = $this->_msgs;

        require './views/' . $template . '.php';
    }

    protected function _buffer($template, $data=array()) {
        $t = $this->_tpl;
        ob_start();
        $this->_render($template, $data);
        return ob_get_clean();
    }

    protected function _add_css($files) {
        foreach ((array) $files as $file) {
            $path = STATIC_PREFIX . '/' . $file;
            if (file_exists(WEB_ROOT . '/'. $path)) {
                array_unshift($this->_stylesheets, $path);
            }
        }
    }

    protected function _add_js($files) {
        foreach ((array) $files as $file) {
            $path = STATIC_PREFIX . '/' . $file;
            if (file_exists(WEB_ROOT . '/'. $path)) {
                array_unshift($this->_scripts, $path);
            }
        }
    }

    protected function _display_errors($escape_html=true) {
        foreach ($this->_errors as $error) {
            $error = $escape_html ? hsc($error) : $error;
            echo '<span style="color: maroon;">' . hsc($error) . '</span><br/>';
        }
    }

    protected function _display_msgs($escape_html=true) {
        foreach ($this->_msgs as $msg) {
            $msg = $escape_html ? hsc($msg) : $msg;
            echo '<span style="color: teal;">' . $msg . '</span><br/>';
        }
    }

    protected function _redirect($path) {
        if (preg_match('/^https?:/', $path)) {
            header('Location: ' . $path);
        } else {
            header('Location: ' . BASE_URL . PATH_PREFIX . $path);
        }
        exit;
    }

    protected function _get_view_data($data) {
        $view_data = array();
        $optional_keys = array();
        // tack on the optional keys if they exist
        foreach ($optional_keys as $optional_key) {
            if (isset($data[$optional_key])) {
                $view_data[$optional_key] = $data[$optional_key];
            }
        }
        return $view_data;
    }

}