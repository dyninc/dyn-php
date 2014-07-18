<?php

namespace Dyn\TrafficManagement\Record;

class SRV extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'SRV';

    /**
     * Indicates the port where the service is running
     *
     * @var integer
     */
    protected $port;

    /**
     * Numeric value for priority usage. Lower value takes precedence over
     * higher value where two records of the same type exist on the zone/node.
     *
     * @var integer
     */
    protected $priority;

    /**
     * The domain name of a host where the service is running on the specified port
     *
     * @var string
     */
    protected $target;

    /**
     * Secondary prioritizing of records to serve. Records of equal priority should
     * be served based on their weight. Higher values are served more often.
     *
     * @var integer
     */
    protected $weight;

    /**
     * Setter for port
     *
     * @param integer $port
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Getter for port
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Setter for priority
     *
     * @param integer $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Getter for priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Setter for target
     *
     * @param string $target
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Getter for target
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Setter for weight
     *
     * @param integer $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Getter for weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
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
            'port' => $this->getPort(),
            'priority' => $this->getPriority(),
            'target' => $this->getTarget(),
            'weight' => $this->getWeight()
        );
    }
}
