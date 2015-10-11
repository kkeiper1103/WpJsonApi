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
            $request = Request::createFromGlobals();


            $suppliedKey = $request->headers->get("X-JSONAPI-AUTH", false);

            if( $suppliedKey && $request->headers->get("X-JSONAPI-AUTH") === $this["settings"]["api_key"] ) {

                /**
                 * @var $dispatcher Dispatcher
                 */
                $dispatcher = $this->get( Dispatcher::class );

                $response = $dispatcher->dispatch( $request->getMethod(), $request->getPathInfo() );

                /**
                 *
                 */
                do_action("wp-json.dispatch", $dispatcher, $request, $response);

                // we only want to send the response if a route matched.
                switch($response->getStatusCode()) {

                    case Response::HTTP_NO_CONTENT:
                    case Response::HTTP_OK:
                        $response->send();

                        exit;
                        break;

                }
            }

            else {
                $content = json_encode([
                    "error" => "Authorization Failed. Did you set the 'X-JSONAPI-AUTH' header correctly?"
                ]);

                $response = new Response($content, Response::HTTP_UNAUTHORIZED);
                $response->headers->set("Content-Type", "application/json");

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


        /**
         * This causes the plugin's routes to kick in only if WordPress experiences a 404
         */
        add_action("wp", function() {

            if( is_404() )
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
}