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

class CommentTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        "post",
        "author",
        "parent"
    ];

    /**
     * @param $comment
     * @return mixed|void
     */
    public function transform( $comment ) {
        $schema = apply_filters("wp-json.transform.comments", [
            "id" => (int) $comment->comment_ID,
            "date" => Carbon::parse($comment->comment_date)->toIso8601String(),
            "content" => $comment->comment_content,
            "karma" => (int) $comment->comment_karma,
            "approved" => (boolean) $comment->comment_approved,
            "agent" => $comment->comment_agent,
            "type" => $comment->comment_type,
            "ip_address" => $comment->comment_author_IP
        ]);

        return $schema;
    }

    /**
     * @param $comment
     * @return \League\Fractal\Resource\Item
     */
    public function includePost( $comment ) {
        $post = get_post( (int) $comment->comment_post_ID );

        return $this->item($post, new PostTransformer);
    }

    /**
     * @param $comment
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthor( $comment ) {
        $user = get_user_by("id", (int) $comment->comment_author );

        return $this->item($user, new UserTransformer);
    }

    /**
     * @param $comment
     * @return \League\Fractal\Resource\Item
     */
    public function includeParent( $comment ) {
        $parent = $this->getComment( (int) $comment->comment_parent );

        return $this->item($parent, new CommentTransformer);
    }

    public function includeChildren( $comment ) {
        $comments = $this->getChildComments( $comment );

        return $this->collection($comments, new CommentTransformer);
    }
}