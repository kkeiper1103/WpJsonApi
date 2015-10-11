<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 4:14 PM
 */

namespace WpJsonApi\Http\Controllers;


use League\Fractal\Manager;
use WpJsonApi\Traits\LoadsUsers;
use League\Fractal\Resource\Item;
use League\Route\Http\JsonResponse;
use League\Fractal\Resource\Collection;
use WpJsonApi\Transformers\UserTransformer;
use Symfony\Component\HttpFoundation\Request;

class UserController
{
    use LoadsUsers;

    /**
     * @var Manager
     */
    protected $fractal;

    /**
     * @param Manager $fractal
     */
    public function __construct(Manager $fractal) {
        $this->fractal = $fractal;
    }

    /**
     * @param Request $request
     * @param array $params
     * @return JsonResponse\Ok
     */
    public function all( Request $request, array $params ) {
        $users = new Collection($this->getUsers(), new UserTransformer, "users");

        return new JsonResponse\Ok( $this->fractal->createData($users)->toArray() );
    }

    /**
     * @param Request $request
     * @param array $params
     * @return JsonResponse\Ok
     */
    public function find( Request $request, array $params ) {
        $user = new Item($this->getUser($params["id"]), new UserTransformer, "users");

        return new JsonResponse\Ok( $this->fractal->createData($user)->toArray() );
    }

    /**
     * @param Request $request
     * @param array $params
     * @return JsonResponse\Ok
     */
    public function findByPost( Request $request, array $params ) {

        /**
         * @var $post \WP_Post
         */
        $post = get_post($params["id"]);

        return $this->find($request, ["id" => $post->post_author]);
    }
}