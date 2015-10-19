<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/16/2015
 * Time: 11:16 AM
 */

namespace WpJsonApi\Transformers;


use League\Fractal\TransformerAbstract;

class MenuTransformer extends TransformerAbstract
{
    public function transform( $menu ) {
        $schema = apply_filters("wp-json.transform.menus", [

            "type" => "menus",
            "id" => (int) $menu->term_id,

            "attributes" => [
                "name" => $menu->name,
                "slug" => $menu->slug,
                "taxonomy" => $menu->taxonomy,
                "parent" => (int) $menu->parent,
                "count" => (int) $menu->count,
                "description" => $menu->description
            ]

        ], $menu);

        return $schema;
    }
}