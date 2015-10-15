<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/14/2015
 * Time: 4:25 PM
 */

namespace WpJsonApi;


use Symfony\Component\HttpFoundation\Request;

class Settings
{
    /**
     * @var array|mixed|void
     */
    protected $settings = null;

    /**
     * @var
     */
    protected $key;
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     * @param $option_name
     */
    public function __construct( Request $request, $option_name ) {
        if( is_null($option_name) )
            throw new \InvalidArgumentException("\$option_name cannot be null!");

        $this->request = $request;
        $this->key = $option_name;

        $this->load();
    }

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    public function get($key, $default = null) {
        if( is_null($this->settings) )
            $this->load();

        $request = $this->request;

        // 1 check _REQUEST parameters
        if( $request->request->has($key) )
        {
            return $request->request->get($key);
        }
        // 2 check existing setting
        else if( !empty($this->settings[$key]) )
        {
            return $this->settings[$key];
        }
        // 3 return default
        else
        {
            return $default;
        }
    }

    /**
     * @param $key
     * @param string $value
     * @return $this
     */
    public function set($key, $value = "") {
        if( is_null($this->settings) )
            $this->load();

        $this->settings[$key] = $value;
        return $this;
    }

    /**
     *
     */
    public function load() {
        $this->settings = get_option($this->key, []);
    }

    /**
     *
     */
    public function save() {
        update_option( $this->key, $this->settings );
    }

    /**
     *
     */
    public function reset() {
        update_option( $this->key, [] );
    }
}