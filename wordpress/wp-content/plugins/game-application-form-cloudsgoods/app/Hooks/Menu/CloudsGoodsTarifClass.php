<?php
namespace CloudsGoodsApp\Hooks\Menu;

use CloudsGoodsApp\Api\CloudsGoodsApiClass;

class CloudsGoodsTarifClass extends CloudsGoodsMyGamesClass
{
    /**
     * обработчик меню тарифов
     */
    public function tarifMenu()
    {
        $api = new CloudsGoodsApiClass();
        $result = $api->getTarifDescription($this->apiKey);
        $activeGames = $this->jsonToArray($api->getMyGamesByStatus($this->apiKey, 'active'));
        $data = $this->jsonToArray($result);
        //hardcode prices (temporary)
        if ($data['data'][0] ?? null){
            $data['data'][0]['price'] = 'FREE';
        }
        if ($data['data'][1] ?? null){
            $data['data'][1]['price'] = '$19';
        }
        if ($data['data'][2] ?? null){
            $data['data'][2]['price'] = '$79';
        }
        if ($data['data'][3] ?? null){
            $data['data'][3]['price'] = '$149';
        }
        $limits = $this->jsonToArray($api->getUserLimits($this->apiKey));
        $params = [
            'data'  => $data['data'],
            'token' => $this->apiKey,
            'phoneCount' => $limits['data'] ? ($limits['data'][0] ? $limits['data'][0]['phone_account'] : 0) : 0,
            'emailCount' => $limits['data'] ? ($limits['data'][0] ? $limits['data'][0]['email_account'] : 0) : 0,
            'activeGames' => $activeGames,
        ];
        echo $this->blade->run("tarif", $params);
    }
    
}
