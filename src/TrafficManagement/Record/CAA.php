<?php

namespace Dyn\TrafficManagement\Record;

class CAA extends AbstractRecord
{
    /**
     * @var string
     */
    protected $type = 'CAA';

    /**
     * @var int
     */
    protected $flags;

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var string
     */
    protected $value;


    /**
     * Setter for flags
     *
     * @param int $flags
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Getter for flags
     *
     * @return int
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Setter for tag
     *
     * @param int $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Getter for tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Setter for value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Getter for value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Setter for RDATA. Parses values into the correct properties
     *
     * @param array $rdata
     */
    public function setRData(array $rdata)
    {
        if (isset($rdata['flags'])) {
            $this->setFlags($rdata['flags']);
        }
        if (isset($rdata['tag'])) {
            $this->setTag($rdata['tag']);
        }
        if (isset($rdata['value'])) {
            $this->setValue($rdata['value']);
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
            'flags' => $this->getFlags(),
            'tag' => $this->getTag(),
            'value' => $this->getValue()
        );
    }
}
