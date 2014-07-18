<?php

namespace Dyn\TrafficManagement\Record;

class PTR extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'PTR';

    /**
     * Hostname where the IP address should be directed. Example: mail.example.com
     *
     * @var string
     */
    protected $ptrdname;


    /**
     * Setter for ptrdname
     *
     * @param string $ptrdname
     */
    public function setPtrdname($ptrdname)
    {
        $this->ptrdname = $ptrdname;

        return $this;
    }

    /**
     * Getter for ptrdname
     *
     * @return string
     */
    public function getPtrdname()
    {
        return $this->ptrdname;
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
            'ptrdname' => $this->getPtrdname()
        );
    }
}
