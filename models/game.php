<?php

class game {

	public static function create() {
		$letters = range('A', 'Z');
        foreach (range(0,24) as $i) {
            $table[$i] = array_rand_value($letters);
        }

        return $table;
	}

}