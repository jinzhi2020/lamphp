<?php

namespace Lamp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\StreamInterface;

/**
 * Class HttpClient
 * @package Lamp
 */
class HttpClient
{

    /**
     * 发送 GET 请求
     * @param string $url
     * @param array $data
     * @param string|null $authorization
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function get(string $url, ?string $authorization, array $data = []): StreamInterface
    {
        $client = new Client();
        $response = $client->request('GET', $url, [
            'query' => $data,
            'headers' => [
                'Authorization' => $authorization ?? '',
            ],
        ]);

        return $response->getBody();
    }

    /**
     * 发送 POST 请求
     * @param string $url
     * @param array $data
     * @param string|null $authorization
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function post(string $url, ?string $authorization, array $data = []): StreamInterface
    {
        $client = new Client();
        $response = $client->request('post', $url, [
            'form_params' => $data,
            'headers' => [
                'Authorization' => $authorization ?? '',
            ],
        ]);

        return $response->getBody();
    }
}
