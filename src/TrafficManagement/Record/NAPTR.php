<?php

namespace Dyn\TrafficManagement\Record;

class NAPTR extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'NAPTR';

    /**
     * Indicates the required priority for processing NAPTR records.
     * Lowest value is used first.
     *
     * @var string
     */
    protected $order;

    /**
     * Indicates priority where two or more NAPTR records have identical
     * order values. Lowest value is used first.
     *
     * @var string
     */
    protected $preference;

    /**
     * Should be the letter "U". This indicates that this NAPTR record
     * terminal (E.164 number that maps directly to a URI)
     *
     * @var string
     */
    protected $flags;

    /**
     * Always starts with “e2u+” (E.164 to URI). After the e2u+ there is a
     * string that defines the type and optionally the subtype of the URI
     * where this NAPTR record points.
     *
     * @var string
     */
    protected $services;

    /**
     * @var string
     */
    protected $regexp;

    /**
     * The next domain name to find. Only applies if this NAPTR record is
     * non-terminal.
     *
     * @var string
     */
    protected $replacement;


    /**
     * Setter for order
     *
     * @param string $order
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Getter for order
     *
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Setter for preference
     *
     * @param string $preference
     */
    public function setPreference($preference)
    {
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
     * Setter for order
     *
     * @param string $order
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Getter for flags
     *
     * @return string
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Setter for services
     *
     * @param string $services
     */
    public function setSServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Getter for services
     *
     * @return string
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Setter for regexp
     *
     * @param string $regexp
     */
    public function setRegexp($regexp)
    {
        $this->regexp = $regexp;

        return $this;
    }

    /**
     * Getter for regexp
     *
     * @return string
     */
    public function getRegexp()
    {
        return $this->regexp;
    }

    /**
     * Setter for replacement
     *
     * @param string $replacement
     */
    public function setReplacement($replacement)
    {
        $this->replacement = $replacement;

        return $this;
    }

    /**
     * Getter for replacement
     *
     * @return string
     */
    public function getReplacement()
    {
        return $this->replacement;
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
            'order' => $this->getOrder(),
            'preference' => $this->getPreference(),
            'flags' => $this->getFlags(),
            'services' => $this->getServices(),
            'regexp' => $this->getRegexp(),
            'replacement' => $this->getReplacement()
        );
    }
}
