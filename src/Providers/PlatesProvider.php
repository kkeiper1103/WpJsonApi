<?php
/**
 * Created by PhpStorm.
 * User: kkeiper
 * Date: 10/10/15
 * Time: 9:27 AM
 */

namespace WpJsonApi\Providers;


use League\Container\ServiceProvider;
use League\Plates\Engine;

class PlatesProvider extends ServiceProvider
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
        $engine = new Engine( dirname(__DIR__) . "/../resources/views" );

        $this->getContainer()
            ->add(Engine::class, $engine);
    }
}