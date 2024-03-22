<?php
namespace CloudsGoodsApp\Hooks\Menu;

use CloudsGoodsApp\CloudsGoodsCommonClass;

class CloudsGoodsIssuePrizeClass extends CloudsGoodsCommonClass
{
    /**
     * обработчик меню статистики
     */
    public function issuePrizeMenu()
    {
        $params = [
        ];
        echo $this->blade->run("issue-prize", $params);
    }
    
}
