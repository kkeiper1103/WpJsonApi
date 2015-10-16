<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/16/2015
 * Time: 8:40 AM
 */

namespace WpJsonApi\Transformers;


use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * @param $category
     * @return mixed|void
     */
    public function transform( $category ) {

        $schema = apply_filters("wp-json.transform.categories", [
            "id" => (int) $category->term_id,
            'name' => $category->name,
            'slug' => $category->slug,
            'term_group' => $category->term_group,
            'term_taxonomy_id' => (int) $category->term_taxonomy_id,
            'taxonomy' => $category->taxonomy,
            'description' => $category->description,
            'parent' => (int) $category->parent,
            'count' => (int) $category->count
        ], $category);

        return $schema;
    }
}