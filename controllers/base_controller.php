<?php

class BaseController {

	protected $_errors = array();
	protected $_msgs = array();
	protected $_stylesheets = array();
	protected $_scripts = array();
	protected $_tpl;

	protected function __construct() {
		$this->_tpl = new template();

		// remove cookies from $_REQUEST
		$_REQUEST = array_diff_key($_REQUEST, $_COOKIE);
		if (!empty($_POST) || !empty($_GET) || !empty($_REQUEST)) {
			csrf::check();
		}
	}

	public static function route($routes) {

		$regex = '/^' . preg_quote(PATH_PREFIX, '/') . '/';
		$uri = preg_replace($regex, '', $_SERVER['REQUEST_URI']);
		$uri = strtolower($uri);

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
				$uri = str_replace($route_match, '', $uri);
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
		$obj->_before_render(array($controller, $action));
		$obj->$action($args);

	}

	protected function _render($tmpl, $data=array()) {
		$t = $this->_tpl;
		require './views/' . $tmpl . '.php';
	}

	public function _render_partial($partial, $data=array()) {
		require './views/' . $partial . '.php';
	}

	protected function _buffer($tmpl, $data=array()) {
		$t = $this->_tpl;
		ob_start();
		$this->_render($tmpl, $data);
		return ob_get_clean();
	}

	protected function _add_css($files) {
		foreach ((array) $files as $file) {
			$path = STATIC_PREFIX . '/' . $file;
			array_unshift($this->_stylesheets, $path);
		}
	}

	protected function _add_js($files) {
		foreach ((array) $files as $file) {
			$path = STATIC_PREFIX . '/' . $file;
			array_unshift($this->_scripts, $path);
		}
	}

	protected function _display_errors($escape_html=true) {
		foreach ($this->_errors as $error) {
			$error = $escape_html ? hsc($error) : $error;
			echo '<span style="color: maroon;">' . hsc($error) . '</span><br/>';
		}
	}

	protected function _display_msgs($escape_html=true) {
		foreach ($this->_msgs as $msg) {
			$msg = $escape_html ? hsc($msg) : $msg;
			echo '<span style="color: teal;">' . $msg . '</span><br/>';
		}
	}

	protected function _redirect($path) {
		if (preg_match('/^https?:/', $path)) {
			header('Location: ' . $path);
		} else {
			header('Location: ' . BASE_URL . PATH_PREFIX . $path);
		}
		exit;
	}

	protected function _url($path) {
		return spf('%s/%s', rtrim(PATH_PREFIX, '/'), ltrim($path, '/'));
	}

	protected function _get_view_data($data) {
		$view_data = array();
		$optional_keys = array();
		// tack on the optional keys if they exist
		foreach ($optional_keys as $optional_key) {
			if (isset($data[$optional_key])) {
				$view_data[$optional_key] = $data[$optional_key];
			}
		}
		return $view_data;
	}

	protected function _set_flash($key, $val) {
		$_SESSION['flash'][$key] = $val;
	}

	protected function _get_flash($key) {
		$flash = $_SESSION['flash'][$key];
		unset($_SESSION['flash'][$key]);
		return $flash;
	}

	protected function _has_flash($key) {
		return isset($_SESSION['flash'][$key]);
	}

	protected function _before_render($action) {
		$this->_add_js('js/game.js');
		$this->_add_css('css/main.css');
		$this->_add_css('css/normalize.css');

		$this->_attempt_login($action);
	}

	private function _attempt_login($action) {
		// check if we know who this user is
		if (false !== $token = session::get_login_token()) {
			if (player::set_current($token)) {
				return true;
			}
		}
		if ($action !== array('index', 'login')) {
			// show login screen
			$this->_redirect('/login');
		}
	}

}