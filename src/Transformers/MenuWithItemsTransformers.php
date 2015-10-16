<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/16/2015
 * Time: 11:57 AM
 */

namespace WpJsonApi\Transformers;


use League\Fractal\TransformerAbstract;

class MenuWithItemsTransformers extends TransformerAbstract
{

    /**
     * @param $menu
     * @return mixed|void
     */
    public function transform( $menu ) {

        $schema = apply_filters("wp-json.transform.menu", [
            "id" => (int) $menu->term_id,
            "name" => $menu->name,
            "slug" => $menu->slug,
            "taxonomy" => $menu->taxonomy,
            "parent" => (int) $menu->parent,
            "count" => (int) $menu->count,
            "description" => $menu->description,
            "items" => $this->organizeItems( wp_get_nav_menu_items((int) $menu->term_id) ),
        ], $menu);

        return $schema;
    }

    /**
     * @param $items
     * @return array
     */
    private function organizeItems( $items ) {
        $schema = [];

        // set up initial structure
        foreach($items as $i) {
            $schema[(int) $i->ID] = [
                'href' => $i->url,
                'target' => $i->target,
                'title' => $i->attr_title,
                'text' => $i->title,
                'description' => $i->description,
                'classes' => $i->classes,
                'xfn' => $i->xfn,
                'children' => [],
                'parent_item' => (int) $i->menu_item_parent
            ];
        }

        // loop through and move the child items
        foreach($schema as $id => $i) {
            if( $i['parent_item'] !== 0 ) {
                $schema[ $i['parent_item'] ]['children'][$id] = $i;
                unset( $schema[$id] );
            }
        }

        return $schema;
    }


}