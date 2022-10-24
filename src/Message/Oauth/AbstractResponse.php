<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer\Message\Oauth;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    /**
     * @inheritdoc
     */
    public function getCode()
    {
        return $this->data['error_code'] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->data['error_message'] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return !isset($this->data['error_code']);
    }
}

