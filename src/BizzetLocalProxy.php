<?php
/**
 * File: BizzetLocalProxy.php
 * @author: Cvar1984 <gedzsarjuncomuniti@gmail.com>
 * Date: 19.01.2020
 * Last Modified Date: 19.01.2020
 * Last Modified By: Cvar1984 <gedzsarjuncomuniti@gmail.com>
 */
namespace Cvar1984\Bizzet;

class BizzetLocalProxy extends Bizzet
{
    public function getProxy($options)
    {
        $proxy = [
            'ipPort' => '127.0.0.1:9050',
            'ip' => '127.0.0.1',
            'port' => '9050',
            'country' => 'N/A',
            'last_checked' => 'N/A',
            'proxy_level' => 'N/A',
            'type' => 'socks5',
            'speed' => 'N/A',
            'level' => 'N/A'
        ];
        return $proxy;
    }
}
