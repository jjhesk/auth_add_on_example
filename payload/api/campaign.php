<?php
/*
  Controller name: Campaign API
  Controller description: These APIs are dedicated for app-use <br>Author: Heskemo
 */

if (!class_exists('JSON_API_Campaign_Controller')) {
    class JSON_API_Campaign_Controller
    {
        /**
         * 1.Get listing of the campaign list and this history
         */

        public static function camp_list()
        {
            global $json_api;
            try {
                //  if (class_exists("json_auth_central")) {
                //      json_auth_central::auth_check_token_json();
                $Q = $json_api->query;
                //  if (!isset($Q->camp_id)) throw new Exception ("campaign ID  not exist", 1752);
                $cam = new CampaignList($Q);
                api_handler::outSuccessDataWeSoft($cam->getResultArr());

                ///  } else {
                //      throw new Exception("module not installed", 1007);
                //  }
            } catch (Exception $e) {
                api_handler::outFailWeSoft($e->getCode(), $e->getMessage());
            }
        }

        /**
         * 2. Get detail campaign with people listing showing
         */

        public static function camp_detail()
        {
            global $json_api;
            try {
                if (class_exists("json_auth_central")) {
                    json_auth_central::auth_check_token_json();
                    $Q = $json_api->query;
                    if (!isset($Q->camp_id)) throw new Exception ("campaign ID  not exist", 1752);
                    $cam = new Campaign($Q->camp_id);
                    api_handler::outSuccessDataWeSoft($cam->getCampaignDetail());

                } else {
                    throw new Exception("module not installed", 1007);
                }
            } catch (Exception $e) {
                api_handler::outFailWeSoft($e->getCode(), $e->getMessage());
            }

        }


        /**
         * 3. Action like to campaign person
         */
        public static function camp_action_back_who()
        {
            global $json_api, $current_user;
            try {
                if (class_exists("json_auth_central")) {
                    json_auth_central::auth_check_token_json();
                    $Q = $json_api->query;
                    if (!isset($Q->user_id)) throw new Exception ("campaign contestant not exist", 1751);
                    if (!isset($Q->camp_id)) throw new Exception ("campaign ID  not exist", 1752);

                    $cam = new CampaignBase();
                    list($transaction_reference,
                        $uuid_spender,
                        $backers) = $cam->back_now($current_user->ID, $Q->user_id, $Q->camp_id);

                    api_handler::outSuccessDataWeSoft(array(
                        "trace_id" => $transaction_reference,
                        "transact_amount" => 1,
                        "user_id" => $current_user->ID,
                        "backerupdate" => $backers,
                        "sender" => $uuid_spender
                    ));
                    //   api_handler::outSuccessDataWeSoft($trigger->get_result());
                } else {
                    throw new Exception("module not installed", 1007);
                }
            } catch (Exception $e) {
                api_handler::outFailWeSoft($e->getCode(), $e->getMessage());
            }
        }


        /**
         * 4. Get the active campaign banner now
         */
        public static function camp_banner()
        {
            global $json_api, $current_user;
            try {
                if (class_exists("json_auth_central")) {
                    json_auth_central::auth_check_token_json();
                    $Q = $json_api->query;
                    $cam = new CampaignList($Q);
                    //    $cam->yahoo();

                    api_handler::outSuccessDataWeSoft(array(
                        "title" => (int)$current_user->ID,
                        "thumb" => "You have just successfully joined the campaign",
                        "camp_id" => (int)$Q->camp_id
                    ));

                } else {
                    throw new Exception("module not installed", 1007);
                }
            } catch (Exception $e) {
                api_handler::outFailWeSoft($e->getCode(), $e->getMessage());
            }
        }


        /**
         * 3.3 Action to join the contest
         */
        public static function campaign_join()
        {
            global $json_api, $current_user;
            try {
                if (class_exists("json_auth_central")) {
                    json_auth_central::auth_check_token_json();
                    $Q = $json_api->query;
                    if (!isset($Q->wish)) throw new Exception ("campaign wish not exist", 1753);
                    if (!isset($Q->camp_id)) throw new Exception ("campaign ID  not exist", 1752);

                    $cam = new CampaignBase();
                    if ($cam->join_contestant_exist($current_user->ID, $Q->camp_id)) {
                        throw new Exception ("You have joined the campaign", 1754);
                    } else {
                        $cam->join_contest($current_user->ID, $Q->camp_id, $Q->wish);
                    }


                    api_handler::outSuccessDataWeSoft(array(
                        "user_id" => (int)$current_user->ID,
                        "message" => "You have just successfully joined the campaign",
                        "camp_id" => (int)$Q->camp_id
                    ));
                    //   api_handler::outSuccessDataWeSoft($trigger->get_result());
                } else {
                    throw new Exception("module not installed", 1007);
                }
            } catch (Exception $e) {
                api_handler::outFailWeSoft($e->getCode(), $e->getMessage());
            }
        }

    }
}