<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer\Message;

use Omnipay\Common\Message\RequestInterface;

final class PartialCaptureResponse extends AbstractResponse
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @param RequestInterface $request
     * @param mixed            $data
     * @param int              $statusCode
     */
    public function __construct(RequestInterface $request, $data, $statusCode)
    {
        parent::__construct($request, $data);

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
