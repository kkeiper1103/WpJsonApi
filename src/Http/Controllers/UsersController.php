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
use WpJsonApi\Transformers\UserTransformer;

class UsersController implements RestfulInterface
{

    /**
     * @return Collection
     */
    public function index()
    {
        $users = get_users();

        return new Collection($users, new UserTransformer, "users");
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
        $user = get_user_by("id", (int) $id);

        return new Item($user, new UserTransformer, "users");
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