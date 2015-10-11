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

return [
    // posts / post-types routes
    "/api/posts" => 'WpJsonApi\Http\Controllers\PostController::all',
    "/api/posts/{id}" => 'WpJsonApi\Http\Controllers\PostController::find',

    // comments routes
    "/api/posts/{id}/comments" => 'WpJsonApi\Http\Controllers\CommentController::all',
    "/api/posts/{post_id}/comments/{comment_id}" => 'WpJsonApi\Http\Controllers\CommentController::find',
    "/api/comments/{comment_id}" => 'WpJsonApi\Http\Controllers\CommentController::find',

    // user info routes
    "/api/users" => 'WpJsonApi\Http\Controllers\UserController::all',
    "/api/users/{id}" => 'WpJsonApi\Http\Controllers\UserController::find',
    "/api/posts/{id}/author" => 'WpJsonApi\Http\Controllers\UserController::findByPost',
];