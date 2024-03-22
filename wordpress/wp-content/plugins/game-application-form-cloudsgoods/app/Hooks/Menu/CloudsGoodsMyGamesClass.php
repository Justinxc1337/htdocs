<?php
namespace CloudsGoodsApp\Hooks\Menu;

class CloudsGoodsMyGamesClass extends CloudsGoodsContactsClass
{
    /**
     * обработчик меню 'Мои игры'
     */
    public function myGamesMenu()
    {
        $params = [
            'token' => $this->apiKey,
        ];
        echo $this->blade->run("mygames", $params);
    }
    
}
