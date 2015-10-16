<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 2:06 PM
 */

namespace WpJsonApi\Transformers;


use Carbon\Carbon;
use WP_Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
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
                "date" => Carbon::parse($post->post_date)->toIso8601String(),
                "content" => apply_filters("the_content", $post->post_content),
                "title" => apply_filters("the_title", $post->post_title),
                "excerpt" => $post->post_excerpt,
                "status" => $post->post_status,
                "comment_status" => $post->comment_status,
                "slug" => $post->post_name,
                "guid" => $post->guid
            ]
        ], $post);

        return $schema;
    }
}