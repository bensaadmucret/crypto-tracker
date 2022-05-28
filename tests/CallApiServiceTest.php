<?php

namespace App\Tests;

use App\Service\ApiService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;


class CallApiServiceTest extends TestCase
{
    // Test si phpunit est bien lancé
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }


    public function testCallApiService()
    {
        $client = new MockHttpClient([new MockResponse(
            '{"data":[{"id":1,"name":"Bitcoin","symbol":"BTC","slug":"bitcoin","circulating_supply":172800,"total_supply":172800,"max_supply":21000000,"date_added":"2013-04-28T00:00:00.000Z","num_market_pairs":876,"cmc_rank":1,"last_updated":"2019-10-31T16:00:02.000Z","quote":{"USD":{"price":8500.0,"volume_24h":1201.0,"percent_change_1h":0.0,"percent_change_24h":0.0,"percent_change_7d":0.0,"market_cap":8500.0,"last_updated":"2019-10-31T16:00:02.000Z"}}}]}'
        )]);
        $ApiService = new ApiService($client);

        $data = $ApiService->getApiData();
        $this->assertIsArray($data);
    }


    // Test si le service renvoie bien un tableau
    public function testCallApiServiceReturnArray()
    {
        $client = new MockHttpClient([new MockResponse(
            '{"data":[{"id":1,"name":"Bitcoin","symbol":"BTC","slug":"bitcoin","circulating_supply":172800,"total_supply":172800,"max_supply":21000000,"date_added":"2013-04-28T00:00:00.000Z","num_market_pairs":876,"cmc_rank":1,"last_updated":"2019-10-31T16:00:02.000Z","quote":{"USD":{"price":8500.0,"volume_24h":1201.0,"percent_change_1h":0.0,"percent_change_24h":0.0,"percent_change_7d":0.0,"market_cap":8500.0,"last_updated":"2019-10-31T16:00:02.000Z"}}}]}'
        )]);
        $ApiService = new ApiService($client);

        $data = $ApiService->getApiData();
        $this->assertIsArray($data);
    }

    // test de la levée d'exception si le service renvoie un tableau vide
    public function testCallApiServiceThrowException()
    {
        $this->expectException(\Exception::class);
        $client = new MockHttpClient([new MockResponse(
            
        )]);
        $ApiService = new ApiService($client);

        $data = $ApiService->getApiData();
        $this->assertIsArray($data);
    }

    

  

}
