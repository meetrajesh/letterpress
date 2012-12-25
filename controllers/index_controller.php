<?php

class IndexController extends BaseController {

    public function notfound_404() {
        $this->_render('misc/404');
    }

    public function index() {

		// check if we know who this user is
		if (false === $token = session::get_login_token()) {
			// show login screen
			$this->_redirect('/login');
		}

		// get the player and his/her games
		$player = player::get_by_token($token);
		$games = $player->get_games();

		if (empty($games)) {
			$this->_redirect('/game/new');
		}

		$data['games'] = $games;
		$this->_render('index', $data);
    }

	public function login() {
		if (!empty($_POST['email'])) {
			$email = trim($_POST['email']);
			if (!$token = player::exists($email)) {
				$token = player::add($email);
			}
			session::set_login_token($token);
			$this->_redirect('/');
		} else {
			$this->_render('login');
		}
	}
    
}