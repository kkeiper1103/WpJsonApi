<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/16/2015
 * Time: 9:41 AM
 */

namespace WpJsonApi\Http\Controllers;


use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use WpJsonApi\Exceptions\MethodNotImplementedException;
use WpJsonApi\Transformers\CommentTransformer;

class CommentsController
{
    /**
     * @var CommentTransformer
     */
    private $transformer;

    /**
     * @param CommentTransformer $transformer
     */
    public function __construct( CommentTransformer $transformer ) {

        $this->transformer = $transformer;
    }

    /**
     * @param $post_id
     * @return Collection
     */
    public function index( $post_id )
    {
        $comments = get_comments([
            "post_id" => (int) $post_id
        ]);

        return new Collection($comments, $this->transformer, "comments");
    }

    /**
     * @param $post_id
     * @throws MethodNotImplementedException
     */
    public function store( $post_id )
    {
        throw new MethodNotImplementedException(__FUNCTION__);
    }

    /**
     * @param $post_id
     * @param $id
     * @return Item|JsonResponse
     */
    public function show( $post_id, $id )
    {
        $comment = get_comments([
            "post_id" => (int) $post_id,
            "comment__in" => [$id]
        ]);

        // if there are no comments matching the given ids, return no content response
        if( empty($comment) )
            return new JsonResponse([], Response::HTTP_NOT_FOUND);


        return new Item( current($comment), $this->transformer, "comments");
    }

    /**
     * @param $post_id
     * @param $id
     * @throws MethodNotImplementedException
     */
    public function update( $post_id, $id )
    {
        throw new MethodNotImplementedException(__FUNCTION__);
    }

    /**
     * @param $post_id
     * @param $id
     * @throws MethodNotImplementedException
     */
    public function destroy( $post_id, $id )
    {
        throw new MethodNotImplementedException(__FUNCTION__);
    }
}