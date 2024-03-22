<?php
namespace CloudsGoodsApp;

use CloudsGoodsApp\Hooks\Menu\CloudsGoodsAdminMenu;
use CloudsGoodsApp\Hooks\Actions\CloudsGoodsActionsHook;

class CloudsGoodsWidgetMainClass
{
    public function __construct()
    {
    }
    
    function registerCustomWidget() {
        register_widget( '\CloudsGoodsApp\Widget\CloudsGoodsWidgetClass' );
    }

    public function plugin_row_meta($plugin_meta, $plugin_file)
    {
        if($plugin_file === CLOUDSGOODS_PLUGIN_BASE){
            $row_meta = [
                'docs'  => 'https://cloudsgoods/plugin/docs',
                'ideo'  => 'https://cloudsgoods/plugin/video',
            ];
            
            $plugin_meta = array_merge($plugin_meta, $row_meta);
        }
        
        return $plugin_meta;
    }
    
    public function run()
    {
        $adminMenu = new CloudsGoodsAdminMenu();
        add_filter('plugin_row_meta', [&$this, 'plugin_row_meta'], 10, 4);
        add_action('admin_menu', [&$adminMenu, 'init'], 25);
        add_action( 'widgets_init', [&$this, 'registerCustomWidget']);
        
        $adminHooks = new CloudsGoodsActionsHook();
        $adminHooks->init();
        
    }
}