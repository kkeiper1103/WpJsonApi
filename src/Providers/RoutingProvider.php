<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 11:21 AM
 */

namespace WpJsonApi\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;
use WpJsonApi\Filters\VerifyAuthFilter;

class RoutingProvider extends AbstractServiceProvider
{
    protected $provides = [
        RouteCollector::class,
        Dispatcher::class,
        Request::class
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register() {

        /**
         * Add the request
         */
        $request = Request::createFromGlobals();
        $this->getContainer()
            ->share(Request::class, $request);

        //
        $router = new RouteCollector();
        $router->filter("verifyAuth", new VerifyAuthFilter($request));

        //
        $router->group(["prefix" => "api", "before" => "verifyAuth"], function(RouteCollector $router) {

            /**
             * @TODO change v1 slug maybe? make configurable?
             */
            $router->group(["prefix" => "v1"], function(RouteCollector $router) {
                require_once dirname(__DIR__) . "/Http/routes.php";

                apply_filters("wp-json.routes", $router);
            });
        });

        // add router itself
        $this->getContainer()
            ->share(RouteCollector::class, $router);

        /**
         * add the dispatcher
         */
        $dispatcher = new Dispatcher($router->getData());
        $this->getContainer()
            ->share(Dispatcher::class, $dispatcher);
    }
}