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

// posts routes
$router->get("/api/posts", 'WpJsonApi\Http\Controllers\PostController::all');
$router->get("/api/posts/{id}", 'WpJsonApi\Http\Controllers\PostController::find');



// comment routes
$router->get("/api/posts/{id}/comments", 'WpJsonApi\Http\Controllers\CommentController::all');
$router->get("/api/posts/{post_id}/comments/{comment_id}", 'WpJsonApi\Http\Controllers\CommentController::find');
$router->get("/api/comments/{comment_id}", 'WpJsonApi\Http\Controllers\CommentController::find');



// author routes
$router->get("/api/users", 'WpJsonApi\Http\Controllers\UserController::all');
$router->get("/api/users/{id}", 'WpJsonApi\Http\Controllers\UserController::find');
$router->get("/api/posts/{id}/author", 'WpJsonApi\Http\Controllers\UserController::findByPost');