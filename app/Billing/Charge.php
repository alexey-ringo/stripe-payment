<?php


namespace App\Billing;


class Charge
{
    protected $parameters;

    /**
     * Charge constructor.
     * @param $parameters
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getBillingId()
    {
        return $this->parameters['id'];
    }

    public function getAmount()
    {
        return $this->parameters['amount'];
    }
}
