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
     * @param $path
     * @param $controller
     */
    public function resource( $path, $controller ) {

        $parts = explode(".", $path);

        $path = $this->buildPath($parts);
        // index
        $this->get($path, [$controller, "index"]);

        // store
        $this->post($path, [$controller, "store"]);

        // show
        $this->get("{$path}/{id:a}", [$controller, "show"]);

        // update
        $this->post("{$path}/{id:a}", [$controller, "store"]);
        $this->put("{$path}/{id:a}", [$controller, "store"]);
        $this->patch("{$path}/{id:a}", [$controller, "store"]);

        // destroy
        $this->delete("{$path}/{id:a}", [$controller, "destroy"]);
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
}