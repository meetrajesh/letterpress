<?php

class csrf {

    public static function check($unique=null, $csrf=null) {
        $unique = (empty($unique)) ? self::_unique() : $unique;
        $csrf = !empty($csrf) ? $csrf : (!empty($_REQUEST['csrf']) ? $_REQUEST['csrf'] : '');
        if (empty($csrf) || !security::hmac_check(CSRF_SECRET, $unique, $csrf)) {
            die('csrf check fail');
        }
    }

    public static function token($unique = null) {
        $unique = (empty($unique)) ? self::_unique() : $unique;
        return security::hmac_gen(CSRF_SECRET, $unique);
    }

    public static function html() {
        return '<input type="hidden" name="csrf" value="' . hsc(self::token()) . '">' . "\n";
    }

    public static function param() {
        return 'csrf=' . urlencode(self::token());
    }

    private static function _unique() {
        return session::id();
    }

    private static function _check_token($token) {
        return security::hmac_check(CSFRF_SECRET, self::_unique(), $token);
    }
}