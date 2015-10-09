<?php

/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/8/2015
 * Time: 3:43 PM
 *
 *
 * @var $router \League\Route\RouteCollection
 */


$router->get("/api/posts", 'WpJsonApi\Http\Controllers\PostController::getIndex');
$router->get("/api/posts/{id}", 'WpJsonApi\Http\Controllers\PostController::find');

