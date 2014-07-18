<?php

namespace Dyn\TrafficManagement\Record;

class NS extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'NS';

    /**
     * Hostname of the authoritative Nameserver for the zone.
     *
     * @var string
     */
    protected $nsdname;


    /**
     * Setter for nsdname
     *
     * @param string $nsdname
     */
    public function setNsdname($nsdname)
    {
        $this->nsdname = $nsdname;

        return $this;
    }

    /**
     * Getter for nsdname
     *
     * @return string
     */
    public function getNsdname()
    {
        return $this->nsdname;
    }

    /**
     * Setter for RDATA. Parses values into the correct properties
     *
     * @param array $rdata
     */
    public function setRData(array $rdata)
    {
        if (isset($rdata['nsdname'])) {
            $this->setNsdname($rdata['nsdname']);
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
            'nsdname' => $this->getNsdname()
        );
    }
}
