<?php

/**
 * Created by PhpStorm.
 * User: Hesk
 * Date: 7/1/2015
 * Time: 11:21
 */
class CampaignList extends listBase
{
    private $config = array();
    private $result = array();
    private $query = array();

    public function  __construct($Q)
    {
        $arr = array();
        /*
        if (!isset($Q->cat))
               throw new Exception("Missing category id", 1810);
           else {
               if (intval($Q->cat) != -1) {
                   $category = intval($Q->cat);
                   $arr['category__in'] = $category;
               }
           }
        */
        //  $arr["order"] = "desc";
        $this->config = array(
            "post_type" => HKM_GAME_CAMPAIGN,
            "posts_per_page" => -1,
            'post_status' => 'publish',
            'orderby' => 'date',
        );

        $this->doQuery(wp_parse_args($arr, $this->config));
    }

    /**
     * you can edit this part for each item.
     * @param $id
     * @param array $args
     * @return array
     */
    protected function inDaLoop($id, $args = array())
    {
        return array(
            "camp_id" => (int)$id,
            "thumb" => $this->display_images("campaign_horizontal", $id),
            "thumb_nd" => $this->display_images("campaign_vertical", $id),
            "title" => get_the_title($id),
            "active" => (int)get_post_meta($id, "campaign_active", true)
            // "vcoin" => intval(get_post_meta($id, "campaign_active", true))
        );
    }
}