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
use League\Fractal\Resource\ResourceAbstract;
use Symfony\Component\HttpFoundation\Request;
use WpJsonApi\Exceptions\MethodNotImplementedException;
use WpJsonApi\Managers\PostManager;
use WpJsonApi\Transformers\PostTransformer;

class PostsController
{
    /**
     * @var
     */
    protected $posts;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     * @param PostManager $posts
     */
    public function __construct( Request $request, PostManager $posts ) {
        $this->posts = $posts;
        $this->request = $request;
    }

    /**
     * @return ResourceAbstract
     */
    public function index(  ) {
        $posts = $this->posts->get( );

        return new Collection($posts, new PostTransformer, "posts");
    }

    /**
     * @throws MethodNotImplementedException
     */
    public function store( ) {
        throw new MethodNotImplementedException( __FUNCTION__ );

        $post = $this->posts->create(
            $this->request->get()
        );
    }

    /**
     * @param $id
     * @return ResourceAbstract
     */
    public function show( $id ) {
        $post = $this->posts->find($id);

        return new Item($post, new PostTransformer, "posts");
    }

    /**
     * @param $id
     * @throws MethodNotImplementedException
     */
    public function update( $id ) {
        throw new MethodNotImplementedException( __FUNCTION__ );
    }

    /**
     * @param $id
     * @throws MethodNotImplementedException
     */
    public function destroy( $id ) {
        throw new MethodNotImplementedException( __FUNCTION__ );
    }
}