<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 12:46 PM
 */

namespace WpJsonApi\Filters;


interface FilterInterface
{
    /**
     * @return mixed
     */
    public function __invoke();
}