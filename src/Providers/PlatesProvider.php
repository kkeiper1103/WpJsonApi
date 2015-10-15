<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/14/2015
 * Time: 3:03 PM
 */

namespace WpJsonApi\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Plates\Engine;

class PlatesProvider extends AbstractServiceProvider
{
    protected $provides = [
        Engine::class
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
        $view = dirname(dirname(__DIR__)) . "/resources/views";
        $engine = new Engine($view);

        $this->getContainer()
            ->share(Engine::class, $engine);
    }
}