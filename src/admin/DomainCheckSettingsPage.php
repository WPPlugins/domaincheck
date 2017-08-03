<?php

namespace domaincheck\admin;

use domaincheck\DomainCheckPlugin;

class DomainCheckSettingsPage
{

    const PAGE = "domaincheck";
    
    public function register()
    {
        add_action('admin_menu', array($this, 'addPage'));
        add_action('admin_init', array($this, 'setupPage'));
    }

    public function addPage()
    {
        add_options_page(
                'Domain Check Options', 'Domain Check', 'manage_options', self::PAGE, array($this, "printPage")
        );
    }

    public function printPage()
    {
        require __DIR__ . "/../../templates/admin/settingsPage.php";
    }

    public function setupPage()
    {
        add_settings_section(
                "domainCheckSettings", "Domain Check", array($this, "printSection"), self::PAGE
        );

        add_settings_field(
                "domainCheckSettingsApiKey", "API key", array($this, "printApiKey"), self::PAGE, "domainCheckSettings"
        );

        register_setting(DomainCheckPlugin::OPTION_API_KEY, DomainCheckPlugin::OPTION_API_KEY, array($this, "validateApiKey"));
    }

    public function validateApiKey($apiKey)
    {
        $ch = curl_init(DomainCheckPlugin::ENDPOINT . "/domains"); 
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array("X-Mashape-Key: $apiKey"),
            CURLOPT_RETURNTRANSFER => true
        ));
        curl_exec($ch);
        $valid = curl_getinfo($ch, CURLINFO_HTTP_CODE) < 400;
        curl_close($ch);
        
        if (!$valid) {
            add_settings_error(
                DomainCheckPlugin::OPTION_API_KEY,
                "error",
                __("The API key is not valid.", DomainCheckPlugin::TEXT_DOMAIN)
            );
            $apiKey = get_option(DomainCheckPlugin::OPTION_API_KEY);
        }
        
        return $apiKey;
    }
    
    public function printSection()
    {
        require __DIR__ . "/../../templates/admin/settingsSection.php";
    }

    public function printApiKey()
    {
        require __DIR__ . "/../../templates/admin/apiKeyField.php";
    }
}
