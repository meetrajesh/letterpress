<?php

class IndexController extends BaseController {

    public function notfound_404() {
        $this->_render('misc/404');
    }

    public function index() {
		// get the player and his/her games
		$player = player::get_current();
		$games = $player->get_games();

		if (empty($games)) {
			$this->_redirect('/game/new');
		}

		$data['games'] = $games;
		$this->_render('index', $data);
    }

	public function login($args) {
		if (player::get_current()) {
			$this->_redirect('/');
		}

		$email = !empty($args[0]) ? $args[0] : '';
		$email = empty($email) && !empty($_POST['email']) ? $_POST['email'] : $email;
		$email = trim($email);

		if (!empty($email)) {
			if (!is_valid_email($email)) {
				$this->_set_flash('error', 'Please enter a valid email address');
			} else {
				if (!$token = player::exists($email)) {
					$token = player::add($email);
				}
				session::set_login_token($token);
				$this->_redirect('/');
			}
		}
		$this->_render('login');
	}
    
}