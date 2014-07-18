<?php

namespace Dyn\TrafficManagement\Record;

class RP extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'RP';

    /**
     * mail address of the Responsible Person. Data format: Replace @ symbol with a dot '.'
     * in the address. Example: mail.sample.com
     *
     * @var string
     */
    protected $mbox;

    /**
     * Hostname where a TXT record exists with more information on the responsible perso
     *
     * @var string
     */
    protected $txtdname;


    /**
     * Setter for mbox
     *
     * @param string $mbox
     */
    public function setMbox($mbox)
    {
        $this->mbox = $mbox;

        return $this;
    }

    /**
     * Getter for mbox
     *
     * @return string
     */
    public function getMbox()
    {
        return $this->mbox;
    }

    /**
     * Setter for txtdname
     *
     * @param string $txtdname
     */
    public function setTxtdname($txtdname)
    {
        $this->txtdname = $txtdname;

        return $this;
    }

    /**
     * Getter for txtdname
     *
     * @return string
     */
    public function getTxtdname()
    {
        return $this->txtdname;
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
            'nsap' => $this->getNsap()
        );
    }
}
