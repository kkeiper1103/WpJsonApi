<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 1:29 PM
 */

namespace WpJsonApi\Http\Controllers;


class MenusController
{

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

        //
        return $query->get_posts();
    }

}