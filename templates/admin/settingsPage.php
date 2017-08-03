<?php namespace domaincheck ?>
<div class="wrap">
    <form method="post" action="options.php">
        <?php settings_fields(DomainCheckPlugin::OPTION_API_KEY) ?>
        <?php do_settings_sections(admin\DomainCheckSettingsPage::PAGE) ?>
        <?php submit_button() ?>
    </form>
</div>