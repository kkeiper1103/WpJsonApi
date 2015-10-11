<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 9:37 AM
 */

namespace WpJsonApi\Traits;


use stdClass;
use WP_User;

trait LoadsPosts
{
    /**
     * @param $post_id
     * @return array|null|\WP_Post
     */
    public function getPost( $post_id ) {
        return get_post( $post_id );
    }

    /**
     * @param $user int|WP_User
     * @return array
     */
    public function getPostsByUser( $user ) {
        if( $user instanceof WP_User ) {
            $user = $user->ID;
        }

        return get_posts([
            "numberposts" => -1,
            "author" => $user
        ]);
    }

    /**
     * @param $comment int|stdClass
     * @return array|null|\WP_Post
     */
    public function getPostByComment( $comment ) {
        $post_id = $comment;

        if( $comment instanceof StdClass ) {
            $post_id = $comment->comment_post_ID;
        }

        return $this->getPost( $post_id );
    }

    /**
     * @return array
     */
    public function getPosts() {
        return get_posts([
            "numberposts" => -1
        ]);
    }
}