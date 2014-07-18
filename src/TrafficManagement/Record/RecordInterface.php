<?php

namespace Dyn\TrafficManagement\Record;

interface RecordInterface
{
    public function getType();

    /**
     * Setter for RData. Should parse the rdata array (as returned by the API)
     * and call the relevant setter methods from the class.
     *
     * @param array $rdata
     */
    public function setRData(array $rdata);

    /**
     * Getter for RData. Should build the RData array by calling the other
     * relevant getter methods from the class.
     *
     * @return array
     */
    public function getRData();
}
