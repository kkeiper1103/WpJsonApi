<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/8/2015
 * Time: 2:36 PM
 */

namespace WpJsonApi;


use FastRoute\Dispatcher;
use League\Container\Container;
use League\Route\RouteCollection;
use WpJsonApi\Providers\RouterProvider;
use WpJsonApi\Providers\FractalProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use League\Container\Definition\FactoryInterface;
use League\Route\Http\Exception\NotFoundException;

/**
 * Class Plugin
 * @package WpJsonApi
 */
class Plugin extends Container
{
    /**
     * @param array $config
     * @param FactoryInterface $factory
     */
    public function __construct($config = [], FactoryInterface $factory = null) {
        parent::__construct($config, $factory);

        $this->addServiceProvider( FractalProvider::class );
        $this->addServiceProvider( RouterProvider::class );

        /**
         *
         */
        do_action("wp-json.construct");
    }

    /**
     *
     */
    public function dispatch() {
        try {
            $request = Request::createFromGlobals();

            /**
             * @var $dispatcher Dispatcher
             */
            $dispatcher = $this->get( Dispatcher::class );

            $response = $dispatcher->dispatch( $request->getMethod(), $request->getPathInfo() );

            /**
             *
             */
            do_action("wp-json.dispatch", $dispatcher, $request, $response);

            // we only want to send the response if a route matched. Let WordPress handle the 404s
            if( $response->getStatusCode() === Response::HTTP_OK ) {
                $response->send();

                exit;
            }
        }
        catch(NotFoundException $nfe) {}
    }
}