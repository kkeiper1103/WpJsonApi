<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/14/2015
 * Time: 10:48 AM
 */

namespace WpJsonApi;


use ICanBoogie\Inflector;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\RouteParser;

class ResourcefulRouteCollector extends RouteCollector
{
    /**
     * @param RouteParser|null $parser
     */
    public function __construct( RouteParser $parser = null ) {
        parent::__construct( $parser );
    }

    /**
     * @param $namespace string
     * @param $controller
     */
    public function resource( $namespace, $controller ) {

        // split the path by namspace
        $parts = explode(".", $namespace);
        $path = $this->buildPath($parts);

        /**
         * Process adding in the routes for the resource
         */


        // index
        $this->get([$path, "{$namespace}.index"], [$controller, "index"]);

        // store
        $this->post([$path, "{$namespace}.store"], [$controller, "store"]);

        // show
        $this->get(["{$path}/{id:a}", "{$namespace}.show"], [$controller, "show"]);

        // update
        $this->post("{$path}/{id:a}", [$controller, "store"]);
        $this->put(["{$path}/{id:a}", "{$namespace}.update"], [$controller, "store"]);
        $this->patch("{$path}/{id:a}", [$controller, "store"]);

        // destroy
        $this->delete(["{$path}/{id:a}", "{$namespace}.destroy"], [$controller, "destroy"]);
    }

    /**
     * @param array $parts
     * @return array
     */
    private function buildPath(array $parts)
    {
        $path = "";
        for($i = 0; $i < count($parts); ++$i) {
            $path .= $parts[$i];

            // if we're not to the end of the parts, we want to add an id route parameter
            if( $i !== (count($parts) - 1) ) {
                $single = Inflector::get("en")->singularize($parts[$i]);

                $path .= "/{{$single}_id:a}/";
            }
        }

        return $path;
    }

    /**
     * @param $name
     * @param $params
     *
     * @return bool
     */
    public function isRoute( $name, $params = array() ) {
        if( !is_array($params) )
            return $this->isRoute($name, [$params]);

        // check to see if path info is the same as the generated route. Best?
        return ( ltrim($_SERVER[ 'PATH_INFO' ], "/") === ltrim($this->route($name, $params), "/") );
    }
}