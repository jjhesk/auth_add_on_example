<?php
/**
 * Created by PhpStorm. 2013 @ imusictech
 * developed by Heskeyo Kam
 * User: Hesk
 * Date: 13年12月4日
 * Time: 下午3:16
 * Prevent loading this file directly
 * source: http://wordpress.org/plugins/json-api/other_notes/
 *
 * 5.2. Developing JSON API controllers
 * Creating a controller
 * To start a new JSON API controller, create a file called hello.php inside wp-content/plugins/json-api/controllers. Add the following class definition:
 *
 * <-php
 *
 * class JSON_API_Hello_Controller {
 *
 * public function hello_world() {
 * return array(
 * "message" => "Hello, world"
 * );
 * }
 *
 * }
 *
 * ->
 *
 *
 */
namespace payload;

use core\reusable;

class jsonapiconfig extends reusable\jsonapi_base
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * change the api name accordingly
     */

    protected function get_controller_list()
    {
        return array(
            'campaign'
        );
    }

    /**
     * get the path of the api from the api folder
     * @return string
     */
    public static function get_json_cal_api_path()
    {
        return VCOIN_CAMPAIGN_PATH . "/payload/api/";
    }

    public function add_json_controllers()
    {
        add_filter('json_api_campaign_controller_path', function () {
            return jsonapiconfig::get_json_cal_api_path() . 'campaign.php';
        }, 11);
    }

    /**
     * do not edit this
     */
    public static function init()
    {
        new self();
    }



}


