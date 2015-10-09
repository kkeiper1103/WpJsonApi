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


$router->get("/api/posts", 'WpJsonApi\Http\Controllers\PostController::all');
$router->get("/api/posts/{id}", 'WpJsonApi\Http\Controllers\PostController::find');

$router->get("/api/posts/{id}/comments", 'WpJsonApi\Http\Controllers\CommentController::all');
$router->get("/api/posts/{post_id}/comments/{comment_id}", 'WpJsonApi\Http\Controllers\CommentController::find');
$router->get("/api/comments/{comment_id}", 'WpJsonApi\Http\Controllers\CommentController::find');