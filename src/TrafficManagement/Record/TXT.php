<?php

namespace Dyn\TrafficManagement\Record;

class TXT extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'TXT';

    /**
     * @var string
     */
    protected $txtdata;


    /**
     * Setter for txtdata
     *
     * @param string $txtdata
     */
    public function setTxtdata($txtdata)
    {
        $this->txtdata = $txtdata;

        return $this;
    }

    /**
     * Getter for txtdata
     *
     * @return string
     */
    public function getTxtdata()
    {
        return $this->txtdata;
    }

    /**
     * Setter for RDATA. Parses values into the correct properties
     *
     * @param array $rdata
     */
    public function setRData(array $rdata)
    {
        $this->rdata = $rdata;
        $this->txtdata = $rdata['txtdata'];
    }

    /**
     * Getter for RDATA
     *
     * @return array
     */
    public function getRData()
    {
        return array(
            'txtdata' => $this->getTxtdata()
        );
    }
}
