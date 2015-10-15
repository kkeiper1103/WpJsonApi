<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/14/2015
 * Time: 4:24 PM
 */

namespace WpJsonApi\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use WpJsonApi\Settings;

class SettingsProvider extends AbstractServiceProvider
{
    protected $provides  = [
        Settings::class
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
        $settings = new Settings(
            $this->getContainer()->get(Request::class),
            $this->getContainer()->get("option_name")
        );

        $this->getContainer()
            ->share(Settings::class, $settings);
    }
}