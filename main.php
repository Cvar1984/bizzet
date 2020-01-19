<?php
/**
 * File: main.php
 * @author: Cvar1984 <gedzsarjuncomuniti@gmail.com>
 * Date: 19.01.2020
 * Last Modified Date: 19.01.2020
 * Last Modified By: Cvar1984 <gedzsarjuncomuniti@gmail.com>
 */
require __DIR__ . '/vendor/autoload.php';
use Cvar1984\Bizzet\BizzetFactory as Factory;

$bizzet = Factory::create(new Cvar1984\Bizzet\BizzetLocalProxy());
$climate = new League\CLImate\CLImate();
$climate
    ->addArt('assets')
    ->red()
    ->boldDraw('banner')
    ->blue()
    ->boldBorder(false, 50);

$climate->arguments->add(
    [
        'url' => [
            'prefix' => 'u',
            'longPrefix' => 'url',
            'description' => 'Single url mode',
            'notValue' => true
        ],
        'list' => [
            'prefix' => 'l',
            'longPrefix' => 'list',
            'description' => 'Url from list',
            'notValue' => true
        ],
        'iterations' => [
            'prefix' => 'i',
            'longPrefix' => 'iterations',
            'description' => 'Number of iterations',
            'castTo' => 'int',
            'defaultValue' => 1
        ],
        'timeout' => [
            'prefix' => 't',
            'longPrefix' => 'time-out',
            'description' => 'Number of time out',
            'castTo' => 'int',
            'defaultValue' => 30
        ],
        'proxyLevel' => [
            'prefix' => 'pl',
            'longPrefix' => 'proxy-level',
            'description' => 'Proxy level',
            'defaultValue' => 'elite'
        ],
        'proxyType' => [
            'prefix' => 'pt',
            'longPrefix' => 'proxy-type',
            'description' => 'Proxy type',
            'defaultValue' => 'http'
        ]
    ]
);

$climate->arguments->parse();
$iterations = $climate->arguments->get('iterations');
$timeOut = $climate->arguments->get('timeout');
$proxyType = $climate->arguments->get('proxyType');
$proxyTypeString = $proxyType;
$proxyLevel = $climate->arguments->get('proxyLevel');
if ($climate->arguments->defined('url')) {
    $url = $climate->arguments->get('url');
} elseif ($climate->arguments->defined('list')) {
    $url = file_get_contents($climate->arguments->get('list'));
    $url = explode("\n", $url);
} else {
    $climate->usage();
    exit(1);
}

for ($x = 0; $x < $iterations; $x++) {
    $proxy = $bizzet->getProxy(
        [
            'type' => $proxyTypeString,
            'level' => $proxyLevel
        ]
    );

    $proxy = (object)$proxy;
    $proxyIp = $proxy->ip;
    $proxyPort = $proxy->port;
    $proxyCountry = $proxy->country;
    $proxySpeed = $proxy->speed;
    $userAgent = $bizzet->getUserAgent();
    $referer = $bizzet->getReferer();

    switch ($proxyTypeString) {
    case 'socks5':
        $proxyType = CURLPROXY_SOCKS5;
        break;

    case 'socks4':
        $proxyType = CURLPROXY_SOCKS4;
        break;

    case 'http':
        $proxyType = CURLPROXY_HTTP;
        break;

    case 'socks4a':
        $proxyType = CURLPROXY_SOCKS4A;
        break;

    case 'socks5h':
        $proxyType = CURLPROXY_SOCKS5_HOSTNAME;
        break;

    default:
        $proxyType = CURLPROXY_HTTP;
        break;
    }

    $options = array(
        'userAgent' => $userAgent,
        'referer' => $referer,
        'timeOut' => $timeOut,
        'proxy' => array(
            'ip' => $proxyIp,
            'port' => $proxyPort,
            'level' => $proxyLevel,
            'type' => $proxyType
        )
    );
    $response = $bizzet->request($url, $options);
    $climate->boldBorder('#');
    $climate->green('Error         : ' . $response['errorMessage']);
    $climate->green('Status        : ' . $response['statusCode']);
    $climate->green('Proxy Ip      : ' . $proxyIp);
    $climate->green('Proxy Port    : ' . $proxyPort);
    $climate->green('Proxy Type    : ' . $proxyTypeString);
    $climate->green('Proxy Speed   : ' . $proxySpeed);
    $climate->green('Proxy Country : ' . $proxyCountry);
    $climate->green('Proxy Level   : ' . $proxyLevel);
    $climate->green('User Agent    : ' . $userAgent);
    $climate->green('Referer       : ' . $referer);
    $climate->green('Time Out      : ' . $timeOut);
    $climate->boldBorder('#');
}
