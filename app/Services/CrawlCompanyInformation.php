<?php

namespace App\Services;

use Goutte\Client;

class CrawlCompanyInformation
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    function run($taxCode)
    {
        $companyInformation = [];
        $crawler = $this->client->request('GET', 'https://masocongty.vn/search?name=' . trim($taxCode));
        $crawler->filter('h3')->each(function ($node) use (&$companyInformation) {
            $companyInformation['company_name'] = $node->text();
        });
        $crawler->filter('ul#detail-list li:nth-child(3) strong a')->each(function ($node) use (&$companyInformation) {
            $companyInformation['ceo_name'] = $node->text();
        });
        $crawler->filter('ul#detail-list li:nth-child(1) > span')->each(function ($node) use (&$companyInformation) {
            $companyInformation['address'] = $node->text();
        });
        return $companyInformation;
    }
}