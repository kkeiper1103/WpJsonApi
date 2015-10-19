<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/16/2015
 * Time: 8:40 AM
 */

namespace WpJsonApi\Transformers;


use League\Fractal\TransformerAbstract;
use Phroute\Phroute\RouteCollector;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * @var RouteCollector
     */
    private $router;

    /**
     * @param RouteCollector $router
     */
    public function __construct(RouteCollector $router) {

        $this->router = $router;
    }

    /**
     * @param $category
     * @return mixed|void
     */
    public function transform( $category ) {

        $schema = apply_filters("wp-json.transform.categories", [

            "type" => "categories",
            "id" => (int) $category->term_id,

            "attributes" => [
                'name' => $category->name,
                'slug' => $category->slug,
                'term_group' => $category->term_group,
                'term_taxonomy_id' => (int) $category->term_taxonomy_id,
                'taxonomy' => $category->taxonomy,
                'description' => $category->description,
                'parent' => (int) $category->parent,
                'count' => (int) $category->count
            ],

            "links" => [
                "self" => get_home_url(null, $this->router->route("categories.show", [$category->term_id]))
            ],

            "relationships" => [
                "posts" => [
                    "self" => get_home_url(null, $this->router->route("posts.index")) . "?category={$category->term_id}"
                ]
            ]

        ], $category);

        return $schema;
    }
}