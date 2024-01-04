<?php

/*
 * CopyRight  : (C)2012-2099 HaoTeam Inc.
 * Document   : HttpService.php
 * Created on : 2024-1-4  14:37:15
 * Author     : Tiger <1192851302@qq.com>
 * Description: This is NOT a freeware, use is subject to license terms.
 *              这即使是一个免费软件,使用时也请遵守许可证条款,得到当时人书面许可.
 *              未经书面许可,不得翻版,翻版必究;版权归属 HaoTeam Inc;
 */

namespace HaoTeam\HmBuyer\Http;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

/**
 * Description of HttpService
 *
 * @author tiger <1192851302@qq.com>
 * @datetime 2024-1-4  14:37:15
 */
class HttpService {

    protected $base_uri = '';
    public $client;

    /**
     * The middlewares.
     *
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var array
     */
    protected $globals = [
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ],
        'verify' => false
    ];

    public function __set($name, $value) {
        $this->globals[$name] = $value;
    }

    /**
     * 快速实例化模型
     * @author Tiger <1192851302@qq.com>
     * @param bool $singleton 是否单例
     * @return static
     */
    public static function instance($singleton = true) {
        $name = static::class;
        if (isset($GLOBALS['model'][$name]) and is_object($GLOBALS['model'][$name]) and $singleton) {
            return $GLOBALS['model'][$name];
        } else {
            $GLOBALS['model'][$name] = new static();
            return $GLOBALS['model'][$name];
        }
    }

    /**
     * GET request.
     *
     * @param string $url
     * @param array  $options
     *
     * @return ResponseInterface
     *
     * @throws HttpException
     */
    public function get($url, array $options = []) {
        return $this->request($url, 'GET', ['query' => $options]);
    }

    /**
     * POST request.
     *
     * @param string       $url
     * @param array|string $options
     *
     * @return ResponseInterface
     *
     * @throws HttpException
     */
    public function post($url, $options = []) {
        $key = is_array($options) ? 'form_params' : 'body';
        return $this->request($url, 'POST', [$key => $options]);
    }

    /**
     * JSON request.
     *
     * @param string       $url
     * @param string|array $options
     * @param int          $encodeOption
     * @param array        $queries
     *
     * @return ResponseInterface
     *
     * @throws HttpException
     */
    public function json($url, $options = [], $encodeOption = JSON_UNESCAPED_UNICODE, $queries = []) {
        is_array($options) && $options = json_encode($options, $encodeOption);

        return $this->request($url, 'POST', ['query' => $queries, 'body' => $options, 'headers' => ['content-type' => 'application/json']]);
    }

    /**
     * Upload file.
     *
     * @param string $url
     * @param array  $files
     * @param array  $form
     *
     * @return ResponseInterface
     *
     * @throws HttpException
     */
    public function upload($url, array $files = [], array $form = [], array $queries = []) {
        $multipart = [];

        foreach ($files as $name => $path) {
            $multipart[] = [
                'name' => $name,
                'contents' => fopen($path, 'r'),
            ];
        }

        foreach ($form as $name => $contents) {
            $multipart[] = compact('name', 'contents');
        }

        return $this->request($url, 'POST', ['query' => $queries, 'multipart' => $multipart]);
    }

    /**
     * Return GuzzleHttp\Client instance.
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient() {
        if (!($this->client instanceof HttpClient)) {
            $this->client = new HttpClient([
                'base_uri' => $this->base_uri
            ]);
        }
        return $this->client;
    }

    /**
     * Make a request.
     *
     * @param string $url
     * @param string $method
     * @param array  $options
     *
     * @return ResponseInterface
     *
     * @throws Exception
     */
    public function request($url, $method = 'GET', $options = []) {
        $options['handler'] = $this->getHandler();
        try {
            $response = $this->getClient()->request(strtoupper($method), $url, array_merge($this->globals, $options));
        } catch (TransferException $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        return $this->parseResponse($response);
    }

    /**
     * Build a handler.
     *
     * @return HandlerStack
     */
    protected function getHandler() {
        $stack = HandlerStack::create();
        foreach ($this->middlewares as $middleware) {
            $stack->push($middleware);
        }
        return $stack;
    }

    /**
     * Parse Response JSON to array.
     *
     * @param ResponseInterface $response
     *
     * @return Array
     */
    protected function parseResponse($response) {
        if ($response instanceof ResponseInterface) {
            $response = $response->getBody();
        }

        $items = json_decode($response, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            return $response;
        }
        return $items;
    }
}
