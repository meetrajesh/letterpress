<?php

class game extends model_base {

	public $id;
	public $player1_id, $player1;
	public $player2_id, $player2;
	public $letters;

	public static function get($id) {
		$game = self::_assign_db_row_to_obj(new game, 'games', $id);
		$game->letters = explode(',', $game->letters);
		$game->player1 = player::get($game->player1_id);
		$game->player2 = player::get($game->player2_id);
		return $game;
	}

	public static function create(player $player) {
		$letters = range('A', 'Z');
        foreach (range(0,24) as $i) {
            $table[$i] = array_rand_value($letters);
        }

		db::query('INSERT INTO games (player1_id, letters, created_at) VALUES (%d, "%s", NOW())', $player->id, implode(',', $table));
        return self::get(db::insert_id());
	}

	public function set_player_2($player2_email) {
		player::add($player2_email);
		$player2 = player::get_by_email($player2_email);
		db::query('UPDATE games SET player2_id=%d WHERE id=%d', $player2->id, $this->id);
		return true;
	}

	public function make_move($coords) {

	}

	public function is_valid_word($coords) {
		$word = $this->get_word_from_coords($coords);
		$cmd = spf('grep -iP "^%s$" /usr/share/dict/words', $word);
		$result = shell_exec($cmd);
		return !empty($result);
	}

	public function get_word_from_coords($coords) {
		return implode('', array_intersect_key($this->letters, array_flip(explode(',', $coords))));
	}


}