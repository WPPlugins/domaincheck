=== DomainCheck ===
Contributors: malkusch
Tags: domain
Requires at least: 4.0.0
Tested up to: 4.4.2
Stable tag: trunk
License: WTFPL
License URI: http://www.wtfpl.net/txt/copying/

Check if a domain is available. More than 500 top level domains are supported.

== Description ==

This domain check plugin allows checking if a domain name is available. Checking
if a domain name is available is a complex problem. New top level domains
emerge frequently. Static domain check codes get outdated very soon. This plugin
uses the [Whois API](http://whois-api.domaininformation.de/) to support the
latest top level domains correctly. By using the Whois API you also avoid
hitting any rate limits on the respective whois server.

== Installation ==

1. Upload the domaincheck folder to the `/wp-content/plugins/domaincheck` directory,
    or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Set in Settings/Domain Check the api key from the [Whois API](http://whois-api.domaininformation.de/).
3. Add the widget to your prefered location through the 'Appearance' menu in WordPress.
   or add shortcode [domaincheck] to your post or page.

The shortcode [domaincheck] supports these parameters

- button (optional): Text of the submit button, e.g. [domaincheck button=Check]
- available (optional): Message shown when a domain is availbale. It supports the
  placeholder %s for the domain, e.g. [domaincheck available="The domain %s is available"]
- registered (optional): Message shown when a domain is registered. It supports the
  placeholder %s for the domain, e.g. [domaincheck registered="The domain %s is not available"]

== Changelog ==

= 0.2 = 
* Add the shortcode parameters `available` and `registered`.

= 0.1 =
* First release
