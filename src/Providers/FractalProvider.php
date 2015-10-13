<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 1:23 PM
 */

namespace WpJsonApi\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class FractalProvider extends AbstractServiceProvider
{

    protected $provides = [
        Manager::class,

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
        $manager->setSerializer(new JsonApiSerializer( get_site_url() ));

        if( isset($_GET['includes']) ) {
            $manager->parseIncludes($_GET['includes']);
        }

        $this->getContainer()
            ->share(Manager::class, $manager);
    }
}