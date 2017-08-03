<?php
/*
Plugin Name: DomainCheck
Plugin URI:  https://wordpress.org/plugins/domaincheck/
Description: Domain check plugin for the <a href="http://whois-api.domaininformation.de/">Whois API</a>. Please get your free API key from there. This plugin uses the Whois API to check if an internet domain name is free. The Whois API supports more than 500 top level domains.
Version:     0.2
Author:      Markus Malkusch
Author URI:  http://markus.malkusch.de
License:     WTFPL
License URI: http://www.wtfpl.net/txt/copying/
Domain Path: /languages
Text Domain: domaincheck
*/

namespace domaincheck;

require_once __DIR__ . "/src/DomainCheckPlugin.php";
require_once __DIR__ . "/src/admin/DomainCheckSettingsPage.php";
require_once __DIR__ . "/src/widget/DomainCheckWidget.php";

load_plugin_textdomain(DomainCheckPlugin::TEXT_DOMAIN, false, basename(__DIR__) . "/languages");

$plugin = new DomainCheckPlugin();
$plugin->setup();

register_deactivation_hook(__FILE__, array($plugin, "onDeactivation"));
