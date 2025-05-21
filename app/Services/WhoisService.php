<?php

namespace App\Services;

use App\Models\Tld;
use Exception;

class WhoisService
{
    public function getWhoisData(string $domain): string
    {
        $parts = explode('.', $domain);
        $tld = end($parts);

        $tldModel = Tld::query()->where('tld', $tld)->first();
        if (!$tldModel) {
            throw new \Exception("WHOIS сервер для зоны $tld не найден");
        }

        $server = $tldModel->whois_server;

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
