<?php

namespace Dyn\TrafficManagement\Record;

class LOC extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'LOC';

    /**
     * Measured in meters above sea level.
     *
     * @var string
     */
    protected $altitude;

    /**
     * Defaults to 10,000 meters.
     *
     * @var string
     */
    protected $horizPre;

    /**
     * Measured in degrees, minutes, and seconds with N/S indicator for North
     * and South. Example: 45 24 15 N, where 45 = degrees, 24 = minutes,
     * 15 = seconds.
     *
     * @var string
     */
    protected $latitude;

    /**
     * Measured in degrees, minutes, and seconds with E/W indicator for East
     * and West. Example 89 23 18 W, where 89 = degrees, 23 = minutes,
     * 18 = seconds.
     *
     * @var string
     */
    protected $longitude;

    /**
     * Defaults to 1 meter.
     *
     * @var string
     */
    protected $size;

    /**
     * Number of the representation. Must be zero (0).
     *
     * @var string
     */
    protected $version;

    /**
     * Defaults to 10 meters.
     *
     * @var string
     */
    protected $vert_pre;


    /**
     * Setter for altitude
     *
     * @param string $altitude
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;

        return $this;
    }

    /**
     * Getter for altitude
     *
     * @return string
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * Setter for horiz pre
     *
     * @param string $horizPre
     */
    public function setHorizPre($horizPre)
    {
        $this->horizPre = $horizPre;

        return $this;
    }

    /**
     * Getter for horiz pre
     *
     * @return string
     */
    public function getHorizPre()
    {
        return $this->horizPre;
    }

    /**
     * Setter for latitude
     *
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->lattiude = $latitude;

        return $this;
    }

    /**
     * Getter for latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Setter for longitude
     *
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Getter for longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Setter for size
     *
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Getter for size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Setter for version
     *
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Getter for version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Setter for version
     *
     * @param string $version
     */
    public function setVertPre($vertPre)
    {
        $this->vertPre = $vertPre;

        return $this;
    }

    /**
     * Getter for vert pre
     *
     * @return string
     */
    public function getVertPre()
    {
        return $this->vertPre;
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
            'altitude' => $this->getAltitude(),
            'horiz_pre' => $this->getHorizPre(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
            'size' => $this->getSize(),
            'version' => $this->getVesion(),
            'vert_pre' => $this->getVertPre()
        );
    }
}
