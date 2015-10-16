<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 10:41 AM
 *
 * @var $router WpJsonApi\ResourcefulRouteCollector
 */


$router->resource("posts", 'WpJsonApi\\Http\\Controllers\\PostsController');
$router->resource("posts.comments", 'WpJsonApi\\Http\\Controllers\\CommentsController');

$router->resource("menus", 'WpJsonApi\\Http\\Controllers\\MenusController');

// maybe ditch the categories thing? not sure
$router->resource("categories", 'WpJsonApi\\Http\\Controllers\\CategoriesController');
$router->resource("taxonomies", 'WpJsonApi\\Http\\Controllers\\TaxonomiesController');

$router->resource("users", 'WpJsonApi\\Http\\Controllers\\UsersController');