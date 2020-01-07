<?php
//error_reporting(0);
require __DIR__ . '/vendor/autoload.php';

$bizzet = new Cvar1984\Bizzet\Main();
$campo = new Campo\UserAgent();
$bizzet->showBanner();

for ($x = 0; $x < 10; $x++) {
    $proxy = $bizzet->getProxy();
    $proxy = json_decode($proxy);
    $proxy = $proxy->data[0];
    $proxyIp = $proxy->ip;
    $proxyPort = $proxy->port;
    // $proxyType = strtoupper($proxy->type);
    $userAgent = $campo->random();
    $referer = $bizzet->getReferer();
    $url = 'http://cvar1984.blogspot.com';

    $options = array(
        'userAgent' => $userAgent,
        'referer' => $referer,
        'timeOut' => 5,
        'proxy' => array(
            'ip' => $proxyIp,
            'port' => $proxyPort,
            'type' => CURLPROXY_SOCKS5
        )
    );
    var_dump($bizzet->request($url, $options));
}
