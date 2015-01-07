<?php
/*
  Plugin Name: Vcoin Addon Campaign
  Plugin URI: https://github.com/jjhesk/authserver
  Description: In order to run this module the server will need to activate the mentioned modules as list below: Titan Framework, WordPress Importer, Meta Box, JSON API, JSON API Auth, Email Login, Gravity Forms
  Version: 1.01
  Author: Hesk
  Author URI:
  License: GPLv3
 */
define('VCOIN_CAMPAIGN_PATH', dirname(__FILE__));
define('VCOIN_CAMPAIGN_INSTANCE_NAME', 'vcoincampaign');
define("HKM_GAME_CAMPAIGN", "campaign");

if (!function_exists('after_vcoin_setup')):
    function after_vcoin_setup()
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
        /**
         *
         */
    }
endif;