<?php
//error_reporting(0);
require __DIR__ . '/vendor/autoload.php';

$bizzet = new Cvar1984\Bizzet\Main();
$campo = new Campo\UserAgent();
$bizzet->showBanner();

for ($x = 0; $x < 100; $x++) {
    $proxy = $bizzet->getProxy();
    $proxy = json_decode($proxy);
    $proxy = $proxy->data[0];
    $proxyIp = $proxy->ip;
    $proxyPort = $proxy->port;
    $proxyType = strtoupper($proxy->type);
    $userAgent = $campo->random();
    $url = 'http://cvar1984.blogspot.com';

    $options = array(
        'userAgent' => $userAgent,
        'referer' => 'http://ahmia.fi',
        'timeOut' => 3,
        'proxy' => array(
            'ip' => $proxyIp,
            'port' => $proxyPort,
            'type' => $proxyType
        )
    );
    var_dump($bizzet->request($url, $options));
}
