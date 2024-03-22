<?php
namespace CloudsGoodsApp\Hooks\Menu;

class CloudsGoodsGeneralMenuClass extends CloudsGoodsCreateGameClass
{
    /**
     * Обработчик главного меню
     * @global type $wpdb
     */
    public function generalMenu()
    {
        global $wpdb;
        
        $user_id = null;
        $userName = null;
        $userPassword = null;

        $auth = $this->db->get_row("select * from {$this->table} where optionid = 'api_key'");
        
        if ($auth){
            $data = json_decode($auth->data);
            $userName = $data->login ?? null;
            $userPassword = $data->password ?? null;
        }
        
        $params = [
            'user_id'   => $user_id,
            'userName'  => $userName,
            'userPassword'  => $userPassword,
            'key'       => $this->apiKey,
        ];
        
        echo $this->blade->run("admin", $params);
    }
    
    // shall be in config!!!
    protected $ru = [
        'page_title'    => 'Clouds Goods',
        'capability'    => 'administrator',
        'slug'          => 'cgsrv_menu_adminpage',
        'icon'          => CLOUDSGOODS_PLUGIN_URL.'/logo-icon.png',
        'function'      => 'generalMenu',
        'submenu'       => [
            'Создание игры' => [
                'page_title'    => 'Создание игры страница',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagecreategame',
                'function'      => 'createMenu',
            ],
            /*
            'Статистика' => [
                'page_title'    => 'Статистика страница',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagestat',
                'function'      => 'statMenu',
            ],
            'Настройка виджета' => [
                'page_title'    => 'Настройка виджета страница',
                'capability'    => 'administrator',
                'slug'          => 'cg_menu_adminpagewidget',
                'function'      => 'widgetMenu',
            ],
             */
            'Профиль' => [
                'page_title'    => 'Профиль страница',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpageprofile',
                'function'      => 'profileMenu',
            ],
            'Тарифы' => [
                'page_title'    => 'Тарифы страница',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagetarif',
                'function'      => 'tarifMenu',
            ],
            'Мои игры' => [
                'page_title'    => 'Мои игры страница',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagemygames',
                'function'      => 'myGamesMenu',
            ],
            'Контакты' => [
                'page_title'    => 'Контакты страница',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagecontacts',
                'function'      => 'contactsMenu',
            ],
            'Выдача призов' => [
                'page_title'    => 'Выдача призов',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpageissueprize',
                'function'      => 'issuePrizeMenu',
            ],
        ],
    ];
    
    protected $en = [
        'page_title'    => 'Clouds Goods',
        'capability'    => 'administrator',
        'slug'          => 'cgsrv_menu_adminpage',
        'icon'          => CLOUDSGOODS_PLUGIN_URL.'/logo-icon.png',
        'function'      => 'generalMenu',
        'submenu'       => [
            'Create Game' => [
                'page_title'    => 'Game creation page',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagecreategame',
                'function'      => 'createMenu',
            ],
            /*
            'Statistics' => [
                'page_title'    => 'Statistics page',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagestat',
                'function'      => 'statMenu',
            ],
            'Widget settings' => [
                'page_title'    => 'Widget settings',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagewidget',
                'function'      => 'widgetMenu',
            ],
             */
            'Profile' => [
                'page_title'    => 'User profile page',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpageprofile',
                'function'      => 'profileMenu',
            ],
            'Packages' => [
                'page_title'    => 'Package list',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagetarif',
                'function'      => 'tarifMenu',
            ],
            'My Games' => [
                'page_title'    => 'My Games page',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagemygames',
                'function'      => 'myGamesMenu',
            ],
            'Contacts' => [
                'page_title'    => 'Contacts gathered by games',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpagecontacts',
                'function'      => 'contactsMenu',
            ],
            'Issue prizes' => [
                'page_title'    => 'manage prizes',
                'capability'    => 'administrator',
                'slug'          => 'cgsrv_menu_adminpageissueprize',
                'function'      => 'issuePrizeMenu',
            ],
        ],
    ];
    
    
}
