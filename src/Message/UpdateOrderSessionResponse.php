<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer\Message;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

final class UpdateOrderSessionResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @var string|null
     */
    private $renderUrl;

    /**
     * @inheritDoc
     */
    public function __construct(RequestInterface $request, $data, $renderUrl = null)
    {
        parent::__construct($request, $data);
        $this->renderUrl = $renderUrl;
    }

    /**
     * @inheritDoc
     */
    public function getRedirectData()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl()
    {
        return $this->renderUrl;
    }

    /**
     * @inheritDoc
     */
    public function isRedirect(): bool
    {
        return null !== $this->renderUrl;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        // Authorize is only successful once it has been acknowledged
        return false;
    }
}
