<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/14/2015
 * Time: 9:51 AM
 */

namespace WpJsonApi\Managers;


interface ManagerInterface
{
    /**
     * @return \Illuminate\Support\Collection<T> of items
     */
    public function get( );

    /**
     * @param $id
     * @return <T>
     */
    public function find( $id );

    /**
     * @param $params
     * @return <T>
     */
    public function store( array $params );

    /**
     * @param $id
     * @param $params
     * @return <T>
     */
    public function update( $id, array $params );

    /**
     * @param $id
     * @return <T>
     */
    public function destroy( $id );

}