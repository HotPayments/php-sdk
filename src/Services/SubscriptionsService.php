<?php

namespace HotPayments\Services;

class SubscriptionsService extends BaseService
{
    public function create(array $subscriptionData): array
    {
        return $this->makeRequest('POST', 'v1/subscriptions/subscribe', $subscriptionData);
    }

    public function show(string $subscriptionId): array
    {
        return $this->makeRequest('GET', "v1/subscriptions/{$subscriptionId}");
    }

    public function cancel(string $subscriptionId, array $data = []): array
    {
        return $this->makeRequest('POST', "v1/subscriptions/{$subscriptionId}/cancel", $data);
    }

    public function suspend(string $subscriptionId, array $data = []): array
    {
        return $this->makeRequest('POST', "v1/subscriptions/{$subscriptionId}/suspend", $data);
    }

    public function reactivate(string $subscriptionId): array
    {
        return $this->makeRequest('POST', "v1/subscriptions/{$subscriptionId}/reactivate");
    }
}
