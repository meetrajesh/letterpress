<?php

class session {

    public static function id() {
        return session_id();
    }

	public static function set_login_token($token) {
		return setcookie('lp_token', $token, time()+60*60*24*30, PATH_PREFIX);
	}

	public static function get_login_token() {
		return !empty($_COOKIE['lp_token']) ? (string)$_COOKIE['lp_token'] : false;
	}

    public static function get_ip() {
        return notempty($_SERVER, 'REMOTE_ADDR');
    }

    public static function get_referer($default='/') {
        return notempty($_SERVER, 'HTTP_REFERER', $default);
    }

}
