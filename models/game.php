<?php

class game extends model_base {

	public $id;
	public $player1_id, $player1, $player1_tiles, $player1_locked_tiles;
	public $player2_id, $player2, $player2_tiles, $player2_locked_tiles;
	public $letters;

	public static function get($id) {
		$game = self::_assign_db_row_to_obj(new game, 'games', $id);
		$game->letters = myexplode(',', $game->letters);

		$game->player1 = player::get($game->player1_id);
		$game->player2 = player::get($game->player2_id);

		$game->player1_tiles = myexplode(',', $game->player1_tiles);
		$game->player2_tiles = myexplode(',', $game->player2_tiles);

		$game->_find_locked_tiles();
		return $game;
	}

	private function _find_locked_tiles() {

		foreach (range(1,2) as $i) {
			$var = spf('player%d_tiles', $i);
			$tiles = $this->$var;
			$locked_tiles = array();
			foreach ($tiles as $tile) {
				$neighbor_tiles = $this->_neighbor_tiles($tile);
				foreach ($neighbor_tiles as $neighbor_tile) {
					if (!in_array($neighbor_tile, $tiles)) {
						continue 2;
					}
				}
				$locked_tiles[] = $tile;
			}
			$var = spf('player%d_locked_tiles', $i);
			$this->$var = $locked_tiles;
		}

	}

	private function _neighbor_tiles($tile) {

		$neighbors = array();
		$n = 5;

		// not a left tile
		if ($tile % $n != 0) {
			$neighbors[] = $tile - 1;
		}

		// not a right tile
		if (($tile+1) % $n != 0) {
			$neighbors[] = $tile + 1;
		}

		// not a top-row tile
		if ($tile >= $n) {
			$neighbors[] = $tile - $n;
		}

		// not a bottom-row tile
		if ($tile < ($n*$n-5)) {
			$neighbors[] = $tile + $n;
		}
		
		return $neighbors;
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
		$coords = myexplode(',', $coords);
		$word = $this->_get_word_from_coords($coords);
		if (true !== $error = $this->_validate_word($word)) {
			return $error;
		}

		$this->_determine_new_tile_owners($coords);

		// save new tile owners
		db::query('UPDATE games SET player1_tiles="%s" WHERE id=%d', implode(',', $this->player1_tiles), $this->id);
		db::query('UPDATE games SET player2_tiles="%s" WHERE id=%d', implode(',', $this->player2_tiles), $this->id);

		// save word in db
		#db::query('INSERT INTO words_played (game_id, word) VALUES (%d, "%s")', $this->id, $word);
	}

	private function _determine_new_tile_owners($coords) {
		$new_coords = array_diff($coords, $this->player2_locked_tiles);
		$this->player1_tiles = array_merge($this->player1_tiles, $new_coords);
		$this->player2_tiles = array_diff($this->player2_tiles, $new_coords);
		$this->_find_locked_tiles();
	}

	private function _get_word_from_coords($coords) {
		$word = '';
		foreach ($coords as $coord) {
			$word .= $this->letters[$coord];
		}
		return $word;
	}

	private function _is_word_played($word) {
		// mysql LIKE is case insensitive
		return db::has_row('SELECT null FROM words_played WHERE game_id=%d AND word LIKE "%%%s%%"', $this->id, $word);
	}

	private function _is_valid_word_length($word) {
		return !empty($word) && strlen($word) > 1;
	}

	private function _is_valid_word($word) {
		$cmd = spf('grep -iP "^%s$" /usr/share/dict/words', $word);
		$result = shell_exec($cmd);
		return !empty($result);
	}

	private function _validate_word($word) {
		if (empty($word)) {
			return 'Please choose some letters to form a word';
		} elseif (!$this->_is_valid_word_length($word)) {
			return 'Your word must be at least 2 letters long';
		} elseif (!$this->_is_valid_word($word)) {
			return 'Sorry, your word could not be found in the Letterpress dictionary';
		} elseif ($this->_is_word_played($word)) {
			return 'Sorry, you\'ve already played this word or a word containing it before';
		}

		return true;
	}



}