<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 9:37 AM
 */

namespace WpJsonApi\Traits;


use stdClass;
use WP_Post;
use WP_User;

trait LoadsComments
{
    /**
     * @param $id
     * @return array|null|object
     */
    public function getComment( $id ) {
        return get_comment($id);
    }

    /**
     * @param $post int|WP_Post
     * @return array|int
     */
    public function getCommentsByPost( $post ) {
        $post_id = $post;

        if( $post instanceof WP_Post )
            $post_id = $post->ID;

        return get_comments([
            "post_id" => $post_id
        ]);
    }

    /**
     * @param $user int|WP_User
     * @return array|int
     */
    public function getCommentsByUser( $user ) {
        $user_id = $user;

        if( $user instanceof WP_User )
            $user_id = $user->ID;

        return get_comments([
            "post_author" => $user_id
        ]);
    }

    /**
     * @param $comment int|stdClass
     * @return array|int
     */
    public function getChildComments( $comment ) {
        $comment_id = $comment;

        if( $comment instanceof stdClass )
            $comment_id = $comment->comment_ID;

        return get_comments([
            "parent" => $comment_id
        ]);
    }
}