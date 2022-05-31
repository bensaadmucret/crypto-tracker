<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;


class ApiService
{
    private $client;
    public string $apiKey;
    public function __construct(HttpClientInterface $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }
  
    public function getApiData()
    {
       
        $response = $this->client->request(
            'GET',
            'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest',
            [
                'headers' => [
                    'X-CMC_PRO_API_KEY' => $this->apiKey
                ],
                'query' => [
                    'start' => 1,
                    'limit' => 10,
                    'convert' => 'EUR',
                ],
            ]
            
            
        );
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();
        $content = $response->toArray();
       
        if(empty($content)){
            throw new \Exception('Erreur dans le service ApiService');
        }
        return $content;
    }
       
}