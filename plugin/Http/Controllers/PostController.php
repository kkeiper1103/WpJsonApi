<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/8/2015
 * Time: 4:22 PM
 */

namespace WpJsonApi\Http\Controllers;


use League\Fractal\Manager;
use WpJsonApi\Traits\LoadsPosts;
use League\Fractal\Resource\Item;
use League\Route\Http\JsonResponse;
use League\Fractal\Resource\Collection;
use WpJsonApi\Transformers\PostTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController
{
    use LoadsPosts;

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
     * @return Response
     */
    public function all(Request $request) {
        $posts = new Collection( $this->getPosts(), new PostTransformer);

        return new JsonResponse\Ok( $this->fractal->createData($posts)->toArray() );
    }

    /**
     * @param Request $request
     * @param array $params
     * @return JsonResponse\Ok
     */
    public function find( Request $request, array $params ) {
        $post = new Item( $this->getPost( $params["id"] ), new PostTransformer );

        return new JsonResponse\Ok( $this->fractal->createData($post)->toArray() );
    }
}