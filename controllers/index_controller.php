<?php

class IndexController extends BaseController {

    public static function route() {

        $regex = '/^' . preg_quote(PATH_PREFIX, '/') . '/';
        $uri = preg_replace($regex, '', $_SERVER['REQUEST_URI']);
        $uri = strtolower($uri);
        
        $routes = array('/$' => array('index', 'index', array()), // empty route, just root domain
                        '/404' => array('index', 'misc_page', array('404')),
                        );

        foreach ($routes as $route => $dest) {
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

        $letters = range('A', 'Z');
        foreach (range(0,24) as $i) {
            $table[$i] = array_rand_value($letters);
        }

        $data['table'] = $table;
        $this->_render('index', $data);
    }
    
}