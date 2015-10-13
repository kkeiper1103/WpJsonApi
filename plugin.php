<?php
/**
 * Plugin Name: WP Json API
 * Plugin URI: https://github.com/kkeiper1103/WpJsonApi
 * Description: Provides a JSON API endpoint.
 * Version: 1.0
 * Author: Kyle Keiper
 * Test Domain: json-api
 */

require_once __DIR__ . "/vendor/autoload.php";

$plugin = new \WpJsonApi\Plugin();
$plugin->register();



add_filter('plugin_action_links_' . plugin_basename( __FILE__ ), function(array $links) {
    $href = esc_url( get_admin_url(null, 'options-general.php?page=wp-json-api') );

    array_push($links, "<a href=\"{$href}\">Plugin Settings</a>");

    return $links;
});