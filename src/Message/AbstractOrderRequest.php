<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer\Message;

use Nyehandel\Omnipay\Ledyer\Address;
use Nyehandel\Omnipay\Ledyer\Customer;
use Nyehandel\Omnipay\Ledyer\ItemBag;
use Nyehandel\Omnipay\Ledyer\Settings;
use Nyehandel\Omnipay\Ledyer\WidgetOptions;

abstract class AbstractOrderRequest extends AbstractRequest
{
    use ItemDataTrait;

    /**
     * @return string|null
     */
    public function getCountry()
    {
        return $this->getParameter('country');
    }

    /**
     * @param string $country
     *
     * @return $this
     */
    public function setCountry(string $country): self
    {
        $this->setParameter('country', $country);

        return $this;
    }

    public function setCustomer($value)
    {
        if ($value && !$value instanceof Customer) {
            $value = new Customer($value);
        }

        return $this->setParameter('customer', $value);
    }

    /**
     * Get the customer.
     *
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->getParameter('customer');
    }

    public function setSettings($value)
    {
        if ($value && !$value instanceof Settings) {
            $value = new Settings($value);
        }

        return $this->setParameter('settings', $value);
    }

    /**
     * Get the settings.
     *
     * @return Settings
     */
    public function getSettings()
    {
        return $this->getParameter('settings');
    }

    /**
     * @return string|null
     */
    public function getMetadata()
    {
        return $this->getParameter('metadata');
    }

    /**
     * @param array $metadata
     *
     * @return $this
     */
    public function setMetadata($metadata): self
    {
        $this->setParameter('metadata', $metadata);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReference()
    {
        return $this->getParameter('reference');
    }

    /**
     * @param string $reference
     *
     * @return $this
     */
    public function setReference(string $reference): self
    {
        $this->setParameter('reference', $reference);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSettlementReference()
    {
        return $this->getParameter('settlement_reference');
    }

    /**
     * @param string $settlementReference
     *
     * @return $this
     */
    public function setSettlementReference(string $settlementReference): self
    {
        $this->setParameter('settlement_reference', $settlementReference);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSource()
    {
        return $this->getParameter('source');
    }

    /**
     * @param string $source
     *
     * @return $this
     */
    public function setSource(string $source): self
    {
        $this->setParameter('source', $source);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStoreId()
    {
        return $this->getParameter('store_id');
    }

    /**
     * @param string $storeId
     *
     * @return $this
     */
    public function setStoreId(string $storeId): self
    {
        $this->setParameter('store_id', $storeId);

        return $this;
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
     * If a customer is supplied, then return the customer data,
     * otherwise an empty array.
     *
     * @return array
     */
    public function getCustomerData()
    {
        $data = [];

        $customer = $this->getCustomer();

        if ($customer) {
            $data = $customer->toArray();

        }

        return $data;
    }

    /**
     * Return the settings data,
     *
     * @return array
     */
    public function getSettingsData()
    {
        $data = [];

        $settings = $this->getSettings();

        if ($settings) {
            $data = $settings->toArray();

        }

        return $data;
    }

    /**
     * @return array
     */
    protected function getOrderData(): array
    {
        $customerData = $this->getCustomerData();
        if (!empty($customerData)) {
            $data['customer'] = $customerData;
        }

        if (null !== $country = $this->getCountry()) {
            $data['country'] = $country;
        }

        if (null !== $currency = $this->getCurrency()) {
            $data['currency'] = $currency;
        }

        if (null !== $locale = $this->getLocale()) {
            $data['locale'] = $locale;
        }

        if (null !== $metadata = $this->getMetadata()) {
            $data['metadata'] = $metadata;
        }

        if (null !== $reference = $this->getReference()) {
            $data['reference'] = $reference;
        }

        if (null !== $settlementReference = $this->getSettlementReference()) {
            $data['settlementReference'] = $settlementReference;
        }

        if (null !== $source = $this->getSource()) {
            $data['source'] = $source;
        }

        if (null !== $storeId = $this->getStoreId()) {
            $data['storeId'] = $storeId;
        }

        if (null !== $orderLines = $this->getItemData($this->getItems())) {
            $data['orderLines'] = $orderLines;
        }
        $data['totalOrderAmount'] = $this->getTotalOrderAmount();
        $data['totalOrderAmountExclVat'] = $this->totalOrderAmountExclVat();
        $data['totalOrderVatAmount'] = $this->totalOrderVatAmount();

        return $data;
    }
}
