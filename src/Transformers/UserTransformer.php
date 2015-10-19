<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/16/2015
 * Time: 9:08 AM
 */

namespace WpJsonApi\Transformers;


use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Phroute\Phroute\RouteCollector;
use WP_User;
use WpJsonApi\ResourcefulRouteCollector;

class UserTransformer extends TransformerAbstract
{
    /**
     * @var RouteCollector
     */
    private $router;

    /**
     * @param ResourcefulRouteCollector $router
     */
    public function __construct( RouteCollector $router ) {

        $this->router = $router;
    }

    /**
     * @param WP_User $user
     * @return array
     */
    public function transform( WP_User $user ) {


        $schema = apply_filters("wp-json.transform.users", [

            "type" => "users",
            "id" => $user->ID,

            "attributes" => [
                "username" => $user->data->user_nicename,
            ],

            "links" => [
                "self" => get_home_url(null, $this->router->route("users.show", [$user->ID])),
                "posts" => get_home_url(null, $this->router->route("posts.index")) . "?author={$user->ID}"
            ]

        ], $user);

        // if we're on the info page, show extra information
        if( $this->router->isRoute("users.show", $user->ID) ) {
            $schema['attributes'] = $schema['attributes'] + [

                "login" => $user->data->user_login,
                "display_name" => $user->data->display_name,
                // "email" => $user->data->user_email,
                "url" => $user->data->user_url,
                "registered" => Carbon::parse($user->data->user_registered)->toIso8601String(),
                "status" => $user->data->user_status,
                "capabilities" => array_merge($user->caps, $user->allcaps),
                "roles" => $user->roles

            ];
        }

        return $schema;
    }
}