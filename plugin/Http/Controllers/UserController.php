<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 4:14 PM
 */

namespace WpJsonApi\Http\Controllers;


use League\Fractal\Manager;
use WpJsonApi\Traits\LoadsUsers;

class UserController
{
    use LoadsUsers;

    /**
     * @var Manager
     */
    protected $fractal;

    /**
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal) {
        $this->fractal = $fractal;
    }
}