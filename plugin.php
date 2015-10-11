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


$plugin = new WpJsonApi\Plugin();

$plugin->initialize();