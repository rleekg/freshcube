<?php

declare(strict_types=1);

namespace App\Leads\Service;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;

/**
 * Клиент по работе с AmoCRM
 */
final readonly class AmoCRMClient
{
    public AmoCRMApiClient $api;

    public function __construct(
    ) {
        $this->api = new AmoCRMApiClient(env('AMOCRM_CLIENT_ID'), env('AMOCRM_CLIENT_SECRET'), null);
        $longLivedAccessToken = new LongLivedAccessToken(env('AMOCRM_TOKEN'));

        $this->api->setAccessToken($longLivedAccessToken)->setAccountBaseDomain('15webvuglizov.amocrm.ru');
    }
}
