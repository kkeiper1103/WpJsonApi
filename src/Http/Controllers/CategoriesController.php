<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 1:29 PM
 */

namespace WpJsonApi\Http\Controllers;


use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use WpJsonApi\Exceptions\MethodNotImplementedException;
use WpJsonApi\Transformers\CategoryTransformer;

class CategoriesController implements RestfulInterface
{
    /**
     * @return Collection
     */
    public function index()
    {
        $categories = get_categories();

        return new Collection($categories, new CategoryTransformer, "categories");
    }

    /**
     * @throws MethodNotImplementedException
     */
    public function store()
    {
        throw new MethodNotImplementedException(__FUNCTION__);
    }

    /**
     * @param $id
     * @return Item
     */
    public function show($id)
    {
        $category = get_category( (int) $id );

        return new Item($category, new CategoryTransformer, "categories");
    }

    /**
     * @param $id
     * @throws MethodNotImplementedException
     */
    public function update($id)
    {
        throw new MethodNotImplementedException(__FUNCTION__);
    }

    /**
     * @param $id
     * @throws MethodNotImplementedException
     */
    public function destroy($id)
    {
        throw new MethodNotImplementedException(__FUNCTION__);
    }
}