<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tld;

class TldSeeder extends Seeder
{
    public function run(): void
    {
        $tlds = [
            ['tld' => 'com', 'whois_server' => 'whois.verisign-grs.com'],
            ['tld' => 'net', 'whois_server' => 'whois.verisign-grs.com'],
            ['tld' => 'org', 'whois_server' => 'whois.pir.org'],
            ['tld' => 'info', 'whois_server' => 'whois.afilias.net'],
            ['tld' => 'biz', 'whois_server' => 'whois.nic.biz'],
            ['tld' => 'io', 'whois_server' => 'whois.nic.io'],
            ['tld' => 'co', 'whois_server' => 'whois.nic.co'],
            ['tld' => 'ru', 'whois_server' => 'whois.tcinet.ru'],
            ['tld' => 'uk', 'whois_server' => 'whois.nic.uk'],
            ['tld' => 'de', 'whois_server' => 'whois.denic.de'],
            ['tld' => 'jp', 'whois_server' => 'whois.jprs.jp'],
            ['tld' => 'fr', 'whois_server' => 'whois.nic.fr'],
            ['tld' => 'au', 'whois_server' => 'whois.auda.org.au'],
            ['tld' => 'us', 'whois_server' => 'whois.nic.us'],
            ['tld' => 'cn', 'whois_server' => 'whois.cnnic.cn'],
            ['tld' => 'ca', 'whois_server' => 'whois.cira.ca'],
        ];

        foreach ($tlds as $tld) {
            Tld::updateOrCreate(['tld' => $tld['tld']], $tld);
        }
    }
}
