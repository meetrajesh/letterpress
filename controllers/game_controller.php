<?php

class GameController extends BaseController {

	public function new_game() {
		$player = player::get_current_player();
		// initialize new game
		$data['games'][0] = game::create($player);
		$data['form_action'] = $this->_url('/game/start');
		$this->_render('index', $data);
	}

	public function start() {
		$gid = !empty($_POST['gid']) ? (int)$_POST['gid'] : 0;
		if (empty($gid)) {
			// invalid game id
			$this->redirect('/game/new');
		} elseif (empty($_POST['player2_email'])) {
			$this->_set_flash('error', 'Please enter your friend\'s email address to start a new game with them');
			$this->_redirect('/game/show/' . $gid);
		} elseif (empty($_POST['coords'])) {
			$this->_set_flash('error', 'Please enter a word');
			$this->_redirect('/game/show/' . $gid);
		}
	}

	public function show($args) {
		$gid = $args[0];
		$data['form_action'] = $this->_url('/game/move');
		$data['game'] = game::get($gid);
		$this->_render('show', $data);
	}

}