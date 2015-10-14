<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/14/2015
 * Time: 8:37 AM
 */

namespace WpJsonApi\Resolvers;


use League\Container\ContainerInterface;
use Phroute\Phroute\HandlerResolverInterface;

class PluginResolver implements HandlerResolverInterface
{
    /**
     * @var
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    /**
     * Create an instance of the given handler.
     *
     * @param $handler
     * @return array
     */
    public function resolve($handler)
    {
        // handle the controllers
        if(
            is_array($handler) && is_string($handler[0]) &&
            $this->container->has( $handler[0] )
        ) {
            $handler[0] = $this->container->get( $handler[0] );
        }

        return $handler;
    }
}