<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/14/2015
 * Time: 10:48 AM
 */

namespace WpJsonApi;


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

        // index
        $this->get($path, [$controller, "index"]);

        // store
        $this->post($path, [$controller, "store"]);

        // show
        $this->get("{$path}/{id:\\d+}", [$controller, "show"]);

        // update
        $this->post("{$path}/{id:\\d+}", [$controller, "store"]);
        $this->put("{$path}/{id:\\d+}", [$controller, "store"]);
        $this->patch("{$path}/{id:\\d+}", [$controller, "store"]);

        // destroy
        $this->delete("{$path}/{id:\\d+}", [$controller, "destroy"]);
    }
}