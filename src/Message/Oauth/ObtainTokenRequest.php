<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer\Message\Oauth;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;
use Omnipay\Common\Message\AbstractRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * Creates a Ledyer oauth 2 token
 */
final class ObtainTokenRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://auth.live.ledyer.com';
    protected $testEndpoint = 'https://auth.sandbox.ledyer.com';

    /**
     * @inheritDoc
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        return [];
    }

    /**
     * @return string|null
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * @param string $secret
     *
     * @return $this
     */
    public function setSecret(string $secret): self
    {
        $this->setParameter('secret', $secret);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->setParameter('id', $id);

        return $this;
    }

    public function getEndpoint()
    {
        return ($this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint) . '/oauth/token';
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
    public function sendData($data)
    {
        $authString = base64_encode($this->getId() . ':' . $this->getSecret());

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . $authString,
        ];

        $response = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            $headers,
            http_build_query([
                'grant_type' => 'client_credentials'
            ]),
        );


            return new ObtainTokenResponse(
                $this,
                $this->getResponseBody($response),
                $this->getTransactionReference(),
                $response->getStatusCode(),
            );
    }
}
