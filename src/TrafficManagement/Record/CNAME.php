<?php

namespace Dyn\TrafficManagement\Record;

class CNAME extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'CNAME';

    /**
     * @var string
     */
    protected $cname;


    /**
     * Setter for CNAME
     *
     * @param string $cname
     */
    public function setCName($cname)
    {
        $this->cname = $cname;

        return $this;
    }

    /**
     * Getter for CNAME
     *
     * @return string
     */
    public function getCName()
    {
        return $this->cname;
    }

    /**
     * Setter for RDATA. Parses values into the correct properties
     *
     * @param array $rdata
     */
    public function setRData(array $rdata)
    {
        if (isset($rdata['cname'])) {
            $this->setCName($rdata['cname']);
        }

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
            'cname' => $this->getCName()
        );
    }
}
