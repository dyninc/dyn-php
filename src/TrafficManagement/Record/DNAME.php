<?php

namespace Dyn\TrafficManagement\Record;

class DNAME extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'DNAME';

    /**
     * @var string
     */
    protected $dname;


    /**
     * Setter for DNAME
     *
     * @param string $dname
     */
    public function setDName($dname)
    {
        $this->dname = $dname;

        return $this;
    }

    /**
     * Getter for DNAME
     *
     * @return string
     */
    public function getDName()
    {
        return $this->dname;
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
            'dname' => $this->getDName()
        );
    }
}
