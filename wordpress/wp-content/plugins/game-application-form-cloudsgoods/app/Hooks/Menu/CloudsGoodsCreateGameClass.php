<?php
namespace CloudsGoodsApp\Hooks\Menu;

use CloudsGoodsApp\Api\CloudsGoodsApiClass;

class CloudsGoodsCreateGameClass extends CloudsGoodsStatClass
{
    /**
     * обработчик меню создания игр
     */
    public function createMenu()
    {
        $api = new CloudsGoodsApiClass();
        $result = $api->getPrizeList($this->apiKey);
        $allPrize = $this->jsonToArray($result);
        $params = [
        ];
        echo $this->blade->run("creategame/main.blade.php", $params);
    }
    
    
}
