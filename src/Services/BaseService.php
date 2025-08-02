<?php

namespace HotPayments\Services;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use HotPayments\Hotpayments;
use HotPayments\Exceptions\HotpaymentsException;
use HotPayments\Exceptions\ValidationException;
use HotPayments\Exceptions\AuthorizationException;

abstract class BaseService
{
    protected Hotpayments $hotpayments;

    public function __construct(Hotpayments $hotpayments)
    {
        $this->hotpayments = $hotpayments;
    }

    protected function makeRequest(string $method, string $endpoint, array $data = []): array
    {
        try {
            $options = [];
            
            if (!empty($data)) {
                if ($method === 'GET') {
                    $options['query'] = $data;
                } else {
                    $options['json'] = $data;
                }
            }

            $response = $this->hotpayments->getClient()->request($method, $endpoint, $options);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $this->handleClientException($e);
        } catch (RequestException $e) {
            throw new HotpaymentsException(
                'Request failed: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    private function handleClientException(ClientException $e): void
    {
        $statusCode = $e->getResponse()->getStatusCode();
        $responseBody = json_decode($e->getResponse()->getBody()->getContents(), true);
        
        $message = $responseBody['message'] ?? 'Unknown error';

        switch ($statusCode) {
            case 422:
                $errors = $responseBody['errors'] ?? [];
                throw new ValidationException($message, $errors);
            case 403:
                throw new AuthorizationException($message);
            default:
                throw new HotpaymentsException($message, $statusCode, $e);
        }
    }
}