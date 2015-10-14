<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/14/2015
 * Time: 9:50 AM
 */

namespace WpJsonApi\Managers;


use Symfony\Component\HttpFoundation\Request;

class PostManager implements ManagerInterface
{
    /**
     * @var Request
     */
    protected $request = null;

    /**
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function get()
    {
        $args = [
            'ignore_sticky_posts' => true,
            'has_password' => false
        ];

        // set numberposts
        $args['posts_per_page'] =  $this->request->get("posts_per_page", 10);

        // set post type
        $args['post_type'] = $this->request->get("post_type", "post");

        // set up the paging parameter
        $args['paged'] = $this->request->get("page", 1);


        $query = new \WP_Query( $args );
        return $query->get_posts();
    }

    /**
     * @param $id
     * @return \WP_Post
     */
    public function find($id)
    {
        $args = [
            'posts_per_page' => 1,
            'ignore_sticky_posts' => true,
            'has_password' => false
        ];

        //
        $args['post_type'] = $this->request->get("post_type", "post");


        $query = new \WP_Query($args);
        $posts = $query->get_posts();
        return current($posts);
    }

    /**
     * @param $params
     * @return <T>
     */
    public function store(array $params)
    {

    }

    /**
     * @param $id
     * @param $params
     * @return <T>
     */
    public function update($id, array $params)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $id
     * @return <T>
     */
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}