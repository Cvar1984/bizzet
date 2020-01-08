<?php
require __DIR__ . '/vendor/autoload.php';

$bizzet = new Cvar1984\Bizzet\Main();
$campo = new Campo\UserAgent();
$climate = new League\Climate\Climate();
$bizzet->showBanner();

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
            'defaultValue' => 30
        ]
    ]
);

$climate->arguments->parse();
$iterations = $climate->arguments->get('iterations');
if ($climate->arguments->defined('timeout')) {
    if (is_numeric($climate->arguments->get('timeout'))) {
        $timeout = $climate->arguments->get('timeout');
    } else {
        $climate->red('Not an integer');
        exit(1);
    }
}
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
    $proxy = $bizzet->getProxy();
    $proxy = json_decode($proxy);
    $proxy = $proxy->data[0];
    $proxyIp = $proxy->ip;
    $proxyPort = $proxy->port;
    // $proxyType = strtoupper($proxy->type);
    $userAgent = $campo->random();
    $referer = $bizzet->getReferer();

    $options = array(
        'userAgent' => $userAgent,
        'referer' => $referer,
        'timeOut' => 10,
        'proxy' => array(
            'ip' => $proxyIp,
            'port' => $proxyPort,
            'type' => CURLPROXY_SOCKS5
        )
    );
    $response = (array)json_decode($bizzet->request($url, $options));
    $climate->boldBorder('#');
    $climate->green('Error        : ' . $response['errorMessage']);
    $climate->green('Status       : ' . $response['statusCode']);
    $climate->green('Proxy Ip     : ' . $response['proxyIp']);
    $climate->green('Proxy Port   : ' . $response['proxyPort']);
    $climate->green('Proxy Type   : ' . $response['proxyType']);
    $climate->green('User Agent   : ' . substr($response['userAgent'], 0, 30));
    $climate->green('Referer      : ' . $response['referer']);
    $climate->green('Time Out     : ' . $response['timeOut']);
    $climate->boldBorder('#');
}
