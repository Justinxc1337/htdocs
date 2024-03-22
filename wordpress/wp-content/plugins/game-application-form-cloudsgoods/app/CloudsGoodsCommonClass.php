<?php
namespace CloudsGoodsApp;

use eftec\bladeone;

class CloudsGoodsCommonClass
{
    protected $blade = null;
    protected $db = null;
    protected $apiKey = null;
    protected $table = '';
    
    protected function getApiKey()
    {
        $result = $this->db->get_row( "SELECT * FROM {$this->table} where optionid = 'api_key'");
        if ($result){
            $data = json_decode($result->data);
            $this->apiKey = $data->token ?? null;
        }
        
    }
    
    public function __construct() {
        global $baseDir;
        global $wpdb;
        $views = $baseDir.'/views';
        $compiled = $baseDir.'/compiled';
        $this->blade=new bladeone\BladeOne($views,$compiled);        
        $this->db = $wpdb;
        $this->table = $this->db->prefix.'cloudsgoods_data';
        $this->getApiKey();
        $GLOBALS['cgsrv_plugin_lang_id'] = 'en';
    }
    
    protected function jsonToArray($json)
    {
        if ($json){
            $contents = json_decode($json, true);
            if ($contents){
                return $contents;
            }
        }
        
        return [];
    }
    
    protected function getSanitizedInput($inputName, $default = '')
    {
        $input = sanitize_text_field($_POST[$inputName] ?? $default) ;
        
        return $input;
    }
}
