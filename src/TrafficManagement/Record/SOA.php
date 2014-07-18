<?php

namespace Dyn\TrafficManagement\Record;

class SOA extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'SOA';

    /**
     * @var string
     */
    protected $rname;

    /**
     * @var string
     */
    protected $serialStyle;


    /**
     * Setter for rname
     *
     * @param string $rname
     */
    public function setRname($rname)
    {
        $this->rname = $rname;

        return $this;
    }

    /**
     * Getter for rname
     *
     * @return string
     */
    public function getRname()
    {
        return $this->rname;
    }

    /**
     * Setter for serial style
     *
     * @param string $serialStyle
     */
    public function setSerialStyle($serialStyle)
    {
        $this->serialStyle = $serialStyle;

        return $this;
    }

    /**
     * Getter for serial style
     *
     * @return string
     */
    public function getSerialStyle()
    {
        return $this->serialStyle;
    }

    /**
     * Setter for RDATA. Parses values into the correct properties
     *
     * @param array $rdata
     */
    public function setRData(array $rdata)
    {
        if (isset($rdata['rname'])) {
            $this->setRname($rdata['rname']);
        }

        // TODO: parse other fields

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
            'rname' => $this->getRName()
        );
    }
}
