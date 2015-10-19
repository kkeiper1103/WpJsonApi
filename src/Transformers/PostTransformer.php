<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 2:06 PM
 */

namespace WpJsonApi\Transformers;


use Carbon\Carbon;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;
use WP_Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * @var RouteCollector
     */
    private $router;

    /**
     * @param RouteCollector $router
     */
    public function __construct( RouteCollector $router ) {

        $this->router = $router;
    }

    /**
     * @param WP_Post $post
     * @return array
     */
    public function transform( WP_Post $post ) {

        /**
         * Allow user defined schema additions / deletions
         */
        $schema = apply_filters("wp-json.transform.posts", [
            "type" => "posts",
            "id" => $post->ID,

            "attributes" => [
                "title" => apply_filters("the_title", $post->post_title),
                "date" => Carbon::parse($post->post_date)->toIso8601String(),
            ],

            "links" => [
                "self" => get_home_url(null, $this->router->route("posts.show", [$post->ID]))
            ],

            "relationships" => [

                "comments" => [
                    "links" => [
                        "self" => get_home_url(null, $this->router->route("posts.comments.index", [$post->ID])),
                    ],
                    "data" => $this->loadComments($post->ID)
                ],

                "author" => [
                    "links" => [
                        "self" => get_home_url(null, $this->router->route("users.show", [$post->post_author]))
                    ],
                    "data" => [
                        "type" => "users",
                        "id" => $post->post_author
                    ]
                ],

                "categories" => [
                    "links" => $this->loadCategories( $post->ID )
                ]
            ]
        ], $post);

        // if the route is info page, show the extra information
        if( $this->router->isRoute("posts.show", $post->ID) ) {
            $schema["attributes"] += [
                "content" => apply_filters("the_content", $post->post_content),
                "excerpt" => $post->post_excerpt,
                "status" => $post->post_status,
                "comment_status" => $post->comment_status,
                "slug" => $post->post_name,
                "guid" => $post->guid
            ];
        }

        return $schema;
    }

    /**
     * @param $post_id
     * @return array
     */
    private function loadComments($post_id) {
        return array_map(function($comment) use($post_id){
            return [
                "type" => "comments",
                "id" => $comment->comment_ID
            ];
        }, get_comments([
            "post_id" => $post_id
        ]));
    }

    /**
     * @param $post_id
     * @return array
     */
    private function loadCategories( $post_id ) {
        return array_map(function($c){

            // load the category from the ids loaded
            $category = get_category($c);

            return [
                "title" => $category->name,
                "href" => get_home_url(null, $this->router->route("categories.show", [$category->term_id]))
            ];
        }, wp_get_post_categories( $post_id ));
    }
}