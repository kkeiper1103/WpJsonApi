<?php
/**
 * Created by PhpStorm.
 * User: kkeiper
 * Date: 10/10/15
 * Time: 9:24 AM
 */

namespace WpJsonApi\Pages;


interface PageInterface
{
    public function data();
    public function render();
}