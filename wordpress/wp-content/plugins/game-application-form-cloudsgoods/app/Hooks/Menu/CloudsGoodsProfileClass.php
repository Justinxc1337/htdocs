<?php
namespace CloudsGoodsApp\Hooks\Menu;

use CloudsGoodsApp\Api\CloudsGoodsApiClass;

class CloudsGoodsProfileClass extends CloudsGoodsTarifClass
{
    /**
     * обработчик меню профиля
     */
    public function profileMenu()
    {
        $api = new CloudsGoodsApiClass();
        $result = $api->getUserAddress($this->apiKey);
        $array = $this->jsonToArray($result);
        if (count($array['data'] ?? []) > 0){
            $address = $array['data'][0];
        } else {
            $address = [];
        }

        $result = $api->getLegalEntity($this->apiKey);
        $array = $this->jsonToArray($result);
        if (count($array['data'] ?? []) > 0){
            $legal = $array['data'][0];
        } else {
            $legal = [];
        }
        $params = [
            'address' => $address,
            'legal'   => $legal,
        ];
        echo $this->blade->run("profile", $params);
    }
}
