<?php

declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer\Message;

use Money\Money;
use Nyehandel\Omnipay\Ledyer\AuthenticationRequestHeaderProvider;
use Nyehandel\Omnipay\Ledyer\ItemBag;
use Nyehandel\Omnipay\Ledyer\TokenService;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * @method ItemBag|null getItems()
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     * @return Money|null
     */
    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getParameter('id');
    }

    /**
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->getParameter('base_url');
    }

    /**
     * RFC 1766 customer's locale.
     *
     * @return string|null
     */
    public function getLocale()
    {
        return $this->getParameter('locale');
    }

    /**
     * @return string|null
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * The total tax amount of the order
     *
     * @return Money|null
     */
    public function getTaxAmount()
    {
        return $this->getParameter('tax_amount');
    }


    /**
     * @param string $baseUrl
     *
     * @return $this
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->setParameter('base_url', $baseUrl);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setItems($items)
    {
        if ($items && !$items instanceof ItemBag) {
            $items = new ItemBag($items);
        }

        return $this->setParameter('items', $items);
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale)
    {
        $this->setParameter('locale', $locale);
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
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->setParameter('id', $id);

        return $this;
    }

    /**
     * @param mixed $value
     */
    public function setTaxAmount($value)
    {
        $this->setParameter('tax_amount', $value);
    }

    /**
     * @return string|null
     */
    public function getOrderId()
    {
        return $this->getParameter('order_id');
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setOrderId($value)
    {
        return $this->setParameter('order_id', $value);
    }

    /**
     * @return string|null
     */
    public function getLedyerId()
    {
        return $this->getParameter('ledyer_id');
    }

    /**
     * @param string $ledyerId
     *
     * @return $this
     */
    public function setLedyerId(string $ledyerId): self
    {
        $this->setParameter('ledyer_id', $ledyerId);

        return $this;
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
     * @param string $method
     * @param string $url
     * @param mixed  $data
     *
     * @return ResponseInterface
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     */
    protected function sendRequest(string $method, string $url, $data = []): ResponseInterface
    {

        $tokenExpired = false;
        $tokenService = new TokenService();
        $token = $tokenService->get($this->getId());

        if (is_null($token) || !property_exists($token, 'expires_at') || $tokenExpired = $token->expires_at < time()) {
            if ($tokenExpired) {
                $tokenService->invalidate($this->getId());
            }

            $token = $tokenService->create($this->getId(), $this->getSecret(), $this->getTestMode());
        }

        $headers = (new AuthenticationRequestHeaderProvider())->getHeaders($token->access_token);

        if ('GET' === $method) {
            return $this->httpClient->request(
                $method,
                $this->getBaseUrl() . $url,
                $headers
            );
        }

        return $this->httpClient->request(
            $method,
            $this->getBaseUrl() . $url,
            array_merge(
                ['Content-Type' => 'application/json'],
                $headers
            ),
            \json_encode($data)
        );
    }
}
