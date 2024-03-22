<?php
namespace CloudsGoodsApp\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Post\PostFile;

class CloudsGoodsApiClass
{
    protected $client = null;
    protected $errorText = '';
    protected $apiBase = 'https://cloudsgoods.com/api/';
    public function __construct()
    {
        $this->client = new Client();
    }
    
    public function getErrorText()
    {
        return $this->errorText;
    }
    
    protected function doRequest($method, $endpoint, $data, $headers = [], $raw = false, $multipart = false)
    {
        $params = [];
        
        if ($GLOBALS['cgsrv_plugin_lang_id'] ?? null){
            $headers['lang'] = $GLOBALS['cgsrv_plugin_lang_id'];
        }
        
        try {
            if ($method == 'GET'){
                $params = [
                    'query'   => $data,
                    'headers' => $headers,
                ];
            } else
            if (!$multipart){
                $params = [
                    'form_params'   => $data,
                    'headers'       => $headers,
                ];
            } else {
                $params = [
                    'multipart'   => $data,
                    'headers'     => $headers,
                ];
            }
            
            $result = $this->client->request($method, $this->apiBase.$endpoint,$params);
        } catch(RequestException $e) {
            $response = $e->getResponse();
            if ($response) {
                $content = $response->getBody()->getContents();
                $this->errorText = $content;
                return $content;
            }
            return false;
        }
        $content = $result->getBody()->getContents();
        if ($raw){
            $headers = '';
            $hdrArray = $result->getHeaders();
            foreach($hdrArray as $name=>$value){
                $headers .= "$name: {$value[0]}\r\n";
            }
            return "$headers\r\n$content";
        }
        $json = json_decode($content);

        return wp_json_encode($json);
    }
    
    public function auth(string $login, string $password)
    {
        $data = [
            'login'     => $login,
            'password'  => $password,
        ];
        
        return $this->doRequest('POST', 'auth', $data);
    }

    public function getContacts($key, $data = [])
    {
        if (!($data['per_page'] ?? null)){
            $data['per_page'] = 30;
        }
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'mailingcontacts', $data, $headers);
    }

    public function validateToken($key)
    {
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        $data = [];
        
        return $this->doRequest('GET', 'validatetoken', $data, $headers);
    }
    
    public function downloadContacts($key)
    {
        
        $data['type'] = 'download';
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'mailingcontacts', $data, $headers);
    }
    
    public function getPrizeList($key, $data = [])
    {
        
        if (!($data['per_page'] ?? null)){
            $data['per_page'] = 30;
        }
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'prize', $data, $headers);
    }
    
    public function issuePrize($key, $id)
    {
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        $data = [
            'id'            => $id,
            'received'      => 1,
            'received_at'   => time(),
        ];
        return $this->doRequest('POST', 'prize', $data, $headers);
    }

    public function getUserAddress($key)
    {
        $data = [
        ];
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'useraddress', $data, $headers);
    }

    public function getUserLimits($key)
    {
        $data = [
        ];
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'userlimits', $data, $headers);
    }
    
    public function stopAll($key)
    {
        $data = [
            'type'  => 'stopall',
        ];
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('POST', 'gamestock', $data, $headers);
    }

    public function getLegalEntity($key)
    {
        $data = [
        ];
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'legalentity', $data, $headers);
    }

    public function getTarifs($key)
    {
        $data = [
        ];
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'tarif', $data, $headers);
    }

    public function getTarifDescription($key)
    {
        $data = [
        ];
                
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'tarifdescription', $data, $headers);
    }

    public function getMyGames($key, int $page = 0, int $perPage = 30)
    {
        $data = [
            'page'     => $page,
            'per_page' => $perPage,
            'my'       => 1,
            'order'    => 1,
        ];
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'gamestock', $data, $headers);
    }
    
    public function getMyGamesByStatus($key, $status, int $page = 0, int $perPage = 30)
    {
        $data = [
            'page'     => $page,
            'per_page' => $perPage,
            'my'       => 1,
            'order'    => 1,
            'byStatus' => $status,
        ];
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'gamestock', $data, $headers);
    }
    
    public function delMyGame($key, $id = 0)
    {
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        $data = [];

        return $this->doRequest('DELETE', "gamestock/$id", $data, $headers);
    }

    public function editProfile($key, $data)
    {
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];

        return $this->doRequest('POST', "profile", $data, $headers);
    }

    public function copyMyGame($key, $id = 0)
    {
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        $data = [
            'id'    => $id,
            'type'  => 'copy',
        ];

        return $this->doRequest('POST', 'gamestock', $data, $headers);
    }
    
    public function getInfo($key, $data = [])
    {
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];

        return $this->doRequest('GET', 'issues', $data, $headers);
    }

    public function getGameStats($key, $stock)
    {
        $data = [
            'stock' => $stock,
            'type'  => 'detail',
        ];
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];

        return $this->doRequest('GET', 'statistics', $data, $headers);
    }
    
    
    public function getGames($key, string $page, string $perPage)
    {
        $data = [
            'page'      => $page,
            'per_page'  => $perPage,
        ];
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', 'games', $data, $headers);
    }
    
    public function createGameStock($key, array $params)
    {
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        $params['type'] = 'raw';
        $data = [];
        foreach($params as $key=>$value){
            $element = [
                'name'  => $key,
                'contents'  => $value,
            ];
            if ($key == 'logo'){            
                $element['filename'] = 'logo.jpg';
            }
            $data[] = $element;
        }

        return $this->doRequest('POST', 'gamestock', $data, $headers, false, true);
    }
    
    public function editGameStock($key, array $params)
    {
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        $params['type'] = 'edit';
        $data = [];
        foreach($params as $key=>$value){
            $element = [
                'name'  => $key,
                'contents'  => $value,
            ];
            $data[] = $element;
        }

        return $this->doRequest('POST', 'gamestock', $data, $headers, false, true);
    }
    
    public function createGood($key, $title, $price, $link, $image)
    {
        $data = [
            [
                'name'  => 'price',
                'contents'  => $price,
            ],
            [
                'name'  => 'price',
                'contents'  => $title,
            ],
            [
                'name'  => 'type',
                'contents'  => 'isolated',
            ],
            [
                'name'  => 'image',
                'filename' => 'image.jpg',
                'contents'  => $image,
            ],
        ];
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('POST', 'userproduct', $data, $headers, false, true);
    }
    
    public function listGoods($key, $page, $perPage)
    {
        $data = [
        ];
        
        $headers = [
            'x-api-token'   => $key ?? '0',
        ];
        
        return $this->doRequest('GET', "userproduct?type=isolated", $data, $headers);
    }
        
}