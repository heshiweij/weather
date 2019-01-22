<?php
/**
 * @author      svenhe <heshiweij@gmail.com>
 * @copyright   Copyright (c) Sven.He
 *
 * @link        http://www.svenhe.com
 */

namespace Svenhe\Weather\Libs;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    public static function getLogger($channel = 'weather')
    {
        $log = new Logger($channel);
        try {
            $log->pushHandler(new StreamHandler(__DIR__.'/../../debug.log', Logger::DEBUG));
        } catch (\Exception $e) {
        }

        return $log;
    }
}