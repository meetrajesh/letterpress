<?php

class security {

    public static function hmac_gen($secret, $data) {
        return hash_hmac('sha256', $data, $secret);
    }

    public static function hmac_check($secret, $data, $provided) {
        return self::hmac_gen($secret, $data) == $provided;
    }

	public static function get_rand_token() {
		return sha1(microtime(1) . rand(1, 10000) . '%3m9*cK)=z2');
	}

}