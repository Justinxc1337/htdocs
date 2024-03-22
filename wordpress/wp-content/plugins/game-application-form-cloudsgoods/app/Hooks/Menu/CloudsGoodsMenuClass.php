<?php
namespace CloudsGoodsApp\Hooks\Menu;

use CloudsGoodsApp\Api\CloudsGoodsApiClass;

class CloudsGoodsMenuClass extends CloudsGoodsGeneralMenuClass
{
    protected $menu = [       // структура меню
        'CloudsGoods'   => [
        ],
    ];

    public function __construct() {
        parent::__construct();
        $this->menu['CloudsGoods'] = $this->en;
    }
    protected function validateKey()
    {
        $api = new CloudsGoodsApiClass();
        $reply = json_decode($api->validateToken($this->apiKey), true);
        if ($reply['error'] ?? null){
            add_action( 'admin_init', [&$this, 'redirectToMain'] );
        }
    }
    
    public function redirectToMain()
    {
        $page = sanitize_text_field($_GET["page"]) ?? '';
        if (str_starts_with($page, 'cgsrv_menu_') && ($page != 'cgsrv_menu_adminpage')){
            header( 'Location: /wp-admin/admin.php?page=cgsrv_menu_adminpage' );
        }
    }
    
    
    /**
     * Создаёт меню в соответствии с заданной в массиве структурой
     * @param type $menu
     * @param type $parentSlug
     */
    protected function buildMenu($menu = null, $parentSlug = null)
    {
        if (!$menu){
            $menu = $this->menu;
        }
        $this->validateKey();
        foreach($menu as $menuTitle => $item){
            if (!$parentSlug){
                add_menu_page($item['page_title'], $menuTitle, $item['capability'], $item['slug'], [&$this, $item['function']], $item['icon']);
                if ($item['submenu'] ?? null){
                    $this->buildMenu($item['submenu'], $item['slug']);
                }
            } else {
                add_submenu_page($parentSlug, $item['page_title'], $menuTitle, $item['capability'], $item['slug'], [&$this, $item['function']]);
            }
        }
    }
    
}
