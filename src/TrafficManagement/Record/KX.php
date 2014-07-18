<?php

namespace Dyn\TrafficManagement\Record;

class KX extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'KX';

    /**
     * Hostname that will act as the Key Exchanger. The hostname must have a
     * CNAME record, an A Record and/or an AAAA record associated with it.
     *
     * @var string
     */
    protected $exchange;

    /**
     * Numeric value for priority usage. Lower value takes precedence over
     * higher value where two records of the same type exist on the zone/node.
     * @var int
     */
    protected $preference;


    /**
     * Setter for exchange
     *
     * @param string $exchange
     */
    public function setExchange($exchange)
    {
        $this->exchange = $exchange;

        return $this;
    }

    /**
     * Getter for exchange
     *
     * @return string
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * Setter for preference
     *
     * @param int $preference
     */
    public function setPreference($preference)
    {
        if (!is_numeric($preference)) {
            throw new \InvalidArgumentException(
                'KX record preference must be numeric, '.
                gettype($preference).' given'
            );
        }

        $this->preference = $preference;

        return $this;
    }

    /**
     * Getter for preference
     *
     * @return string
     */
    public function getPreference()
    {
        return $this->preference;
    }

    /**
     * Setter for RDATA. Parses values into the correct properties
     *
     * @param array $rdata
     */
    public function setRData(array $rdata)
    {
        // TODO

        return $this;
    }

    /**
     * Getter for RDATA
     *
     * @return array
     */
    public function getRData()
    {
        return array(
            'exchange' => $this->getExchange(),
            'preference' => $this->getPreference()
        );
    }
}
