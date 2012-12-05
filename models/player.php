<?php

class player {

	private $id, $token, $email;

	public function __construct($player) {
		foreach ($player as $key => $val) {
			$this->$key = $val;
		}
	}

	public function get_games() {

		$games = array();
		$game_ids = db::fetch_all('SELECT id FROM games WHERE player1_id=%d OR player2_id=%1$d', $this->id);
		foreach ($game_ids as $game_id) {
			$games[] = new game($game_id);
		}
		return $games;
	}

	public static function exists($email) {
		return db::result('SELECT token FROM players WHERE email="%s"', $email);
	}

	public static function get($token) {
		$player = db::fetch_all('SELECT id, email, token FROM players WHERE token="%s"', $token);
		return new player($player);
	}

	public static function add($email) {
		$token = security::get_rand_token();
		db::query('INSERT INTO players SET email="%s", token="%s"', $email, $token);
		return $token;
	}

}