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
class connect_json_api
{
    /**
     * change the api name accordingly
     *
     */
    private $list_functions = array(
        'campaign'
    );

    /**
     * get the path of the api from the api folder
     * @return string
     */
    public static function get_json_cal_api_path()
    {
        return VCOIN_CAMPAIGN_PATH . "payload/api";
    }

    /**
     * change the api name accordingly
     *
     */
    private function deploy_api()
    {
        if ($this->is_da_plugin_active()) {
            add_filter('json_api_campaign_controller_path', function () {
                return connect_json_api::get_json_cal_api_path() . 'campaign.php';
            });
            add_filter('json_api_controllers', array($this, 'add_json_controllers'), 10, 1);
        } else {
            $error = "Json-API is not activated please make sure that plugin is activated. Download it at http://wordpress.org/plugins/json-api/other_notes/";
            echo $error;
        }
    }


    /**
     * do not edit this
     */
    public static function init()
    {
        new self();
    }

    /**
     * do not edit this
     */
    public function __construct()
    {
        $this->deploy_api();
    }

    /**
     * do not edit this
     */
    public function __destruct()
    {
        $this->list_functions = NULL;
    }


    /**
     * do not edit this
     * @param $controllers
     * @return array
     */
    public function add_json_controller_new($controllers)
    {
        $controllers = array_merge($controllers, $this->list_functions);
        return $controllers;
    }

    /**
     * @param $controllers
     * @internal param $existing_controllers
     * @return array
     */
    public function add_json_controllers($controllers)
    {
        //$additional_controllers = array('channels', 'slide', 'email', 'staff', 'redemption', 'innopost');
        $controllers = array_merge($controllers, $this->list_functions);
        return $controllers;
    }

    /**
     * @return mixed
     */
    private function is_da_plugin_active()
    {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        return is_plugin_active('json-api/json-api.php');
    }

    /**
     * not in use first
     */
    public function add_to_core_functions()
    {
        // Disable get_author_index method (e.g., for security reasons)
        add_action('json_api-core-get_channel_from_core', 'my_disable_author_index');
        function my_disable_author_index()
        {
            // Stop execution
            exit;
        }
    }
}


