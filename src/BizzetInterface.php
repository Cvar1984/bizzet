<?php
/**
 * File: BizzetInterface.php
 * @author: Cvar1984 <gedzsarjuncomuniti@gmail.com>
 * Date: 13.01.2020
 * Last Modified Date: 13.01.2020
 * Last Modified By: Cvar1984 <gedzsarjuncomuniti@gmail.com>
 */
namespace Cvar1984\Bizzet;

interface BizzetInterface
{
    public function __construct();
    public function __destruct();
    public function getUserAgent();
    public function getReferer();
    public function getProxy(array $options);
    public function request(string $url, array $options);
}
