<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 8:34 AM
 */

namespace WpJsonApi\Transformers;


use Carbon\Carbon;
use WP_Post;

class PostTransformer extends BaseTransformer
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        "author",
        "comments",
        "parent"
    ];

    /**
     * @param WP_Post $post
     * @return mixed|void
     */
    public function transform( WP_Post $post ) {

        /**
         * Allow user defined schema additions / deletions
         */
        $schema = apply_filters("wp-json.transform.posts", [
            "id" => $post->ID,

            "date" => Carbon::parse($post->post_date)->toIso8601String(),

            "content" => apply_filters("the_content", $post->post_content),

            "title" => apply_filters("the_title", $post->post_title),

            "excerpt" => $post->post_excerpt,

            "status" => $post->post_status,

            "comment_status" => $post->comment_status,

            "slug" => $post->post_name,

            "guid" => $post->guid
        ]);

        return $schema;
    }

    /**
     * @param WP_Post $post
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthor( WP_Post $post ) {
        $user = $this->getUser( $post->post_author );

        return $this->item($user, new UserTransformer);
    }

    /**
     * @param WP_Post $post
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComments( WP_Post $post ) {
        $comments = $this->getCommentsByPost($post->ID);

        return $this->collection($comments, new CommentTransformer);
    }

    /**
     * @param WP_Post $post
     * @return \League\Fractal\Resource\Item
     */
    public function includeParent( WP_Post $post ) {
        $parent = $this->getPost((int) $post->post_parent);

        return $this->item($parent, new PostTransformer);
    }
}