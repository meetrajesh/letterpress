<?php

class GameController extends BaseController {

	public function new_game($args) {
		$gid = isset($args[0]) ? $args[0] : 0;
		$player1 = player::get_current();

		// initialize new game
		$game = empty($gid) ? game::create($player1) : game::get($gid);

		$data['games'][0] = $game;
		$data['form_action'] = $this->_url(spf('/game/start/%d', $game->id));
		$this->_render('index', $data);
	}

	public function start($args) {
		$gid = isset($args[0]) ? $args[0] : 0;
		$player1 = player::get_current();
		$game = empty($gid) ? $this->_redirect('/game/new') : game::get($gid);
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

		if (empty($_POST['coords'])) {
			$this->_set_flash('error', 'Please choose some letters to form a word');
		} elseif (!$game->is_valid_word($_POST['coords'])) {
			$this->_set_flash('error', 'Invalid word');
		}

		// if an error occurred
		if ($this->_has_flash('error')) {
			$this->_redirect('/game/play/' . $gid);
		}

		// no errors
		$game->make_move($_POST['coords']);



	}

	public function play($args) {
		$gid = isset($args[0]) ? $args[0] : 0;
		$data['form_action'] = $this->_url('/game/move');
		$data['game'] = game::get($gid);
		$this->_render('show', $data);
	}

}