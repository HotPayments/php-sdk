<?php

namespace HotPayments;

use GuzzleHttp\Client;
use HotPayments\Services\{CustomersService, SubscriptionPlansService, SubscriptionsService, TransactionsService};

class Hotpayments
{
    private static ?self $instance = null;

    private static ?string $apiKey = null;

    public string $baseUri = 'https://hotpayments.net/api/';

    protected Client $client;

    private function __construct(string $apiKey)
    {
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'headers'  => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey,
            ],
        ]);
    }

    public static function auth(string $apiKey): void
    {
        self::$apiKey   = $apiKey;
        self::$instance = null;
    }

    private static function getInstance(): self
    {
        if (self::$instance === null) {
            if (self::$apiKey === null) {
                throw new \RuntimeException('API key not set. Call Hotpayments::auth($apiKey) first.');
            }

            self::$instance = new self(self::$apiKey);
        }

        return self::$instance;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public static function customers(): CustomersService
    {
        return new CustomersService(self::getInstance());
    }

    public static function subscriptions(): SubscriptionsService
    {
        return new SubscriptionsService(self::getInstance());
    }

    public static function subscriptionPlans(): SubscriptionPlansService
    {
        return new SubscriptionPlansService(self::getInstance());
    }

    public static function transactions(): TransactionsService
    {
        return new TransactionsService(self::getInstance());
    }
}
