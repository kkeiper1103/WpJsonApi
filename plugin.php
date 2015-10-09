<?php
/**
 * Plugin Name: WP Json API
 * Plugin URI: http://plugins.gnarlyweb.com/plugins/wp-json-api
 * Description: Provides a JSON API endpoint.
 * Version: 1.0
 * Author: Kyle Keiper
 * Test Domain: json-api
 */

require_once __DIR__ . "/vendor/autoload.php";


add_action("init", function() {
    $container = new WpJsonApi\Plugin();

    $container->dispatch();
});