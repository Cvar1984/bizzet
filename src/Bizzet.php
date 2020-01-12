<?php
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

class Bizzet implements BizzetInterface
{
    private $curl;
    public function __construct()
    {
        $this->curl = new \Curl\Curl();
    }
    public function __destruct() {
        // do something
    }
    public function getProxy($options)
    {
        $type = $options['type'];
        $level = $options['level'];
        $proxy = (new \aalfiann\PubProxy())
            ->setLevel($level)
            ->setType($type)
            ->setLimit(1)
            ->make()
            ->getJson();
        $proxy = json_decode($proxy);
        $proxy = $proxy->data[0];
        return $proxy;
    }
    public function getUserAgent()
    {
        return (new \Campo\UserAgent())->random();
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
    public function request($url, $option)
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
        $this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $this->curl->setProxy($proxyIp, $proxyPort);
        $this->curl->setProxyType($proxyType);
        $this->curl->setConnectTimeout($timeOut);
        $this->curl->get($url);

        if ($this->curl->error) {
            return [
                'errorMessage' => $this->curl->errorMessage,
                'statusCode' => $this->curl->getHttpStatusCode()
            ];
        } else {
            return [
                'errorMessage' => false,
                'statusCode' => $this->curl->getHttpStatusCode()
            ];
        }
    }
}
