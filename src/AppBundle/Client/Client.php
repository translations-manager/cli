<?php

namespace AppBundle\Client;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var int
     */
    private $port;

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * @param array $serverConfig
     */
    public function __construct(array $serverConfig)
    {
        $this->baseUrl = $serverConfig['host'];
        $this->port = $serverConfig['port'];
        $this->client = new GuzzleClient;
    }

    /**
     * @param string $uri
     * @param array $options
     *
     * @return string
     */
    public function get($uri, $options = [])
    {
        $response = $this
            ->client
            ->get(sprintf('%s:%d/%s', $this->baseUrl, $this->port, $uri), $options)
            ->getBody()
            ->getContents()
        ;

        return json_decode($response);
    }

    /**
     * @param string $uri
     * @param array $options
     *
     * @return string
     */
    public function post($uri, $options = [])
    {
        $response = $this
            ->client
            ->post(sprintf('%s:%d/%s', $this->baseUrl, $this->port, $uri), $options)
            ->getBody()
            ->getContents()
        ;

        return json_decode($response);
    }
}
