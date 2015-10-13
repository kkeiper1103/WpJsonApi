<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 1:29 PM
 */

namespace WpJsonApi\Http\Controllers;


use League\Fractal\Resource\Collection;
use WpJsonApi\Transformers\PostTransformer;

class PostsController
{
    /**
     * @param null $id
     * @return Collection
     */
    public function getIndex( $id = null ) {
        /**
         *
         */
        if( !is_null($id) ) {
            $query = new \WP_Query([
                "posts_per_page" => -1,
                "p" => $id
            ]);
        }
        else {
            $query = new \WP_Query([
                "posts_per_page" => 10
            ]);
        }

        $posts = $query->get_posts();

        return new Collection($posts, new PostTransformer, "posts");
    }

}