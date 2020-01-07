<?php
namespace Cvar1984\Bizzet;

class Main
{
    public function __construct()
    {
        $this->climate = new \League\CLImate\CLImate();
        $this->curl = new \Curl\Curl();
        $this->userAgent = new \Campo\UserAgent();
    }
    public function showBanner()
    {
        $this->climate->clear();
        $this->climate->addArt('assets');
        $this->climate->red()->boldDraw('banner');
        $this->climate->blue()->boldBorder(false, 50);
    }
    public function getProxy($type = 'socks5', $level = 'elite')
    {
        return (new \aalfiann\PubProxy())
            ->setLevel($level)
            ->setType($type)
            ->setLimit(1)
            ->make()
            ->getJson();
    }
    public function request(string $url, array $option)
    {
        $userAgent = $option['userAgent'];
        $referer = $option['referer'];
        $proxyIp = $option['proxy']['ip'];
        $proxyPort = $option['proxy']['port'];
        $proxyType = $option['proxy']['type'];
        $timeOut = $option['timeOut'];

        $this->curl->setUserAgent($userAgent);
        $this->curl->setReferrer($referer);
        $this->curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
        $this->curl->setProxy($proxyIp, $proxyPort);
        $this->curl->setProxyTunnel($proxyType);
        $this->curl->setConnectTimeout($timeOut);
        $this->curl->get($url);

        if ($this->curl->error) {
            return array(
                'errorMesaage' => $this->curl->errorMessage,
                'statusCode' => $this->curl->getHttpStatusCode(),
                'proxyIp' => $proxyIp,
                'proxyPort' => $proxyPort,
                'proxyTunnel' => $proxyType,
                'userAgent' => $userAgent,
                'referer' => $referer,
                'timeOut' => $timeOut
            );
        } else {
            return array(
                'errorMesaage' => false,
                'statusCode' => $this->curl->getHttpStatusCode(),
                'proxyIp' => $proxyIp,
                'proxyPort' => $proxyPort,
                'proxyTunnel' => $proxyType,
                'userAgent' => $userAgent,
                'referer' => $referer,
                'timeOut' => $timeOut
            );
        }
    }
}
