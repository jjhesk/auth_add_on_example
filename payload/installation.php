<?php
/**
 * Created by PhpStorm.
 * User: Hesk
 * Date: 7/1/2015
 * Time: 11:27
 */
namespace payload;
use core\reusable\installation_base;
class installation_campaign extends installation_base
{
    private $db;
    private $api_tables;

    function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->construct_api_table_list(
            array(
                'campaign_people',
                'campaign_relationship'
            )
        );
    }

    protected function fake_drop_table()
    {
        // TODO: Implement fake_drop_table() method.
    }


    /**
     * drop tables
     */
    protected function drop_tables()
    {
        foreach ($this->api_tables as $key => $table) {
            $this->db->query("DROP TABLE IF EXISTS {$table};");
        }
    }

    /**
     * tutorial to getting the table code on the console.
     * install console debug bar
     * go to debug on the top right hand corner
     * go click on the console tab
     * choose the SQL tab
     * type in..
     *
     * show create table vapp_app_login_token_banks
     * show create table vapp_app_app_log
     * show create table vapp_app_action_reward
     * show create table vapp_oauth_api_consumers
     * ...
     *
     * copy and paste the code from there to here
     *
     * remove ` character
     *
     * create tables
     */
    public function create_tables()
    {
        $charset_collate = '';
        if ($this->db->has_cap('collation')) {
            $charset_collate .= 'ENGINE=InnoDB AUTO_INCREMENT=727 ';
            if (!empty($this->db->charset))
                $charset_collate = 'DEFAULT CHARACTER SET ' . $this->db->charset;
            if (!empty($this->db->collate))
                $charset_collate .= ' COLLATE ' . $this->db->collate;
        }

        $this->db->query(
            "CREATE TABLE IF NOT EXISTS {$this->api_tables['campaign_people']} (
             ID bigint(20) NOT NULL AUTO_INCREMENT,
             campagin_id bigint(20) NOT NULL,
             user_id bigint(20) NOT NULL,
             message text COLLATE utf8_unicode_ci NOT NULL,
             backers bigint(20) NOT NULL DEFAULT '0',
             flaged int(11) NOT NULL DEFAULT '-1',
             reward_gained int(11) NOT NULL DEFAULT '-1',
             reward_id int(11) NOT NULL DEFAULT '-1',
             coupon_id int(11) NOT NULL DEFAULT '-1',
             order int(11) NOT NULL,
             time_start timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
             PRIMARY KEY (ID),
             KEY ID (ID)
            ) $charset_collate;"
        );

        $this->db->query(
            "CREATE TABLE IF NOT EXISTS {$this->api_tables['campaign_relationship']} (
             ID bigint(20) NOT NULL AUTO_INCREMENT,
             backer_id bigint(20) NOT NULL,
             user_id bigint(20) NOT NULL,
             camp_id bigint(20) NOT NULL,
             PRIMARY KEY (ID)
            ) $charset_collate;"
        );

    }

    /**
     * DO NOT EDIT
     * @param $file_path
     * @internal param array $arr
     * @return mixed|void
     */
    public static function reg_hook($file_path)
    {
        $install_check = new self();
        $install_check->registration_plugin_hooks($file_path);
        $install_check = NULL;
    }

    /**
     * DO NOT EDIT
     * @internal param array $arr
     */
    public static function install_db_manually()
    {
        $k = new self();
        $k->create_tables();
        $k = NULL;
    }

}