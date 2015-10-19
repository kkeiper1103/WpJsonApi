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
     * @var Request
     */
    private $request;
    /**
     * @var PostTransformer
     */
    private $transformer;

    /**
     * @param Request $request
     * @param PostTransformer $transformer
     */
    public function __construct( Request $request, PostTransformer $transformer ) {
        $this->request = $request;
        $this->transformer = $transformer;
    }

    /**
     * @return ResourceAbstract
     */
    public function index(  ) {

        $defaults = [
            "posts_per_page" => 10,
            "post_type" => "post",
            "paged" => 1,
        ];

        // is this a security risk? I don't know for sure
        $args = array_merge($defaults, $this->request->query->all());

        /**
         * Load posts based on query
         */
        $posts = get_posts( $args );

        $collection = new Collection($posts, $this->transformer, "posts");

        $collection->setMetaValue("count", count($posts));
        $collection->setMetaValue("page", intval($this->request->query->get("paged")));

        return $collection;
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

        $post = get_post( (int) $id );

        return new Item($post, $this->transformer, "posts");
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