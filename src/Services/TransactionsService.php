<?php

namespace HotPayments\Services;

class TransactionsService extends BaseService
{
    public function createPixQrCode(array $qrCodeData): array
    {
        return $this->makeRequest('POST', 'v1/pix/qrcode', $qrCodeData);
    }

    public function pixCashout(array $cashoutData): array
    {
        return $this->makeRequest('POST', 'v1/pix/cashout', $cashoutData);
    }

    public function check(string $transactionId): array
    {
        return $this->makeRequest('GET', "v1/transactions/{$transactionId}");
    }
}