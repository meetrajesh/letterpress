<?php

class game extends model_base {

	public $id;
	public $player1_id;
	public $player2_id;
	public $letters;

	public static function get($id) {
		return self::_assign_db_row_to_obj(new game, 'games', $id);
	}

	public static function create(player $player) {
		$letters = range('A', 'Z');
        foreach (range(0,24) as $i) {
            $table[$i] = array_rand_value($letters);
        }

		db::query('INSERT INTO games (player1_id, letters) VALUES (%d, "%s")', $player->id, implode(',', $table));
        return self::get(db::insert_id());
	}

	public function get_table() {
		return explode(',', $this->letters);
	}

}