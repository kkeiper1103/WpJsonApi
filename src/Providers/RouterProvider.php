<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/8/2015
 * Time: 3:51 PM
 */

namespace WpJsonApi\Providers;


use FastRoute\Dispatcher;
use League\Container\ServiceProvider;
use League\Route\RouteCollection;
use League\Route\Strategy\RestfulStrategy;
use League\Route\Strategy\StrategyInterface;

class RouterProvider extends ServiceProvider
{
    protected $provides = [
        RouteCollection::class,
        Dispatcher::class,
        StrategyInterface::class
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $router = new RouteCollection( $this->getContainer() );

        $strategy = new RestfulStrategy;

        $this->getContainer()
            ->add( StrategyInterface::class, $strategy );

        $router->setStrategy( $strategy );

        require_once dirname(__DIR__) . "/Http/routes.php";

        $router = apply_filters("wp-json.routes", $router);

        // share the dispatcher throughout the container
        $this->getContainer()
            ->add( Dispatcher::class, $router->getDispatcher() );

        // share the route collection
        $this->getContainer()
            ->add( RouteCollection::class, $router );
    }
}