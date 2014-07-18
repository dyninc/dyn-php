<?php

namespace Dyn\TrafficManagement\Record;

use Dyn\TrafficManagement\Record\RecordInterface;

abstract class AbstractRecord implements RecordInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $fqdn;

    /**
     * @var integer
     */
    protected $ttl;

    /**
     * @var array
     */
    protected $rdata;


    /**
     * Build a record instance based on API data
     *
     * @param  stdClass $data
     * @return object
     */
    public static function build($data)
    {
        $record = new static();

        foreach ($data as $property => $value) {
            if (in_array($property, array('zone', 'record_type', 'service_class'))) {
                continue;
            }

            if (substr($property, 0, 7) == 'record_') {
                $property = substr($property, 7);
            }
            $setter = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $property)));

            if (!method_exists($record, $setter)) {
                throw new \RuntimeException(
                    "Unable to set '$property' on ".get_class($record)." as " .
                    "no setter method exists"
                );
            }

            if (is_object($value)) {
                $record->$setter((array)$value);
            } else {
                $record->$setter($value);
            }
        }

        return $record;
    }

    /**
     * Getter for type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Setter for id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Getter for id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter for FQDN
     *
     * @param string $fqdn
     */
    public function setFqdn($fqdn)
    {
        $this->fqdn = $fqdn;

        return $this;
    }

    /**
     * Getter for FQDN
     *
     * @return string
     */
    public function getFqdn()
    {
        return $this->fqdn;
    }

    /**
     * Setter for TTL. Use 0 if you want to use the zone default.
     *
     * @param integer $ttl
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Getter for TTL
     *
     * @return string
     */
    public function getTtl()
    {
        return $this->ttl;
    }
}
