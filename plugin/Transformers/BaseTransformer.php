<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 9:51 AM
 */

namespace WpJsonApi\Transformers;


use League\Fractal\TransformerAbstract;
use WpJsonApi\Traits\LoadsComments;
use WpJsonApi\Traits\LoadsPosts;
use WpJsonApi\Traits\LoadsUsers;

abstract class BaseTransformer extends TransformerAbstract
{
    use LoadsUsers, LoadsPosts, LoadsComments;


}