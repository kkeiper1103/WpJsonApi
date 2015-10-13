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

class VerifyAuthFilter implements FilterInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
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
            $key != "asdfjkl;"
        ) {
            throw new AuthorizationNotValidException;
        }
    }
}