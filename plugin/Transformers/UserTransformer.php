<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 8:50 AM
 */

namespace WpJsonApi\Transformers;



use Carbon\Carbon;
use WP_User;

class UserTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        "posts",
        "comments",
    ];

    /**
     * @param WP_User $user
     *
     * @return mixed|void
     */
    public function transform(WP_User $user) {
        $schema = apply_filters("wp-json.transform.users", [
            "id" => $user->ID,
            "username" => $user->data->user_nicename,
            "login" => $user->data->user_login,
            "display_name" => $user->data->display_name,
            "email" => $user->data->user_email,
            "url" => $user->data->user_url,
            "registered" => Carbon::parse($user->data->user_registered)->toIso8601String(),
            "status" => $user->data->user_status,

            "capabilities" => array_merge($user->caps, $user->allcaps),
            "roles" => $user->roles
        ]);

        return $schema;
    }

    /**
     * @param $user
     * @return \League\Fractal\Resource\Collection
     */
    public function includePosts( WP_User $user ) {
        $posts = $this->getPostsByUser( $user );

        return $this->collection($posts, new PostTransformer);
    }

    /**
     * @param $user
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComments( WP_User $user ) {
        $comments = $this->getCommentsByUser($user);

        return $this->collection($comments, new CommentTransformer);
    }
}