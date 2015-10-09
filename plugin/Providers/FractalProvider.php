<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/8/2015
 * Time: 2:55 PM
 */

namespace WpJsonApi\Providers;


use League\Container\ServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class FractalProvider extends ServiceProvider
{
    protected $provides = [
        Manager::class
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
        $manager = new Manager();
        $manager->setSerializer(new JsonApiSerializer);

        if( isset($_GET['include']) ) {
            $manager->parseIncludes( $_GET['include'] );
        }

        $this->getContainer()->add(Manager::class, $manager);
    }
}