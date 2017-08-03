<?php
namespace domaincheck\widget;

use domaincheck\DomainCheckPlugin;

class DomainCheckWidget extends \WP_Widget
{
    
    private $widgetCounter = 0;
    
    public function __construct()
    {
        parent::__construct(
                "domaincheck",
                "Domain Check",
                array(
                    "description" => __("A domain check form", DomainCheckPlugin::TEXT_DOMAIN)
                )
        );
    }
    
    public function register()
    {
        add_action('widgets_init', function() {
            register_widget('domaincheck\\widget\\DomainCheckWidget');
        });
        
        add_shortcode('domaincheck', array($this, "shortcode"));
    }
    
    public function shortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'button' => __('Check', DomainCheckPlugin::TEXT_DOMAIN),
                'available' => __('The domain %s is available.', DomainCheckPlugin::TEXT_DOMAIN),
                'registered' => __('The domain %s is not available.', DomainCheckPlugin::TEXT_DOMAIN),
            ),
            $atts
        );

        $this->widgetCounter++;        
        $atts['checkId'] = $this->widgetCounter;
        
        if (isset($_POST["checkId"]) && $_POST["checkId"] == $atts['checkId']) {
            $atts['domain'] = $_POST["domain"];
            $atts['isavailable'] = $this->isAvailable($_POST["domain"]);

            if ($atts['isavailable'] === null) {
                $atts['error'] = __("The domain check failed. Please try again.", DomainCheckPlugin::TEXT_DOMAIN);
                
            }
        }
        
        require __DIR__ . "/../../templates/frontent/check_shortcode.php";
    }
    
    public function widget($args, $instance)
    {
        require __DIR__ . "/../../templates/frontent/check_widget.php";
    }
    
    public function form(array $instance)
    {
        // require __DIR__ . "/../../templates/frontent/check_admin.php";
        
        $this->printFormField(
            'title',
            __('Title:'),
            __('Domain availability check', DomainCheckPlugin::TEXT_DOMAIN),
            $instance
        );
        
        $this->printFormField(
            'button',
            __('Button:', DomainCheckPlugin::TEXT_DOMAIN),
            __('Check', DomainCheckPlugin::TEXT_DOMAIN),
            $instance
        );
        
        $this->printFormField(
            'available',
            __('Message when the domain is available (%s can be a placeholder for the domain):', DomainCheckPlugin::TEXT_DOMAIN),
            __('The domain %s is available.', DomainCheckPlugin::TEXT_DOMAIN),
            $instance
        );
        
        $this->printFormField(
            'registered',
            __('Message when the domain is registered (%s can be a placeholder for the domain):', DomainCheckPlugin::TEXT_DOMAIN),
            __('The domain %s is not available.', DomainCheckPlugin::TEXT_DOMAIN),
            $instance
        );
    }
    
    function printFormField($field, $label, $default, $instance) {

        $value = !empty($instance[$field]) ? $instance[$field] : $default;

        ?><p>
            <label for="<?php echo $this->get_field_id($field) ?>">
                <?php echo $label ?>
                <input class="widefat"
                       id="<?php echo $this->get_field_id($field) ?>"
                       name="<?php echo $this->get_field_name($field) ?>"
                       type="text"
                       value="<?php echo esc_attr($value) ?>">
            </label>
        </p><?php
    }
    
    private function isAvailable($domain)
    {
        $apiKey = get_option(DomainCheckPlugin::OPTION_API_KEY);
        $ch = curl_init(DomainCheckPlugin::ENDPOINT . "/check?domain=$domain"); 
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array("X-Mashape-Key: $apiKey"),
            CURLOPT_RETURNTRANSFER => true
        ));
        $json  = curl_exec($ch);
        $error = curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200;
        curl_close($ch);
        if ($error) {
            return null;

        }
        $result = json_decode($json);
        return $result->available;
    }
}
