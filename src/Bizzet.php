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
        $proxy =  (new \aalfiann\PubProxy())
            ->setLevel($level)
            ->setType($type)
            ->setLimit(1)
            ->make()
            ->getJson();
        $proxy = json_decode($proxy);
        $proxy = $proxy->data[0];
        return json_encode($proxy);
    }

    public function getReferer()
    {
        $list[] = 'http://facebook.com';
        $list[] = 'http://google.com.sg';
        $list[] = 'http://twitter.com';
        $list[] = 'http://google.co.id';
        $list[] = 'http://google.com.my';
        $list[] = 'http://google.jp';
        $list[] = 'http://google.us';
        $list[] = 'http://google.tl';
        $list[] = 'http://google.ac';
        $list[] = 'http://google.ad';
        $list[] = 'http://google.ae';
        $list[] = 'http://google.af';
        $list[] = 'http://google.ag';
        $list[] = 'http://google.ru';
        $list[] = 'http://google.by';
        $list[] = 'http://google.ca';
        $list[] = 'http://google.cn';
        $list[] = 'http://google.cl';
        $list[] = 'http://google.cm';
        $list[] = 'http://google.cv';
        $list[] = 'http://google.gg';
        $list[] = 'http://google.ge';
        $list[] = 'http://google.gr';
        $list[] = 'http://google.com.tw';
        $list[] = 'http://ahmia.fi';
        $list[] = 'http://search.yahoo.com';
        $list[] = 'http://www.beinyu.com';
        $list[] = 'http://duckduckgo.com';
        $list[] = 'http://youtube.com';
        $list[] = 'http://telegram.org';

        $acak = array_rand($list, 1);
        return $list[$acak];
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
        $this->curl->setProxyType($proxyType);
        $this->curl->setConnectTimeout($timeOut);
        $this->curl->get($url);

        if ($this->curl->error) {
            return json_encode([
                'errorMessage' => $this->curl->errorMessage,
                'statusCode' => $this->curl->getHttpStatusCode(),
                'proxyIp' => $proxyIp,
                'proxyPort' => $proxyPort,
                'proxyType' => $proxyType,
                'userAgent' => $userAgent,
                'referer' => $referer,
                'timeOut' => $timeOut
            ]);
        } else {
            return json_encode([
                'errorMessage' => false,
                'statusCode' => $this->curl->getHttpStatusCode(),
                'proxyIp' => $proxyIp,
                'proxyPort' => $proxyPort,
                'proxyType' => $proxyType,
                'userAgent' => $userAgent,
                'referer' => $referer,
                'timeOut' => $timeOut
            ]);
        }
    }
}
