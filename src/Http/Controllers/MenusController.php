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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WpJsonApi\Exceptions\MethodNotImplementedException;
use WpJsonApi\Transformers\MenuTransformer;
use WpJsonApi\Transformers\MenuWithItemsTransformers;

class MenusController implements RestfulInterface
{
    /**
     * @return Collection
     */
    public function index()
    {
        $menus = wp_get_nav_menus();

        return new Collection($menus, new MenuTransformer, "menus");
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
     * @return Item|JsonResponse
     */
    public function show($id)
    {
        $menu = wp_get_nav_menu_object( (int) $id );


        if( $menu === false ) {
            return new JsonResponse([], Response::HTTP_NOT_FOUND);
        }


        return new Item($menu, new MenuWithItemsTransformers, "menus");
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