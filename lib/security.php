<?php

class security {

    public static function hmac_gen($secret, $data) {
        return hash_hmac('sha256', $data, $secret);
    }

    public static function hmac_check($secret, $data, $provided) {
        return self::hmac_gen($secret, $data) == $provided;
    }

    public static function gen_user_salt() {
        // salt is 3 chars long
        $salt = '';
        foreach (range(1, USER_SALT_LEN) as $i) {
            $salt .= chr(mt_rand(33, 126));
        }
        return $salt;
    }

}