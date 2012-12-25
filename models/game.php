<?php

class game {

	public static function create(player $player) {
		$letters = range('A', 'Z');
        foreach (range(0,24) as $i) {
            $table[$i] = array_rand_value($letters);
        }

		db::query('INSERT INTO games (player1_id, letters) VALUES (%d, "%s")', $player->id, implode(',', $table));
        return $table;
	}

}