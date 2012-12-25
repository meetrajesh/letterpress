<?php

class player extends model_base {

	public $id, $token, $email;

	public static function get($id) {
		return self::_assign_db_row_to_obj(new player, 'players', $id);
	}

	public static function get_by_token($token) {
		return self::_assign_db_row_to_obj(new player, 'players', $token, 'token');
	}

	public static function get_by_email($email) {
		return self::_assign_db_row_to_obj(new player, 'players', $email, 'email');
	}

	public static function get_current() {
		return self::get_by_token(session::get_login_token());
	}

	public function get_games() {
		$games = array();
		$game_ids = db::fetch_all('SELECT id FROM games WHERE (player1_id=%d OR player2_id=%1$d) AND player1_id*player2_id != 0', $this->id);
		foreach ($game_ids as $game) {
			$games[] = game::get($game['id']);
		}
		return $games;
	}

	public static function exists($email) {
		return db::result('SELECT token FROM players WHERE email="%s"', $email);
	}

	public static function add($email) {
		$token = self::exists($email);
		if (!$token) {
			$token = security::get_rand_token();
			db::query('INSERT INTO players (email, token, created_at) VALUES ("%s", "%s", NOW())', $email, $token);
		}
		return $token;
	}

}