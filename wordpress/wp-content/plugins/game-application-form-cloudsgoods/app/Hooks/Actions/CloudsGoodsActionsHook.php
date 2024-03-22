<?php
namespace CloudsGoodsApp\Hooks\Actions;

use CloudsGoodsApp\Api\CloudsGoodsApiClass;
use CloudsGoodsApp\CloudsGoodsCommonClass;

class CloudsGoodsActionsHook extends CloudsGoodsCommonClass
{
    protected $defaultPageItemsCount = 20;

    protected $resultCodes = [
        'auth'  => [
            'success'   => '{"success":"Успешный вход"}',
            'failure'   => '{"error":"неверный логин или пароль"}',
        ],
    ];

    /**
     * Get list of available games
     * echoes JSON result
     */
    public function getGames()
    {
        $page = (int)$this->getSanitizedInput('cg_page', 1);
        $perPage = (int)$this->getSanitizedInput('cg_per_page', $this->defaultPageItemsCount);
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->getGames($this->apiKey, $page, $perPage);
    }

    /**
     * Logs in
     * echoes back either success or failure JSON
     */
    public function getToken()
    {
        $login = sanitize_email($this->getSanitizedInput('cg_login', null));
        $password = $this->getSanitizedInput('cg_password', null);
        $api = new CloudsGoodsApiClass();
        $result = $api->auth($login, $password);
        if ($result){
            $json = json_decode($result, true);
            if ($json['token'] ?? null){
                $authData = [
                    'token'    => $json['token'],
                    'login'    => $login,
                    'password' => str_repeat("*", strlen($password)),
                ];
                $data = [
                    'optionid' => 'api_key',
                    'data'      => json_encode($authData),
                ];
                $dbRes = $this->db->update(
                    $this->table,
                    $data,
                    [
                        'optionid' => 'api_key',
                    ]
                );
                if ($dbRes === false || $dbRes < 1) {
                    $this->db->insert($this->table, $data);
                }
                echo $this->resultCodes['auth']['success'];
                return;
            }
        }

        echo $this->resultCodes['auth']['failure']; // result is a JSON string; esc_html will destroy it
    }

    /**
     * shows requested page for create action module
     * echoes blade
     */
    public function getCreateGameView()
    {
        $api = new CloudsGoodsApiClass();
        $reply = json_decode($api->validateToken($this->apiKey), true);

        if ($reply['error'] ?? null){
            $code=401;
            $protoGlobal = $this->getSanitizedInput($_SERVER['SERVER_PROTOCOL'] ?? null, null);
            $protocol = ($protoGlobal ? $protoGlobal : 'HTTP/1.0');
            $text = 'API key is invalid';
            header($protocol . ' ' . $code . ' ' . $text);
            $GLOBALS['http_response_code'] = $code;

            return;
        }
        $id = $this->getSanitizedInput('cg_create_view_id', '');

        $params = [
        ];
        
        echo $this->blade->run("creategame/$id.blade.php", $params); // on invalid $id there will be error message from blade; views are not showing user data - no need to esc_html
    }

    /**
     * creates game action
     * echoes back JSON with resulting record
     */
    public function createGameStock()
    {
        $api = new CloudsGoodsApiClass();
        $cgDate = (int)$this->getSanitizedInput('cg_date', 0);
        $cgCalendar = (int)$this->getSanitizedInput('cg_calendar', 0);
        if (!($_FILES['cg_logotype'] ?? null)){
            echo '{"error":"Missing logo"}';
        }
        $luckyPlace = (int)$this->getSanitizedInput('cg_lucky_prize', 0);
        $startDate = ($cgDate == 1) ? time() : $cgCalendar;
        $params = [
            'game_id'       => (int)$this->getSanitizedInput('cg_game_id', 0),
            'stockType'     => (int)$this->getSanitizedInput('cg_stock_type', 0),
            'company_slogan'=> (int)$this->getSanitizedInput('cg_slogan', 0),
            'reg_type'      => $this->getSanitizedInput('cg_collection', 'email'),
            'start_date'    => $startDate,
            'end_date'      => $startDate + (int)$this->getSanitizedInput('cg_days', 0) * (60*60*24),
            'logo'          => file_get_contents($_FILES['cg_logotype']['tmp_name']),
            'goods'         => html_entity_decode( stripslashes ($this->getSanitizedInput('cg_goods'))),
            'prizes'        => html_entity_decode( stripslashes ($this->getSanitizedInput('cg_prizes'))),
            'play'          => (int)$this->getSanitizedInput('cg_play', 0),

        ];
        // simple data validation provided here, just to comply the rules. On the API side there is 
        // strong chained and conditional request validation implemented
        // API filters result with wp_json_encode
        echo $api->createGameStock( $this->apiKey, $params);
    }

    /**
     * creates new good
     * echoes back JSON with resulting record
     */
    public function createGood()
    {
        if (!($_FILES['cg_image'] ?? null)){
            echo '{"error":"M issing image of good"}';
        }
        $title = $this->getSanitizedInput('cg_title');
        $price = $this->getSanitizedInput('cg_price');
        $link  = $this->getSanitizedInput('cg_link');
        $image = file_get_contents($_FILES['cg_image']['tmp_name']);
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->createGood($this->apiKey, $title, $price, $link, $image);
    }

    /**
     * shows a list of loaded goods
     * echoes back JSON list
     */
    public function listGoods()
    {
        $page = (int)$this->getSanitizedInput('cg_page', 1);
        $perPage = (int)$this->getSanitizedInput('cg_per_page', $this->defaultPageItemsCount);
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->listGoods($this->apiKey, $page, $perPage);
    }

    /**
     * editing game action
     * echoes back JSON with resulting record
     */
    public function editGameStock()
    {
        $api = new CloudsGoodsApiClass();
        $data = [
            'id'    => (int)$this->getSanitizedInput('cg_game_stock_id', 0),
        ];
        $data['game_id'] = (int)$this->getSanitizedInput('cg_game_id', null);
        $data['status'] = $this->getSanitizedInput('cg_game_status', null);
        // API filters result with wp_json_encode
        echo $api->editGameStock($this->apiKey, $data);
    }

    /**
     * shows a list of game actions created by user
     * echoes back JSON list
     */
    public function getGameStock()
    {
        $page = (int)$this->getSanitizedInput('cg_page', 1);
        $perPage = (int)$this->getSanitizedInput('cg_per_page', $this->defaultPageItemsCount);
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->getMyGames($this->apiKey, $page, $perPage);
    }

    /**
     * shows a list of game actions created by user
     * echoes back JSON list
     */
    public function gamesByStatus()
    {
        $page = (int)$this->getSanitizedInput('cg_page', 1);
        $perPage = (int)$this->getSanitizedInput('cg_per_page', $this->defaultPageItemsCount);
        $status = $this->getSanitizedInput('cg_game_status', 'active');
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->getMyGamesByStatus($this->apiKey, $status, $page, $perPage);
    }

    /**
     * shows a list of prises, assigned for actions
     * echoes back JSON list
     */
    public function getPrizeList()
    {
        $page = (int)$this->getSanitizedInput('cg_page', 1);
        $perPage = (int)$this->getSanitizedInput('cg_per_page', $this->defaultPageItemsCount);
        $api = new CloudsGoodsApiClass();
        $data = [
            'page'      => $page,
            'per_page'  => $perPage,
        ];
        $data['filter'] = $this->getSanitizedInput('cg_filter', null);
        $data['received'] = $this->getSanitizedInput('cg_received', null);
        // API filters result with wp_json_encode
        echo $api->getPrizeList($this->apiKey, $data);
    }

    /**
     * Issue a prize by its number
     * echoes back JSON result
     */
    public function issuePrize()
    {
        $id = (int)$this->getSanitizedInput('cg_prize_id', 0);
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->issuePrize($this->apiKey, $id);
    }

    /**
     * shows a list of gathered contacts
     * echoes back JSON list
     */
    public function getContactList()
    {
        $page = (int)$this->getSanitizedInput('cg_page', 1);
        $perPage = (int)$this->getSanitizedInput('cg_per_page', $this->defaultPageItemsCount);
        $api = new CloudsGoodsApiClass();
        $data = [
            'page'      => $page,
            'per_page'  => $perPage,
        ];

        $data['filter'] = $this->getSanitizedInput('cg_filter', null);
        $data['after'] = $this->getSanitizedInput('cg_from_date', null);
        $data['before'] = $this->getSanitizedInput('cg_to_date', null);
        // API filters result with wp_json_encode
        echo $api->getContacts($this->apiKey, $data);
    }

    /**
     * generates a file with gathered contacts
     * echoes back a file
     */
    public function downloadContacts()
    {
        $data = [];
        $data['filter'] = $this->getSanitizedInput('cg_filter', null);
        $data['after'] = $this->getSanitizedInput('cg_from_date', null);
        $data['before'] = $this->getSanitizedInput('cg_to_date', null);

        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->downloadContacts($this->apiKey, $data);
    }

    /**
     * editing user profile
     * echoes back a JSON result
     */
    public function editProfile()
    {
        $api = new CloudsGoodsApiClass();
        $data = [
            'country'         => $this->getSanitizedInput('cg_profile_country', null),
            'email'           => sanitize_email($this->getSanitizedInput('cg_profile_email', null)),
            'phone'           => $this->getSanitizedInput('cg_profile_phone', null),
            'address'         => $this->getSanitizedInput('cg_profile_address', null),
            'company'         => $this->getSanitizedInput('cg_company', null),
            'inn'             => $this->getSanitizedInput('cg_inn', null),
            'trade_mark'      => $this->getSanitizedInput('cg_trade_mark', null),
            'slogan'          => $this->getSanitizedInput('cg_slogan', null),
        ];
        // API filters result with wp_json_encode
        echo $api->editProfile($this->apiKey, $data);
    }
    
    /**
     * delete game action
     * echoes back a JSON result
     */
    public function delGameStock()
    {
        $id = (int)$this->getSanitizedInput('cg_game_stock_id', 0);
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->delMyGame($this->apiKey, $id);
    }

    /**
     * create a new instance of a game action, identical to a given one
     * echoes back a JSON result
     */
    public function copyGameStock()
    {
        $id = (int)$this->getSanitizedInput('cg_game_stock_id', 0);
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->copyMyGame($this->apiKey, $id);
    }

    /**
     * gives a requested FAQ part
     * echoes back a JSON result
     */
    public function getFaq()
    {
        $data = [];
        $data['id'] = (int)$this->getSanitizedInput('cg_issue_id', 0);
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->getInfo($this->apiKey, $data);
    }

    /**
     * validates current token
     * echoes back a JSON result
     */
    public function validateToken()
    {
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->validateToken($this->apiKey);
    }

    /**
     * logging out
     * echoes back a JSON result
     */
    public function logout()
    {
        $result = $this->db->get_row( "SELECT * FROM {$this->table} where optionid = 'api_key'");
        if ($result){
            $payload = json_decode($result->data, true);
            $payload['token'] = null;
            $data = [
                'data'  => json_encode($payload),
            ];
            $this->db->update(
                $this->table,
                $data,
                [
                    'optionid' => 'api_key',
                ]
            );
        }

        echo '{"success":true}';
    }

    /**
     * giving user limits on phones and emails gathering
     * echoes back a JSON result
     */
    public function getUserLimits()
    {
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->getUserLimits($this->apiKey);
    }

    /**
     * giving user limits on phones and emails gathering
     * echoes back a JSON result
     */
    public function closeAll()
    {
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->stopAll($this->apiKey);
    }

    public function gameStatistics()
    {
        $stock = (int)$this->getSanitizedInput('cg_game_stock_id', 0);
        $api = new CloudsGoodsApiClass();
        // API filters result with wp_json_encode
        echo $api->getGameStats($this->apiKey, $stock);
    }

    /**
     * assign function names
     */
    public function init()
    {
        add_action( 'admin_post_cgsrv_get_token', [&$this, 'getToken'] );
        add_action( 'admin_post_cgsrv_get_create_view', [&$this, 'getCreateGameView'] );
        add_action( 'admin_post_cgsrv_get_games', [&$this, 'getGames'] );
        add_action( 'admin_post_cgsrv_download_contacts', [&$this, 'downloadContacts'] );
        add_action( 'admin_post_cgsrv_create_gamestock', [&$this, 'createGameStock'] );
        add_action( 'admin_post_cgsrv_create_good', [&$this, 'createGood'] );
        add_action( 'admin_post_cgsrv_list_goods', [&$this, 'listGoods'] );
        add_action( 'admin_post_cgsrv_edit_game_stock', [&$this, 'editGameStock'] );
        add_action( 'admin_post_cgsrv_edit_profile', [&$this, 'editProfile'] );
        add_action( 'admin_post_cgsrv_get_game_stock', [&$this, 'getGameStock'] );
        add_action( 'admin_post_cgsrv_prize_list', [&$this, 'getPrizeList'] );
        add_action( 'admin_post_cgsrv_contact_list', [&$this, 'getContactList'] );
        add_action( 'admin_post_cgsrv_issue_prize', [&$this, 'issuePrize'] );
        add_action( 'admin_post_cgsrv_del_game_stock', [&$this, 'delGameStock'] );
        add_action( 'admin_post_cgsrv_copy_game_stock', [&$this, 'copyGameStock'] );
        add_action( 'admin_post_cgsrv_info_faq', [&$this, 'getFaq'] );
        add_action( 'admin_post_cgsrv_validate_token', [&$this, 'validateToken'] );
        add_action( 'admin_post_cgsrv_logout', [&$this, 'logout'] );
        add_action( 'admin_post_cgsrv_user_limits', [&$this, 'getUserLimits'] );
        add_action( 'admin_post_cgsrv_closeall_games', [&$this, 'closeAll'] );
        add_action( 'admin_post_cgsrv_games_by_status', [&$this, 'gamesByStatus'] );
        add_action( 'admin_post_cgsrv_get_game_statistics', [&$this, 'gameStatistics'] );
    }

}
