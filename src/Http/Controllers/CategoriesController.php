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
     * @var CategoryTransformer
     */
    private $transformer;

    /**
     * @param CategoryTransformer $transformer
     */
    public function __construct( CategoryTransformer $transformer ) {

        $this->transformer = $transformer;
    }

    /**
     * @return Collection
     */
    public function index()
    {
        $categories = get_categories();

        return new Collection($categories, $this->transformer, "categories");
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

        return new Item($category, $this->transformer, "categories");
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