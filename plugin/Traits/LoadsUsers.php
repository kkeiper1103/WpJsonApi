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
    public function getUser( $id ) {
        return get_user_by("id", $id);
    }
}