<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'index', 'action' => 'index', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
//	Router::connect('/top/*', array('controller' => 'index', 'action' => 'display'));


$dir = strtolower(Configure::read('Cache.dir'));

Router::connect('/user/stylist/*', ['controller' => 'stylist', 'action' => 'index']);
Router::connect('/stylist/user/*', ['controller' => 'user', 'action' => 'index']);

if (in_array($dir, ['admin','user', 'stylist', 'json'])) {
    Router::connect("/{$dir}/:controller", ['action' => 'index']);
    Router::connect("/{$dir}/:controller/", ['action' => 'index']);
    Router::connect("/{$dir}/:controller/:action/*");
}

Router::connect("/terms/*", ['controller' => 'index', 'action' => 'terms']);

Router::connect("/:action", ['controller' => 'index']);
Router::connect("/:controller/:action");
Router::connect("/:controller/:action/*");


/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
//	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
//	require CAKE . 'Config' . DS . 'routes.php';
