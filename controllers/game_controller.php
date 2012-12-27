<?php

class GameController extends BaseController {

	public function new_game($args) {
		$gid = isset($args[0]) ? $args[0] : 0;
		$player1 = player::get_current();

		// initialize new game
		$game = empty($gid) ? game::create($player1) : game::get($gid);

		$data['games'][0] = $game;
		$this->_render('index', $data);
	}

	public function start($args) {
		$gid = isset($args[0]) ? $args[0] : 0;
		$game = empty($gid) ? $this->_redirect('/game/new') : game::get($gid);
		$player1 = player::get_current();
		$player2_email = isset($_POST['player2_email']) ? $_POST['player2_email'] : '';

		if (empty($player2_email)) {
			$this->_set_flash('error', 'Please enter your friend\'s email address to start a new game with them');
		} elseif (!is_valid_email($player2_email)) {
			$this->_set_flash('error', 'Please enter a valid email address');
		} elseif ($player2_email == $player1->email) {
			$this->_set_flash('error', 'You can\'t start a game with yourself! Please enter another email');
		} elseif (!$game->set_player_2($player2_email)) {
			$this->_set_flash('error', 'Couldn\'t save your partner\'s email address in the db');
		} 

		// if an error occurred
		if ($this->_has_flash('error')) {
			$this->_redirect('/game/new/' . $gid);
		}

		$this->move($args);
	}

	public function show($args) {
		$gid = isset($args[0]) ? $args[0] : 0;
		$data['game'] = game::get($gid);
		if (empty($data['game']->id)) {
			$this->_redirect('/');
		}
		$this->_render('show', $data);
	}

	public function move($args) {
		$gid = isset($args[0]) ? $args[0] : 0;
		$game = empty($gid) ? $this->_redirect('/game/new') : game::get($gid);
		$player1 = player::get_current();
		$player2 = $game->player2;
		$coords = !empty($_POST['coords']) ? trim($_POST['coords']) : '';

		if (true !== $error = $game->make_move($coords)) {
			$this->_set_flash('error', $error);
			$this->_redirect('/game/show/' . $gid);
		}

		// no errors
		$this->_redirect('/');
	}

	public function delete($args) {
		$gid = isset($args[0]) ? $args[0] : 0;
		$game = game::get($gid);
		if ($game && $game->id) {
			csrf::check();
			if (in_array(player::get_current()->id, array($game->player1_id, $game->player2_id))) {
				$game->delete();
			}
		}
		$this->_redirect('/');
	}
}