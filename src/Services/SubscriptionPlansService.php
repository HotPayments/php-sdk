<?php

namespace HotPayments\Services;

class SubscriptionPlansService extends BaseService
{
    public function list(array $params = []): array
    {
        return $this->makeRequest('GET', 'v1/subscriptions/plans', $params);
    }

    public function all(array $params = []): array
    {
        return $this->list($params);
    }
}
