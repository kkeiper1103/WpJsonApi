<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 8:52 AM
 */

namespace WpJsonApi\Transformers;


use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Phroute\Phroute\RouteCollector;

class CommentTransformer extends TransformerAbstract
{
    /**
     * @var RouteCollector
     */
    private $router;

    /**
     * @param RouteCollector $router
     */
    public function __construct(RouteCollector $router) {

        $this->router = $router;
    }

    /**
     * @param $comment
     * @return mixed|void
     */
    public function transform( $comment ) {

        $schema = apply_filters("wp-json.transform.comments", [

            "type" => "comments",
            "id" => (int) $comment->comment_ID,

            "attributes" => [
                "date" => Carbon::parse($comment->comment_date)->toIso8601String(),
                "content" => $comment->comment_content,
                "karma" => (float) $comment->comment_karma,
                "approved" => (boolean) $comment->comment_approved,
                "agent" => $comment->comment_agent,
                "type" => $comment->comment_type,
                "ip_address" => $comment->comment_author_IP
            ],

            "links" => [
                "self" => get_home_url(null, $this->router->route("posts.comments.show",
                    [$comment->comment_post_ID, $comment->comment_ID]))
            ],

            "relationships" => [
                "posts" => [
                    "links" => [
                        "self" => get_home_url(null, $this->router->route("posts.show", [$comment->comment_post_ID]))
                    ]
                ]
            ]

        ]);

        return $schema;
    }
}