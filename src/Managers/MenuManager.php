<?php
/**
 * Created by PhpStorm.
 * User: kkeiper
 * Date: 10/15/15
 * Time: 6:03 PM
 */

namespace WpJsonApi\Managers;


use Symfony\Component\HttpFoundation\Request;

class MenuManager implements ManagerInterface
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request) {

        $this->request = $request;
    }

    /**
     * @return \Illuminate\Support\Collection<T> of items
     */
    public function get()
    {
        // TODO: Implement get() method.
    }

    /**
     * @param $id
     * @return <T>
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @param $params
     * @return <T>
     */
    public function store(array $params)
    {
        // TODO: Implement store() method.
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