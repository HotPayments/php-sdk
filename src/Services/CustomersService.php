<?php

namespace HotPayments\Services;

class CustomersService extends BaseService
{
    public function create(array $customerData): array
    {
        return $this->makeRequest('POST', 'v1/customers', $customerData);
    }

    public function list(array $params = []): array
    {
        return $this->makeRequest('GET', 'v1/customers', $params);
    }
}
