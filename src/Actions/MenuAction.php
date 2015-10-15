<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 12:01 PM
 */

namespace WpJsonApi\Actions;


use League\Plates\Engine;
use Symfony\Component\HttpFoundation\Request;
use WpJsonApi\Message;
use WpJsonApi\Settings;

class MenuAction implements ActionInterface
{
    /**
     * @var Engine
     */
    private $engine;
    /**
     * @var Settings
     */
    private $settings;

    /**
     * @param Engine $engine
     * @param Settings $settings
     */
    public function __construct(Engine $engine, Settings $settings) {
        $this->engine = $engine;

        $this->settings = $settings;
    }

    /**
     * Hook code to be run
     *
     * @return mixed
     */
    public function __invoke()
    {
        $page_title = "WP Json API Options";
        $menu_title = "WP Json API";
        $capability = "manage_options";
        $menu_slug = "wp-json-api";


        add_options_page(
            $page_title, $menu_title,
            $capability, $menu_slug,
            [$this, "render"]
        );
    }

    /**
     * @return void
     */
    public function render() {

        if( strtoupper($_SERVER['REQUEST_METHOD']) === "POST" ) {
            $this->processPost();

        }

        echo $this->engine->render("settings/form", [
            "title" => "Api Settings",
            "settings" => $this->settings
        ]);
    }

    /**
     *
     */
    protected function processPost() {
        $nonce = $_REQUEST['_wpnonce'];

        // if the nonce doesn't verify, bail
        if( wp_verify_nonce($nonce, "json_api_settings") === false ) {

            echo new Message(Message::ERROR, "Nonce Didn't Validate! Settings Not Saved.");

            return;
        }

        // start saving the settings
        foreach($_POST['settings'] as $key => $value) {
            $this->settings->set($key, $value);
        }

        // now just save the settings
        $this->settings->save();


        echo new Message(Message::UPDATED, "Settings Successfully Saved!");
    }
}