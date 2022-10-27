<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer;

use Nyehandel\Omnipay\Ledyer\Message\AcknowledgeRequest;
use Nyehandel\Omnipay\Ledyer\Message\AuthorizeRequest;
use Nyehandel\Omnipay\Ledyer\Message\CancelOrderRequest;
use Nyehandel\Omnipay\Ledyer\Message\CaptureRequest;
use Nyehandel\Omnipay\Ledyer\Message\CreateOrderSessionRequest;
use Nyehandel\Omnipay\Ledyer\Message\ExtendAuthorizationRequest;
use Nyehandel\Omnipay\Ledyer\Message\FetchTransactionRequest;
use Nyehandel\Omnipay\Ledyer\Message\FullCaptureRequest;
use Nyehandel\Omnipay\Ledyer\Message\GetOrderRequest;
use Nyehandel\Omnipay\Ledyer\Message\Oauth\ObtainTokenRequest;
use Nyehandel\Omnipay\Ledyer\Message\PartialCaptureRequest;
use Nyehandel\Omnipay\Ledyer\Message\RefundRequest;
use Nyehandel\Omnipay\Ledyer\Message\UpdateCustomerAddressRequest;
use Nyehandel\Omnipay\Ledyer\Message\UpdateMerchantReferencesRequest;
use Nyehandel\Omnipay\Ledyer\Message\UpdateOrderRequest;
use Nyehandel\Omnipay\Ledyer\Message\UpdateOrderSessionRequest;
use Nyehandel\Omnipay\Ledyer\Message\UpdateTransactionRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

final class Gateway extends AbstractGateway implements GatewayInterface
{
    const BASE_URL = 'https://api.live.ledyer.com';
    const TEST_BASE_URL = 'https://api.sandbox.ledyer.com';
    const VERSION = 'v1';

    /**
     * @inheritdoc
     */
    public function acknowledge(array $options = []): RequestInterface
    {
        return $this->createRequest(AcknowledgeRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function authorize(array $options = [])
    {
        return $this->createRequest(CreateOrderSessionRequest::class, $options);
    }

    public function getOrder(array $options = [])
    {
        return $this->createRequest(GetOrderRequest::class, $options);
    }

    public function updateOrder(array $options = [])
    {
        return $this->createRequest(UpdateOrderSessionRequest::class, $options);
    }

    public function cancelOrder(array $options = [])
    {
        return $this->createRequest(CancelOrderRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function capture(array $options = [])
    {
        return $this->createRequest(PartialCaptureRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function fullCapture(array $options = [])
    {
        return $this->createRequest(FullCaptureRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function extendAuthorization(array $options = []): RequestInterface
    {
        return $this->createRequest(ExtendAuthorizationRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function fetchTransaction(array $options = []): RequestInterface
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultParameters(): array
    {
        return [
            'secret' => '',
            'testMode' => true,
            'username' => '',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Ledyer';
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->getParameter('secret');
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->getParameter('id');
    }

    /**
     * @inheritDoc
     */
    public function initialize(array $parameters = [])
    {
        parent::initialize($parameters);

        $this->setBaseUrl();

        return $this;
    }

    public function obtainOauthToken(array $parameters = [])
    {
        return $this->createRequest(ObtainTokenRequest::class, $parameters);
    }

    /**
     * @inheritdoc
     */
    public function refund(array $options = [])
    {
        return $this->createRequest(RefundRequest::class, $options);
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
     * @param string $username
     *
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->setParameter('id', $id);

        return $this;
    }

    public function setTestMode($testMode): self
    {
        parent::setTestMode($testMode);

        $this->setBaseUrl();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function updateCustomerAddress(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateCustomerAddressRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function updateTransaction(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateTransactionRequest::class, $options);
    }

    public function updateMerchantReferences(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateMerchantReferencesRequest::class, $options);
    }

    private function setBaseUrl()
    {
        $this->parameters->set('base_url', ($this->getTestMode() ? self::TEST_BASE_URL : self::BASE_URL) . '/' . self::VERSION . '/');
    }
}
