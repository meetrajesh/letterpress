<?php

class template {

    protected $_block;
    protected $_blocks = array();
    protected $_lastchange;

    public function block($name) {
        $this->_block = $name;
        ob_start();
    }

    public function endblock($output = false) {
        $content = ob_get_clean();

        if (!isset($this->_blocks[$this->_block])) {
            $this->_blocks[$this->_block] = $content;
        }

        $content = $this->_blocks[$this->_block];
        unset($this->_block);

        if ($output) {
            echo $content;
        }

        return $content;
    }
    
    public function getblock($block_name) {
        return $this->_blocks[$block_name];
    }

    public function cycle(&$pointer, $list=array()) {
        $list = func_get_args();
        $pointer = array_shift($list);

        if (count($list)) {
            $pointer %= count($list);
            return $list[$pointer];
        } else {
            return false;
        }

        $pointer++;
    }

    public function firstof($list=array()) {
        $list = func_get_args();
        foreach ($list as $item) {
            if ($item) {
                return $item;
            }
        }
        return false;
    }

    public function flush() {
        unset($this->_lastchange);
    }

    public function ifchanged() {
        ob_start();
    }

    public function endifchanged() {
        $content = ob_get_clean();

        if (md5($content) != $this->_lastchange) {
            echo $content;
            $this->_lastchange = md5($content);
        }
    }

    public function notempty($value, $prefix='', $suffix='') {
        if (!empty($value)) {
            return $prefix . $value . $suffix;
        }
        return '';
    }

    public function pluralize($count, $plural='s', $singular='') {
        if (is_array($count)) {
            $count = count($count);
        }

        return ((int)$count == 1) ? $singular : $plural;
    }

    public function regroup($list, $groupby) {
        $regroup = array();

        if (is_array($list)) {
            foreach ($list as $item) {
                if (!is_array($regroup[$item[$groupby]])) {
                    $regroup[$item[$groupby]] = array();
                }

                unset($item[$groupby]);
                $regroup[$item[$groupby]][] = $item;
            }

            return $regroup;
        } else {
            return $list;
        }
    }

}