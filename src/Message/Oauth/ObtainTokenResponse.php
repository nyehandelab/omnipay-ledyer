<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer\Message\Oauth;

use Omnipay\Common\Message\RequestInterface;

final class ObtainTokenResponse extends AbstractResponse
{
    /**
     * @var int
     */
    private $statusCode;

    public function __construct(RequestInterface $request, $data, $transactionReference, $statusCode)
    {
        parent::__construct($request, $data);

        $this->transactionReference = $transactionReference;
        $this->statusCode = $statusCode;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return parent::isSuccessful() && 200 === $this->statusCode;
    }
}
