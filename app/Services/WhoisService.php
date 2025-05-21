<?php

namespace App\Services;

use Exception;

class WhoisService
{
    private array $whoisServers = [
        'com' => 'whois.verisign-grs.com',
        'net' => 'whois.verisign-grs.com',
        'org' => 'whois.pir.org',
        'info' => 'whois.afilias.net',
        'biz' => 'whois.nic.biz',
        'io' => 'whois.nic.io',
        'co' => 'whois.nic.co',
        'ru' => 'whois.tcinet.ru',
        'uk' => 'whois.nic.uk',
        'de' => 'whois.denic.de',
        'jp' => 'whois.jprs.jp',
        'fr' => 'whois.nic.fr',
        'au' => 'whois.auda.org.au',
        'us' => 'whois.nic.us',
        'cn' => 'whois.cnnic.cn',
        'ca' => 'whois.cira.ca',
    ];

    public function getWhoisData(string $domain): string
    {
        $parts = explode('.', $domain);
        $tld = end($parts);

        if (!isset($this->whoisServers[$tld])) {
            throw new \Exception("WHOIS сервер для зоны $tld не найден");
        }

        $server = $this->whoisServers[$tld];

        $whoisData = $this->queryWhoisServer($server, $domain);

        if (empty($whoisData)) {
            throw new \Exception("Не удалось получить WHOIS данные");
        }

        return $whoisData;
    }

    private function queryWhoisServer(string $server, string $domain): string
    {
        $port = 43;
        $timeout = 10;

        $socket = @fsockopen($server, $port, $errno, $errstr, $timeout);

        if (!$socket) {
            throw new \Exception("Не удалось подключиться к WHOIS серверу: $errstr ($errno)");
        }

        stream_set_timeout($socket, $timeout);

        fwrite($socket, $domain . "\r\n");

        $response = '';
        while (!feof($socket)) {
            $response .= fgets($socket, 4096);
        }

        fclose($socket);

        if (empty($response)) {
            throw new Exception("Не удалось получить WHOIS-данные для $domain");
        }

        return $response;
    }
}
