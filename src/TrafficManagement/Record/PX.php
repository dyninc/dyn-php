<?php

namespace Dyn\TrafficManagement\Record;

class PX extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'PX';

    /**
     * Sets priority for processing records of the same type. Lowest value is processed first.
     *
     * @var string
     */
    protected $preference;

    /**
     * Mail hostname
     *
     * @var string
     */
    protected $map822;

    /**
     * Enter the domain name derived from the X.400 part of MCGAM.
     *
     * @var string
     */
    protected $mapx400;

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
     * Setter for map822
     *
     * @param string $map822
     */
    public function setMap822($map822)
    {
        $this->map822 = $map822;

        return $this;
    }

    /**
     * Getter for map822
     *
     * @return string
     */
    public function getMap822()
    {
        return $this->map822;
    }

    /**
     * Setter for mapx400
     *
     * @param string $mapx400
     */
    public function setMapx400($mapx400)
    {
        $this->mapx400 = $mapx400;

        return $this;
    }

    /**
     * Getter for mapx400
     *
     * @return string
     */
    public function getMapx400()
    {
        return $this->mapx400;
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
            'preference' => $this->getPreference(),
            'map822' => $this->getMap822(),
            'mapx400' => $this->getMapx400()
        );
    }
}
