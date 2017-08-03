<?php

namespace domaincheck;

use domaincheck\admin\DomainCheckSettingsPage;
use domaincheck\widget\DomainCheckWidget;

class DomainCheckPlugin
{

    const TEXT_DOMAIN = "domaincheck";
    const OPTION_API_KEY = "domaincheck_apiKey";
    const OPTION_VERSION = "domaincheck_version";
    const ENDPOINT = "https://whois-v0.p.mashape.com/";
    
    public function setup()
    {
        add_action('admin_notices', array($this, "noticeAdmin")) ;
        
        if (is_admin()) {
            $adminPage = new DomainCheckSettingsPage();
            $adminPage->register();
        }
        
        $widget = new DomainCheckWidget();
        $widget->register();
    }
    
    public function noticeAdmin()
    {
        if (!get_option(self::OPTION_VERSION)) {
            $this->onActivation();
        }
    }
    
    private function onActivation()
    {
        add_option(self::OPTION_VERSION, "0.1");
        add_option(self::OPTION_API_KEY, "");

        require __DIR__ . "/../templates/admin/activation.php";
    }
    
    function onDeactivation() {
        delete_option(self::OPTION_VERSION);
        delete_option(self::OPTION_API_KEY);
    }
}
