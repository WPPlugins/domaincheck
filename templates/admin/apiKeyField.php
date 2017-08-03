<?php $value = get_option(\domaincheck\DomainCheckPlugin::OPTION_API_KEY) ?> 
<input type="text" name="domaincheck_apiKey" value="<?php echo esc_attr($value) ?>" />
