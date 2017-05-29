<?php
/**
 * Created by PhpStorm.
 * User: zhaojipeng
 * Date: 17/5/27
 * Time: 14:34
 */

namespace App\Facades;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Facade;

class Http extends Facade
{
    public static function getFacadeAccessor()
    {
        return new Client();
    }
}