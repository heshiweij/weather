<?php
/**
 * @author      svenhe <heshiweij@gmail.com>
 * @copyright   Copyright (c) Sven.He
 *
 * @link        http://www.svenhe.com
 */

namespace Svenhe\Weather\Tests;

use PHPUnit\Framework\TestCase;
use Svenhe\Weather\Exceptions\InvalidArgumentException;
use Svenhe\Weather\Weather;

class WeatherTest extends TestCase
{
    /**
     * 检查 $format 参数
     */
    public function testGetWeatherWithResponseFormat()
    {
        $w = new Weather('mock-key');

        // 断言会抛出异常
        $this->expectException(InvalidArgumentException::class);

        // 断言异常消息
        $this->expectExceptionMessage('Invalid response type: foo');

        $w->getWeather('深圳', 'foo');

        $this->fail('fail to assert getWeather throw exception with invalid response format');
    }

    /**
     * 检查 $type 参数
     *
     * @throws \Svenhe\Weather\Exceptions\InvalidArgumentException
     */
    public function testGetWeatherWithInvalidType()
    {
        $w = new Weather('mock-key');

        // 断言会抛出异常
        $this->expectException(InvalidArgumentException::class);

        // 断言异常消息
        $this->expectExceptionMessage('Invalid type value(base/all): array');

        // 因为支持的格式为 xml/json，所以传入 array 会抛出异常
        $w->getWeather('深圳', 'base', 'array');

        $this->fail('fail to assert getWeather throw exception with invalid response format');
    }

    public function testGetWeather()
    {

    }

    public function testGetHttpClient()
    {

    }

    public function testSetGuzzleOptions()
    {

    }
}