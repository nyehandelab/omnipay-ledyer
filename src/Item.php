<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer;

use Nyehandel\Omnipay\Ledyer\Exceptions\InvalidItemException;

final class Item extends \Omnipay\Common\Item
{
    /**
     * Validate the item
     *
     * 
     * @return void
     * @throws Exception\InvalidRequestException
     * @throws InvalidSettingsException
     */

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->setParameter('type', $type);
    }

    /**
     * @inheritDoc
     */
    public function getReference()
    {
        return $this->getParameter('reference');
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->setParameter('reference', $reference);
    }

    /**
     * @inheritDoc
     */
    public function getUnitDiscountAmount()
    {
        return $this->getParameter('unit_discount_amount');
    }

    /**
     * @param int $unitDiscountAmount
     */
    public function setUnitDiscountAmount($unitDiscountAmount)
    {
        $this->setParameter('unit_discount_amount', $unitDiscountAmount);
    }

    /**
     * @inheritDoc
     */
    public function getVat()
    {
        return $this->getParameter('vat');
    }

    /**
     * @param int $unitDiscountAmount
     */
    public function setVat($vat)
    {
        $this->setParameter('vat', $vat);
    }

    public function calculateTotalVatAmount()
    {
        return (int) round(($this->getPrice() - $this->getPrice() / (1 + $this->getVat() / 10000)) * $this->getQuantity());
    }

    public function calculateTotalPriceExclVat()
    {
        return $this->getPrice() * $this->getQuantity() - $this->calculateTotalVatAmount();
    }
}
