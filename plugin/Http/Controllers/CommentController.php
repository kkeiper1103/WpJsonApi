<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/9/2015
 * Time: 4:14 PM
 */

namespace WpJsonApi\Http\Controllers;


use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpFoundation\Request;
use WpJsonApi\Traits\LoadsComments;
use WpJsonApi\Transformers\CommentTransformer;
use League\Route\Http\JsonResponse;

class CommentController
{
    use LoadsComments;

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
     * @return Response
     */
    public function all(Request $request, array $params) {
        $posts = new Collection( $this->getCommentsByPost( $params['id'] ), new CommentTransformer);

        return new JsonResponse\Ok( $this->fractal->createData($posts)->toArray() );
    }

    /**
     * @param Request $request
     * @param array $params
     * @return JsonResponse\Ok
     */
    public function find( Request $request, array $params ) {
        $post = new Item( $this->getComment( $params["comment_id"] ), new CommentTransformer );

        return new JsonResponse\Ok( $this->fractal->createData($post)->toArray() );
    }
}