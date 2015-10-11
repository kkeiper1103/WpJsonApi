<?php
/**
 * Created by PhpStorm.
 * User: kkeiper
 * Date: 10/10/15
 * Time: 9:22 AM
 */

namespace WpJsonApi\Pages;

use League\Container\ContainerInterface;
use League\Plates\Engine;

class SettingsPage implements PageInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;

        $parent_slug = "options-general.php";
        $page_title = "WP Json API Options";
        $menu_title = "WP Json API";
        $capability = "manage_options";
        $menu_slug = "wp-json-api";

        add_submenu_page(
            $parent_slug, $page_title, $menu_title,
            $capability, $menu_slug, [$this, "render"]
        );
    }

    /**
     * @return array Data to be injected into view?
     */
    public function data()
    {
        return $this->container["settings"];
    }

    /**
     * @return string HTML to be shown to user
     */
    public function render()
    {
        echo $this->container[Engine::class]
            ->render( "settings", ["settings" => $this->data()] );
    }
}