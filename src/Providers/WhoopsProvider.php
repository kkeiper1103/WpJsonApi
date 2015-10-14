<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/14/2015
 * Time: 8:52 AM
 */

namespace WpJsonApi\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Whoops\Handler\HandlerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    protected $provides = [
        HandlerInterface::class
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {}

    /**
     * Method will be invoked on registration of a service provider implementing
     * this interface. Provides ability for eager loading of Service Providers.
     *
     * @return void
     */
    public function boot()
    {
        $handler = new PrettyPageHandler();
        $this->getContainer()
            ->share(HandlerInterface::class, $handler);

        $whoops = new Run();
        $whoops->pushHandler( $handler );
        $whoops->register();
    }
}