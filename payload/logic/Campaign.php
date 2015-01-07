<?php

class Campaign extends SingleBase
{
    protected $table_contestant, $login_user, $campaign;

    protected function isType($type)
    {
        return $type == HKM_GAME_CAMPAIGN;
    }

    /**
     * @return array
     */
    public function getCampaignDetail()
    {
        return $this->content;
    }

    protected function getCampaignPeople($camp_id)
    {
        $r = $this->campaign->get_campaign_contestants($camp_id);
        $arr = array();
        if (count($r) > 0)
            foreach ($r as $R) {
                $contestant = new WP_User($R->user_id);
                $arr[] = array(
                    "user_id" => (int)$R->user_id,
                    "backers" => (int)$R->backers,
                    "wish" => $R->message,
                    "backed" => $this->campaign->backer_exist($this->login_user->ID, $R->user_id, $camp_id) > 0 ? 1 : 0,
                    "name" => userBase::getName($R->user_id),
                    "profilepic" => userBase::get_personal_profile_image($contestant)
                );
            }

        return $arr;
    }

    protected function beforeQuery()
    {
        global $current_user;
        $this->login_user = $current_user;
        $this->campaign = new CampaignBase();
    }

    protected function queryobject()
    {
        $title = get_the_title($this->post_id);
        $camp_id = (int)$this->post_id;
        $thumb = $this->get_product_image("campaign_horizontal");
        $thumb_nd = $this->get_product_image("campaign_vertical");
        $joined = $this->campaign->join_contestant_exist($this->login_user, $camp_id) ? 1 : 0;
        $active = (int)get_post_meta($this->post_id, "campaign_active", true);
        $contestants = $this->getCampaignPeople($camp_id);
        $start = get_post_meta($this->post_id, "start_date", true);
        $end = get_post_meta($this->post_id, "end_date", true);
        $votes = (int)get_post_meta($this->post_id, "total_votes", true);
        $desc = get_post_meta($this->post_id, "content_desc", true);
        return get_defined_vars();
    }
}
