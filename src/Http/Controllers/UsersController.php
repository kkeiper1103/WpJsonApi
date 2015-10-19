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
use Symfony\Component\HttpFoundation\Request;
use WpJsonApi\Exceptions\MethodNotImplementedException;
use WpJsonApi\Transformers\UserTransformer;

class UsersController implements RestfulInterface
{
    /**
     * @var UserTransformer
     */
    private $transformer;
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     * @param UserTransformer $transformer
     */
    public function __construct( Request $request, UserTransformer $transformer ) {

        $this->transformer = $transformer;
        $this->request = $request;
    }

    /**
     * @return Collection
     */
    public function index()
    {
        $defaults = [
            // 'who' => 'authors'
        ];

        $args = array_merge($defaults, $this->request->query->all());


        $users = get_users( $args );

        return new Collection($users, $this->transformer, "users");
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

        return new Item($user, $this->transformer, "users");
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