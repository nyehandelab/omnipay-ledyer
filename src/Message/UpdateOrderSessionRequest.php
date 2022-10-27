<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;

/**
 * Creates a Ledyer Checkout order if it does not exist
 */
final class UpdateOrderSessionRequest extends AbstractOrderRequest
{
    /**
     * @inheritDoc
     *
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate(
            'order_id',
        );

        $data = $this->getOrderData();

        return $data;
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidResponseException
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     */
    public function sendData($data): UpdateOrderSessionResponse 
    {
        $response = $this->sendRequest(
            'POST',
            'sessions/' . $this->getOrderId(),
            $data
        );

        return new UpdateOrderSessionResponse($this, $this->getResponseBody($response), $response->getStatusCode());
    }
}
