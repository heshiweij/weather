<?php
/**
 * @author      svenhe <heshiweij@gmail.com>
 * @copyright   Copyright (c) Sven.He
 *
 * @link        http://www.svenhe.com
 */

namespace Svenhe\Weather;

use GuzzleHttp\Client;
use Monolog\Logger;
use Svenhe\Weather\Exceptions\Exception;
use Svenhe\Weather\Exceptions\HttpException;
use Svenhe\Weather\Exceptions\InvalidArgumentException;
use Svenhe\Weather\Libs\Log;

class Weather
{
    protected $key;

    protected $guzzleOptions = [];

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param array $guzzleOptions
     */
    public function setGuzzleOptions($guzzleOptions)
    {
        $this->guzzleOptions = $guzzleOptions;
    }

    /**
     * @param $city
     * @param string $type
     * @param string $format
     * @return string
     * @throws \Svenhe\Weather\Exceptions\InvalidArgumentException
     */
    protected function getWeather($city, $type = 'base', $format = 'json')
    {
        if (! in_array(strtolower($type), ['base', 'all'])) {
            throw new InvalidArgumentException('Invalid response type: '.$type);
        }

        if (! in_array(strtolower($format), ['json', 'xml'])) {
            throw new InvalidArgumentException('Invalid type value(base/all): '.$format);
        }

        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        $query = array_filter([
            'key'        => $this->key,
            'city'       => $city,
            'output'     => $format,
            'extensions' => $type,
        ]);

        $response = null;
        $message  = null;

        try {

            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();
        } catch (InvalidArgumentException $e) {
            $message = '参数异常:'.$e->getMessage();
        } catch (HttpException $e) {
            $message = '接口异常:'.$e->getMessage();
        }

        Log::getLogger()->log(Logger::DEBUG, '调用天气扩展时出现了异常: '.$message);

        return 'json' === $format ? json_decode($response) : $response;
    }

    public function getLiveWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'base', $format);
    }

    public function getForecastWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'all', $format);
    }
}