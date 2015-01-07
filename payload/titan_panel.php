<?php

/**
 * Created by HKM Corporation.
 * User: Hesk
 * Date: 14年10月3日
 * Time: 下午12:36
 */


/**
 * This script is not used within Titan Framework itself.
 *
 * This script is meant to be used with your Titan Framework-dependent theme or plugin,
 * so that your theme/plugin can verify whether the framework is installed.
 *
 * If Titan is not installed, then the script will display a notice with a link to
 * Titan.
 *
 * To use this script, just copy it into your theme/plugin directory and do a
 * require_once( 'titan-framework-checker.php' );
 */
if (!class_exists('TitanFramework')) {
    if (!class_exists('TitanFrameworkThemeChecker')) {
        class TitanFrameworkThemeChecker
        {
            function __construct()
            {
                if (!is_admin()) {
                    add_action('init', array($this, 'displaySiteNotification'));
                } else {
                    add_filter('admin_notices', array($this, 'displayAdminNotification'));
                }
            }

            public function displaySiteNotification()
            {
                die(__("This theme requires the plugin Titan Framework. Please install it in the admin first before continuing.", "default"));
            }

            public function displayAdminNotification()
            {
                echo "<div class='error'><p><strong>"
                    . __("This theme requires the Titan Framework plugin.", "default")
                    . sprintf(" <a href='%s'>%s</a>",
                        admin_url("plugin-install.php?tab=search&type=term&s=titan+framework"),
                        __("Click here to search for the plugin.", "default"))
                    . "</strong></p></div>";
            }
        }

        new TitanFrameworkThemeChecker();
    }
    return;
} else {
    /*
     * Create our admin page
     */
    $titan = TitanFramework::getInstance(VCOIN_CAMPAIGN_INSTANCE_NAME);
    //  TitanPanelSetup::setup();

    $adminPanel = $titan->createAdminPanel(array(
        'name' => __('V-COIN', HKM_LANGUAGE_PACK),
        'icon' => 'dashicons-chart-area'
    ));

    $tab = $adminPanel->createTab(array(
        'name' => __('Campaign Config', HKM_LANGUAGE_PACK),
    ));

    $tab->createOption(array(
        'name' => 'Campaign Setting Example 1',
        'type' => 'text',
        'id' => 'cam_set_ex1',
        'desc' => 'This is the example setting number one.  '
    ));

    //你已在達到 之中 的獎賞
    $tab->createOption(array(
        'type' => 'save'
    ));

    /*******************************************************
     * TITAN FRAMEWORK CODE END
     *******************************************************/

}

