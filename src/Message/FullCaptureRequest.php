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
final class FullCaptureRequest extends AbstractOrderRequest
{

    /**
     * @return int|null
     */
    public function getTotalCaptureAmount()
    {
        return $this->getParameter('total_capture_amount');
    }

    /**
     * @param int $totalCaptureAmount
     *
     * @return $this
     */
    public function setTotalCaptureAmount(int $totalCaptureAmount): self
    {
        $this->setParameter('total_capture_amount', $totalCaptureAmount);

        return $this;
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'order_id',
            'total_capture_amount',
        );

        $data = [];

        if (null !== $orderLines = $this->getItemData($this->getItems())) {
            $data['orderLines'] = $orderLines;
        }

        $data['totalCaptureAmount'] = $this->getTotalCaptureAmount();

        return $data;
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
        $response = $this->sendRequest(
            'POST',
            'orders/' . $this->getOrderId() . '/capture',
            $data
        );

        return new FullCaptureResponse(
            $this,
            $this->getResponseBody($response),
            $response->getStatusCode()
        );
    }
}
