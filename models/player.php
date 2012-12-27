<?php

class player extends model_base {

	public $id, $token, $email;
	public static $_current_player = null;

	public static function get($id) {
		return self::_assign_db_row_to_obj(new player, 'players', $id);
	}

	public static function get_by_token($token) {
		return self::_assign_db_row_to_obj(new player, 'players', $token, 'token');
	}

	public static function get_by_email($email) {
		return self::_assign_db_row_to_obj(new player, 'players', $email, 'email');
	}

	public static function set_current($token) {
		$player = player::get_by_token($token);
		if (!empty($player->id)) {
			self::$_current_player = $player;
			return true;
		}
		return false;
	}

	public static function get_current() {
		return self::$_current_player;
	}

	public function get_games() {
		$games = array();
		$game_ids = db::fetch_all('SELECT id FROM games WHERE is_deleted=0 AND (player1_id=%d OR player2_id=%1$d) AND player1_id*player2_id != 0 ORDER BY id DESC', $this->id);
		foreach ($game_ids as $game) {
			$games[] = game::get($game['id']);
		}
		return game::sort($games);
	}

	public static function exists($email) {
		return db::result('SELECT token FROM players WHERE email="%s"', $email);
	}

	public static function add($email) {
		$token = self::exists($email);
		if (!$token) {
			$token = security::get_rand_token();
			db::query('INSERT INTO players (email, token, created_at) VALUES ("%s", "%s", now())', $email, $token);
		}
		return $token;
	}

}