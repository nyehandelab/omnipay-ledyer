<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Ledyer;

use Omnipay\Common\Helper;
use Omnipay\Common\ParametersTrait;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Customer
 *
 * This class defines a customer in the Omnipay system.
 *
 */
class Customer
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
     * {@inheritDoc}
     */
    public function getCompanyId()
    {
        return $this->getParameter('company_id');
    }

    /**
     * Set the customers company id
     */
    public function setCompanyId($value)
    {
        return $this->setParameter('company_id', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getFirstName()
    {
        return $this->getParameter('first_name');
    }

    /**
     * Set the customers first name
     */
    public function setFirstName($value)
    {
        return $this->setParameter('first_name', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getLastName()
    {
        return $this->getParameter('last_name');
    }

    /**
     * Set the customers last name
     */
    public function setLastName($value)
    {
        return $this->setParameter('last_name', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail()
    {
        return $this->getParameter('email');
    }

    /**
     * Set the customers email
     */
    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    /**
     * Set the customers phone number
     */
    public function setPhone($value)
    {
        return $this->setParameter('phone', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getReference1()
    {
        return $this->getParameter('reference_1');
    }

    /**
     * Set the customers reference 1
     */
    public function setReference1($value)
    {
        return $this->setParameter('reference_1', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getReference2()
    {
        return $this->getParameter('reference_2');
    }

    /**
     * Set the customers reference 2
     */
    public function setReference2($value)
    {
        return $this->setParameter('reference_2', $value);
    }

    public function toArray()
    {
        return [
            'companyId' => $this->getCompanyId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'reference1' => $this->getReference1(),
            'reference2' => $this->getReference2(),
        ];
    }
}
