<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer\Message\Oauth;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\Client;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * Creates a Ledyer oauth 2 token
 */
final class ObtainTokenRequest
{
    protected $liveEndpoint = 'https://auth.live.ledyer.com';
    protected $testEndpoint = 'https://auth.sandbox.ledyer.com';

    protected string $id;
    protected string $secret;
    protected bool $testMode;


    public function __construct(string $id, string $secret, bool $testMode)
    {
        $this->id = $id;
        $this->secret = $secret;
        $this->testMode = $testMode;
    }

    public function getEndpoint()
    {
        return ($this->testMode ? $this->testEndpoint : $this->liveEndpoint) . '/oauth/token';
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function getResponseBody(ResponseInterface $response): array
    {
        try {
            return \json_decode($response->getBody()->getContents(), true);
        } catch (\TypeError $exception) {
            return [];
        }
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidResponseException
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     */
    public function send()
    {
        $authString = base64_encode($this->id . ':' . $this->secret);

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . $authString,
        ];
        $httpClient = new Client();

        $response = $httpClient->request(
            'POST',
            $this->getEndpoint(),
            $headers,
            http_build_query([
                'grant_type' => 'client_credentials'
            ]),
        );

        return $this->getResponseBody($response);
    }
}
