<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 11:20 AM
 */

namespace WpJsonApi;


use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Fractal\Manager;
use League\Fractal\Resource\ResourceAbstract;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use WpJsonApi\Exceptions\AuthorizationNotValidException;
use WpJsonApi\Providers\FractalProvider;
use WpJsonApi\Providers\PlatesProvider;
use WpJsonApi\Providers\RoutingProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use WpJsonApi\Providers\SettingsProvider;
use WpJsonApi\Providers\WhoopsProvider;

class Plugin extends Container
{
    /**
     *
     */
    public function __construct() {
        parent::__construct();

        // sets up auto-dependency resolution within container
        $this->delegate( new ReflectionContainer );

        // set option name
        $this->share("option_name", "wp-json-api");
    }

    /**
     *
     */
    public function register()
    {
        // register all bindings
        $this->registerServiceProviders();

        // register wp action hooks for menus / pages, etc
        $this->registerActionHooks();
    }

    /**
     * @return $this
     */
    protected function registerServiceProviders()
    {
        // if the host header contains "local" within it, assume dev environment
        // I know this can be spoofed, but I'm planning to remove this when it goes live;
        // this is just a precaution in case I forget.
        if( strpos($_SERVER['HTTP_HOST'], "local") !== 0 )
            $this->addServiceProvider(WhoopsProvider::class);

        $this->addServiceProvider(RoutingProvider::class);
        $this->addServiceProvider(FractalProvider::class);
        $this->addServiceProvider(PlatesProvider::class);
        $this->addServiceProvider(SettingsProvider::class);

        return $this;
    }

    /**
     * register the different action hooks as objects
     */
    protected function registerActionHooks()
    {
        add_action("admin_menu", $this->get(Actions\MenuAction::class));
        add_action("init", [$this, 'dispatch']);
    }

    /**
     *
     */
    public function run()
    {
        /**
         * @var $request Request
         */
        $request = $this->get(Request::class);

        /**
         * @var $dispatcher Dispatcher
         */
        $dispatcher = $this->get(Dispatcher::class);

        // what is the content for the response?
        $content = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

        // if the returned content is a string, wrap it in an array and jsonify that
        if( is_string($content) ) {
            $content = ["content" => $content];
        }

        // if the $content is a prepared Collection, have fractal process it
        else if( $content instanceof ResourceAbstract ) {
            $content = $this->get( Manager::class )
                ->createData($content)->toArray();
        }

        // if the response is a Response Object, send that instead
        else if( $content instanceof Response ) {
            return $content->send();
        }

        // send the response
        $response = new JsonResponse($content);
        return $response->send();
    }

    /**
     *
     */
    public function dispatch() {
        try {
            $this->run(); exit;
        }

        catch (HttpMethodNotAllowedException $mna)
        {
            $content = [
                "error" => "Requested HTTP Method not Allowed!"
            ];

            $response = new JsonResponse($content, Response::HTTP_METHOD_NOT_ALLOWED);
            $response->headers->set("Allow", ltrim($mna->getMessage(), "Allow: "));
            $response->send(); exit;
        }

        // if someone throws an invalid auth exception, just output an unauthorized jsonresponse
        catch (AuthorizationNotValidException $anv)
        {
            $content = [
                "error" => "Authorization Header Not Valid! Please Include a Correct Value in X-WPJSONAPI-AUTH Header."
            ];

            $response = new JsonResponse($content, Response::HTTP_UNAUTHORIZED);
            $response->send(); exit;
        }

        // don't do anything if the routecollector doesn't have the uri registered. WordPress will handle it
        catch (HttpRouteNotFoundException $nfe) {}
    }
}