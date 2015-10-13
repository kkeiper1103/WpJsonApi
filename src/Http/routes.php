<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 10:41 AM
 *
 * @var $router Phroute\Phroute\RouteCollector
 */

$router->controller("menus", 'WpJsonApi\\Http\\Controllers\\MenusController');
$router->controller("posts", 'WpJsonApi\\Http\\Controllers\\PostsController');
$router->controller("categories", 'WpJsonApi\\Http\\Controllers\\CategoriesController');
$router->controller("taxonomies", 'WpJsonApi\\Http\\Controllers\\TaxonomiesController');
$router->controller("users", 'WpJsonApi\\Http\\Controllers\\UsersController');