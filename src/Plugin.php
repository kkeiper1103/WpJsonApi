<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/8/2015
 * Time: 2:36 PM
 */

namespace WpJsonApi;


use Closure;
use FastRoute\Dispatcher;
use League\Container\Container;
use League\Route\RouteCollection;
use WpJsonApi\Pages\SettingsPage;
use WpJsonApi\Providers\PlatesProvider;
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
     * @var string option name for the serialized settings
     */
    protected $optionKey = "wp-json-api";

    /**
     * @param array $config
     * @param FactoryInterface $factory
     */
    public function __construct($config = [], FactoryInterface $factory = null) {
        parent::__construct($config, $factory);

        //
        $settings = get_option($this->optionKey, [
            "api_key" => "asdfjkl;",
            "some" => "settings"
        ]);

        $this->add("settings", $settings);

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
            $request = $this[ Request::class ];
            $dispatcher = $this[ Dispatcher::class ];


            $response = $dispatcher->dispatch( $request->getMethod(), $request->getPathInfo() );

            /**
             * Conundrum: I need to know that the route was found (don't want any non registered route throwing a 404)
             * so I need $response to know that. But by the time $response is created, I've already queried the
             * database.
             *
             * I want to verify that the route exists, but prevent any database calls from happening if the
             * auth code isn't valid. Processing should bail after dispatch, but before content is loaded. @see below
             */

            // allow themes / plugins to modify the response
            do_action("wp-json.dispatch", $dispatcher, $request, $response);

            // we only want to send the response if a route matched.
            if( $response->getStatusCode() !== Response::HTTP_NOT_FOUND) {

                if(
                    // key doesn't exist...
                    ($key = $request->headers->get("X-WPJSONAPI-AUTH", false)) === false ||

                    // key isn't the same as what is configured...
                    $key !== $this["settings"]["api_key"]
                ) {
                    /**
                     *
                     */
                    $content = json_encode([
                        "error" => "Authorization Failed. Did you set the 'X-WPJSONAPI-AUTH' header correctly?"
                    ]);

                    $response = new Response($content, Response::HTTP_UNAUTHORIZED);
                    $response->headers->set("Content-Type", "application/json");
                }

                $response->send(); exit;
            }
        }
        catch(NotFoundException $nfe) {}
    }

    /**
     * adds actions for wordpress hooks
     */
    public function initialize() {

        // callback to run after theme is loaded
        add_action("init", function() {
            $this->addServiceProvider( FractalProvider::class );
            $this->addServiceProvider( RouterProvider::class );
        });

        // dispatch the router when WP is fully loaded
        add_action("wp", function() {
            $this->dispatch();
        });

        // code to run when admin is loaded
        add_action("admin_init", function() {
            $this->addServiceProvider( PlatesProvider::class );
        });

        //
        add_action("admin_menu", function() {

            new SettingsPage($this);

        });
    }

    private function runMiddleware(Request $request)
    {
        // modify / check middleware as needed


        return $request;
    }
}