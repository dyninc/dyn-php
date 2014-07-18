<?php

namespace Dyn\TrafficManagement\Service;

abstract class AbstractService implements ServiceInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $fqdn;


    /**
     * Build a service instance based on API data
     *
     * @param  stdClass $data
     * @return object
     */
    public static function build($data)
    {
        $service = new static();

        foreach ($data as $property => $value) {
            if (in_array($property, array('zone'))) {
                continue;
            }

            // if (substr($property, 0, 7) == 'record_') {
            //     $property = substr($property, 7);
            // }
            $setter = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $property)));

            if (!method_exists($service, $setter)) {
                throw new \RuntimeException(
                    "Unable to set '$property' on ".get_class($service)." as " .
                    "no setter method exists"
                );
            }

            if (is_object($value)) {
                $service->$setter((array)$value);
            } else {
                $service->$setter($value);
            }
        }

        return $service;
    }

    /**
     * Returns the service type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
}
