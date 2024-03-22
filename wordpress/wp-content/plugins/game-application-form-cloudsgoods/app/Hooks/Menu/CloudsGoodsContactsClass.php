<?php
namespace CloudsGoodsApp\Hooks\Menu;

class CloudsGoodsContactsClass extends CloudsGoodsIssuePrizeClass
{
    /**
     * обработчик меню Контакты
     */
    public function contactsMenu()
    {
        $params = [
        ];

        echo $this->blade->run("contacts", $params);
    }
    
}
