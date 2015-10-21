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
use Phroute\Phroute\HandlerResolverInterface;
use Phroute\Phroute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;
use WpJsonApi\Filters\VerifyAuthFilter;
use WpJsonApi\Resolvers\PluginResolver;
use WpJsonApi\ResourcefulRouteCollector;
use WpJsonApi\Settings;

class RoutingProvider extends AbstractServiceProvider
{
    protected $provides = [
        RouteCollector::class,
        Dispatcher::class,
        Request::class,
        HandlerResolverInterface::class
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
        $router = new ResourcefulRouteCollector();

        $settings = $this->getContainer()->get(Settings::class);

        if( $settings->get("required", false) != false )
            $router->filter("verifyAuth", $this->getContainer()->get(VerifyAuthFilter::class));

        //
        $router->group([
            "prefix" => $settings->get("prefix", "api"),
            "before" => "verifyAuth"
        ], function(RouteCollector $router) {

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
         * Resolver; ties the controllers to di
         */
        $resolver = new PluginResolver( $this->getContainer() );
        $this->getContainer()
            ->share(HandlerResolverInterface::class, $resolver);

        /**
         * add the dispatcher
         */
        $dispatcher = new Dispatcher($router->getData(), $resolver);
        $this->getContainer()
            ->share(Dispatcher::class, $dispatcher);
    }
}