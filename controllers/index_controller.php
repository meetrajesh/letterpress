<?php

class IndexController extends BaseController {

    public static function route() {

        $regex = '/^' . preg_quote(PATH_PREFIX, '/') . '/';
        $uri = preg_replace($regex, '', $_SERVER['REQUEST_URI']);
        $uri = strtolower($uri);

        $routes = array('/$' => array('index', 'index'), // empty route, just root domain
                        '/login' => array('index', 'login'),
                        '/404' => array('index', 'misc_page', array('404')),
                        );

        foreach ($routes as $route => $dest) {
			$dest = array_pad($dest, 3, array());
            if (preg_match("#^${route}#", $uri, $match)) {
                list($controller, $action, $args) = $dest;
                $route_match = array_shift($match);

                // grab any regex matches if they exist
                if (!empty($match)) {
                    $args = array_merge($args, $match);
                }

                // parse the rest of the uri for additional args
                if (!empty($args)) {
                    $uri = str_replace($route_match, '', $uri);
                }
                $uri = trim($uri, '/');
                if (!empty($uri)) {
                    $args = array_merge($args, explode('/', $uri));
                }
                break;
            }
        }

        #v($controller, $action, $args); exit;

        // 404
        if (empty($controller)) {
            list($controller, $action, $args) = array('index', 'notfound_404', array());
        }

        $class = ucwords($controller) . 'Controller';
        $obj = new $class;
        $obj->$action($args);

    }

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
		$player = player::get($token);
		$games = $player->get_games();

		if (empty($games)) {
			// initialize game
			$data['table'] = game::create($player);
			$this->_render('index', $data);
		}
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