<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 11:54 AM
 */

namespace WpJsonApi\Actions;


interface ActionInterface
{
    /**
     * Hook code to be run
     *
     * @return mixed
     */
    public function __invoke();
}