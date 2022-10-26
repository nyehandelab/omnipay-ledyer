<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer;

use Nyehandel\Omnipay\Ledyer\Exceptions\InvalidSettingsException;
use Omnipay\Common\Helper;
use Omnipay\Common\ParametersTrait;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Settings
 *
 * This class defines the Settings in the Omnipay system.
 *
 */
class Settings
{
    use ParametersTrait;

    /**
     * Create a new item with the specified parameters
     *
     * @param array|null $parameters An array of parameters to set on the new object
     */
    public function __construct(array $parameters = null)
    {
        $this->initialize($parameters);
    }

    /**
     * Initialize this item with the specified parameters
     *
     * @param array|null $parameters An array of parameters to set on this object
     * @return $this Item
     */
    public function initialize(array $parameters = null)
    {
        $this->parameters = new ParameterBag;

        Helper::initialize($this, $parameters);

        return $this;
    }

    /**
     * Validate the settings
     *
     * 
     * @return void
     * @throws Exception\InvalidRequestException
     * @throws InvalidSettingsException
     */
    public function validate()
    {
        $requiredParameters = array(
            'urls' => [
                'terms' => 'merchant terms'
            ],
        );

        foreach ($requiredParameters as $key => $values) {
            $parameter = $this->getParameter($key);

            foreach ($values as $subKey => $subValue) {
                if (!array_key_exists($subKey, $parameter)) {
                    throw new InvalidSettingsException("The $subValue is required");
                }
            }

            if (!$parameter) {
                throw new InvalidSettingsException("The $val is required");
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getSecurity()
    {
        return $this->getParameter('security');
    }

    /**
     * Set the security settings 
     */
    public function setSecurity($value)
    {
        return $this->setParameter('security', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomer()
    {
        return $this->getParameter('customer');
    }

    /**
     * Set the customer settings
     */
    public function setCustomer($value)
    {
        return $this->setParameter('customer', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getUrls()
    {
        return $this->getParameter('urls');
    }

    /**
     * Set the customers last name
     */
    public function setUrls($value)
    {
        return $this->setParameter('urls', $value);
    }

    public function toArray()
    {
        return [
            'security' => $this->getSecurity(),
            'customer' => $this->getCustomer(),
            'urls' => $this->getUrls(),
        ];
    }
}
