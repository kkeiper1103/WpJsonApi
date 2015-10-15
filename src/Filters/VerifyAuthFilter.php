<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 12:45 PM
 */

namespace WpJsonApi\Filters;


use Symfony\Component\HttpFoundation\Request;
use WpJsonApi\Exceptions\AuthorizationNotValidException;
use WpJsonApi\Settings;

class VerifyAuthFilter implements FilterInterface
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Settings
     */
    private $settings;

    /**
     * @param Request $request
     * @param Settings $settings
     */
    public function __construct(Request $request, Settings $settings) {
        $this->request = $request;
        $this->settings = $settings;
    }

    /**
     * @return mixed
     * @throws AuthorizationNotValidException
     */
    public function __invoke()
    {
        $request = $this->request;

        if(
            ($key = $request->headers->get("X-WPJSONAPI-AUTH", false)) === false ||
            $key != $this->settings->get("key")
        ) {
            throw new AuthorizationNotValidException;
        }
    }
}