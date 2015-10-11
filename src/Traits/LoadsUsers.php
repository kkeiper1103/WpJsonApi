<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 9:37 AM
 */

namespace WpJsonApi\Traits;


trait LoadsUsers
{
    /**
     *
     */
    public function getUsers() {
        return get_users();
    }

    /**
     * @param $id
     * @return false|\WP_User
     */
    public function getUser( $id ) {
        return get_user_by("id", $id);
    }
}