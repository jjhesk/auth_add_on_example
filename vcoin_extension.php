<?php
/*
  Plugin Name: Vcoin Addon Campaign
  Plugin URI: https://github.com/jjhesk/authserver
  Description: This module will absolutely depend on vcoin server core module
  Version: 1.01
  Author: Hesk
  Author URI:
  License: GPLv3
 */
define('VCOIN_CAMPAIGN_PATH', dirname(__FILE__));
define('VCOIN_CAMPAIGN_INSTANCE_NAME', 'vcoincampaign');
define("HKM_GAME_CAMPAIGN", "campaign");
add_action('after_vcoin_setup', 'package_campaign', 10);
if (!function_exists('package_campaign')):
    function package_campaign()
    {
        $destinations = array(
            'payload',
            'payload/fundamental',
            'payload/logic',
            'payload/cms',
            'payload/gf',
            'payload/api');
        foreach ($destinations as $folder) {
            foreach (glob(VCOIN_CAMPAIGN_PATH . "/" . $folder . "/*.php") as $filename) {
                require_once $filename;
            }
        }
        payload\installation_campaign::reg_hook(__FILE__);
        payload\connect_json_api::init();
        campaign_cms::init();
    }
endif;