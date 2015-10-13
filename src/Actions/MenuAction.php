<?php
/**
 * Created by PhpStorm.
 * User: kkeiper1103
 * Date: 10/13/2015
 * Time: 12:01 PM
 */

namespace WpJsonApi\Actions;


class MenuAction implements ActionInterface
{

    /**
     * Hook code to be run
     *
     * @return mixed
     */
    public function __invoke()
    {
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
     * @return void
     */
    public function render() {
        $html = "<h2>Hello Settings!</h2>";

        echo $html;
    }
}