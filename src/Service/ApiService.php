<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;


class ApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getApiData()
    {


        $response = $this->client->request(
            'GET',
            'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest',
            [
                'headers' => [
                    'X-CMC_PRO_API_KEY' => 'afc02c85-196c-4b82-8bf8-8ce9d1a83d1a',
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