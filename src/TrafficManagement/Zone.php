<?php

namespace Dyn\TrafficManagement;

use Dyn\TrafficManagement\Record\RecordInterface;
use Dyn\TrafficManagement\Api\Client as ApiClient;

class Zone
{
    /**
     * The zone name, e.g. example.com
     *
     * @var string
     */
    protected $name;

    /**
     * The zone type, either 'Primary' or 'Secondary'
     *
     * @var string
     */
    protected $type;

    /**
     * One of 'increment', 'epoch', 'day', 'minute'. Increment is the default.
     *
     * @var string
     */
    protected $serialStyle;

    /**
     * @var integer
     */
    protected $serial;

    /**
     * @var string
     */
    protected $rname;

    /**
     * Default TTL for the zone
     *
     * @var integer
     */
    protected $defaultTtl;

    /**
     * Dyn API client instance
     *
     * @var ApiClient
     */
    protected $apiClient;


    /**
     * Constructor
     *
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Setter for zone name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter for zone name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter for type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
     * Setter for serial style. Valid values:
     *  * increment - Serials are incremented by 1 on every change. Default setting.
     *  * epoch - Serials will be the UNIX timestamp at the time of the publish.
     *  * day - Serials will be in the form of YYYYMMDDxx where xx is incremented
     *          by one for each change during that particular day.
     *  * minute - Serials will be in the form of YYMMDDHHMM.
     *
     * @param string $serialStyle
     */
    public function setSerialStyle($serialStyle)
    {
        $validSerialStyles = array('increment', 'epoch', 'day', 'minute');

        if (!in_array($serialStyle, $validSerialStyles)) {
            throw new \InvalidArgumentException(
                'Invalid serial style specified. Must be one of: ' .
                implode(', ', $validSerialStyles)
            );
        }

        $this->serialStyle = $serialStyle;

        return $this;
    }

    /**
     * Getter for serial style
     *
     * @return string
     */
    public function getSerialStyle()
    {
        return $this->serialStyle;
    }

    /**
     * Setter for serial
     *
     * @param integer $serial [description]
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Getter for serial
     *
     * @return integer
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Setter for rname
     *
     * @param string $rname
     */
    public function setRname($rname)
    {
        $this->rname = $rname;

        return $this;
    }

    /**
     * Getter for rname
     *
     * @return string
     */
    public function getRname()
    {
        return $this->rname;
    }

    /**
     * Setter for default TTL
     *
     * This is mainly used for object creation
     *
     * @param integer $defaultTtl
     */
    public function setDefaultTtl($defaultTtl)
    {
        $this->defaultTtl = $defaultTtl;

        return $this;
    }

    /**
     * Getter for default TTL
     *
     * @param  integer $defaultTtl
     * @return integer
     */
    public function getDefaultTtl($defaultTtl)
    {
        return $this->defaultTtl;
    }

    /**
     * Create the supplied record
     *
     * @param  RecordInterface $record
     * @return boolean|Dyn\TrafficManagement\Api\Response
     */
    public function createRecord(RecordInterface $record)
    {
        $params = array(
            'rdata' => $record->getRData(),
            'ttl' => $record->getTtl()
        );

        return $this->createRecordFromParams($record->getType(), $record->getFqdn(), $params);
    }

    /**
     * Create a record with the supplied values
     *
     * @param  string $type   Record type to create, A, CNAME etc.
     * @param  string $fqdn   FQDN of the record to create
     * @param  array  $params Array of record parameters
     * @return boolean|Dyn\TrafficManagement\Api\Response
     */
    public function createRecordFromParams($type, $fqdn, array $params)
    {
        $result = $this->apiClient->post('/'.$type.'Record/'.$this->getName().'/'.$fqdn.'/', $params);
        if ($result && $result->isOk()) {
            if ($result->isComplete()) {
                return true;
            } else {
                return $result;
            }
        }

        return false;
    }

    /**
     * Returns a specific record by ID
     *
     * @param  string  $type  The record type, e.g. A, AAAA, CNAME
     * @param  string  $fqdn  The FQDN of the record to be returned
     * @param  integer $id    The numeric ID of the record to be returned
     * @return RecordInterface
     */
    public function getRecord($type, $fqdn, $id)
    {
        $path = '/'.$type.'Record/'.$this->getName().'/'.$fqdn.'/'.$id.'/';

        $result = $this->apiClient->get($path, array('detail' => 'y'));
        if ($result && $result->isComplete()) {
            $className = 'Dyn\TrafficManagement\Record\\'.$type;
            $record = $className::build($result->data);

            return $record;
        }

        return $result;
    }

    /**
     * Returns the record(s) of the specified type with the specified FQDN, or false
     * if none exist.
     *
     * @param  string $type  The record type, e.g. A, AAAA, CNAME
     * @param  string $fqdn  The FQDN of the record(s) to be returned
     * @return array|false
     */
    public function getRecords($type, $fqdn)
    {
        $path = '/'.$type.'Record/'.$this->getName().'/'.$fqdn.'/';

        $result = $this->apiClient->get($path, array('detail' => 'y'));
        if ($result && $result->isComplete()) {
            $className = 'Dyn\TrafficManagement\Record\\'.$type;

            $records = array();
            foreach ($result->data as $recordData) {
                $record = $className::build($recordData);
                $records[] = $record;
            }

            return $records;
        }

        return $result;
    }

    /**
     * Updates the specified record
     *
     * @param  RecordInterface $record
     * @return boolean|Dyn\TrafficManagement\Api\Response
     */
    public function updateRecord(RecordInterface $record)
    {
        $type = $record->getType();
        $fqdn = $record->getFqdn();
        $id = $record->getId();

        $params = array(
            'rdata' => $record->getRData(),
            'ttl' => $record->getTtl()
        );

        return $this->updateRecordFromParams($type, $fqdn, $id, $params);
    }

    /**
     * Updates a record with the specified values
     *
     * @param  string  $type
     * @param  string  $fqdn
     * @param  integer $id
     * @param  array   $params
     * @return boolean|Dyn\TrafficManagement\Api\Response
     */
    public function updateRecordFromParams($type, $fqdn, $id, array $params)
    {
        $path = '/'.$type.'Record/'.$this->getName().'/'.$fqdn.'/'.$id.'/';

        $result = $this->apiClient->put($path, $params);
        if ($result && $result->isOk()) {
            if ($result->isComplete()) {
                return true;
            } else {
                return $result;
            }
        }

        return false;
    }

    /**
     * Delete the specified record
     *
     * @param  RecordInterface        $record
     * @return boolean|Dyn\TrafficManagement\Api\Response
     */
    public function deleteRecord(RecordInterface $record)
    {
        $type = $record->getType();
        $fqdn = $record->getFqdn();
        $id = $record->getId();

        return $this->deleteRecordFromParams($type, $fqdn, $id);
    }

    /**
     * Deletes a specific record
     *
     * @param  string   $type
     * @param  string   $fqdn
     * @param  integer  $id
     * @return boolean|Dyn\TrafficManagement\Api\Response
     */
    public function deleteRecordFromParams($type, $fqdn, $id)
    {
        $path = '/'.$type.'Record/'.$this->getName().'/'.$fqdn.'/'.$id.'/';

        $result = $this->apiClient->delete($path);
        if ($result && $result->isOk()) {
            if ($result->isComplete()) {
                return true;
            } else {
                return $result;
            }
        }

        return false;
    }

    /**
     * Deletes all records of a specified type at the specified FQDN
     *
     * @param  string $type
     * @param  string $fqdn
     * @return boolean|Dyn\TrafficManagement\Api\Response
     */
    public function deleteRecords($type, $fqdn)
    {
        $path = '/'.$type.'Record/'.$this->getName().'/'.$fqdn.'/';

        $result = $this->apiClient->delete($path);
        if ($result && $result->isOk()) {
            if ($result->isComplete()) {
                return true;
            } else {
                return $result;
            }
        }

        return false;
    }

    /**
     * Returns all records on this zone, grouped by type. If a FQDN is provided,
     * returns only records from that point in the zone heirarchy and below.
     *
     * @param  string $fqdn
     * @return array
     */
    public function getAllRecords($fqdn = null)
    {
        $path = '/AllRecord/'.$this->name;
        if ($fqdn) {
            $path .= '/'.$fqdn;
        }
        $path .= '/';

        $result = $this->apiClient->get($path, array('detail' => 'y'));
        if ($result && $result->isComplete()) {
            // convert the result into objects of the correct type
            $records = array();
            foreach ($result->data as $key => $recordData) {
                // workout the class name (ns_records -> NS)
                $type = strtoupper(substr($key, 0, strpos($key, '_')));
                $className = 'Dyn\TrafficManagement\Record\\'.$type;

                $records[$type] = array();
                if (count($recordData) > 0) {
                    foreach ($recordData as $recordRow) {
                        $record = $className::build($recordRow);
                        $records[$className][] = $record;
                    }
                }
            }

            return $records;
        }

        return false;
    }

    /**
     * Publish changes made to the zone
     *
     * @return Dyn\TrafficManagement\Api\Response
     */
    public function publish()
    {
        return $this->apiClient->put(
            '/Zone/'.$this->getName(),
            array(
                'publish' => true
            )
        );
    }

    /**
     * Freeze the zone, preventing changes to it until it is thawed.
     *
     * @return Dyn\TrafficManagement\Api\Response
     */
    public function freeze()
    {
        return $this->apiClient->put(
            '/Zone/'.$this->getName(),
            array(
                'freeze' => true
            )
        );
    }

    /**
     * Thaw a frozen zone, allowing changes to be made again
     *
     * @return Dyn\TrafficManagement\Api\Response
     */
    public function thaw()
    {
        return $this->apiClient->put(
            '/Zone/'.$this->getName(),
            array(
                'thaw' => true
            )
        );
    }

    /**
     * Returns any unpublished changes made within the current session
     *
     * @return array|false|Dyn\TrafficManagement\Api\Response
     */
    public function getChanges()
    {
        $result = $this->apiClient->get('/ZoneChanges/'.$this->getName());
        if ($result && $result->isOk()) {
            if ($result->isComplete()) {
                return $result->data;
            } else {
                return $result;
            }
        }

        return false;
    }

    /**
     * Discards any unpublished changes made within the current session
     *
     * @return boolean|Dyn\TrafficManagement\Api\Response
     */
    public function discardChanges()
    {
        $result = $this->apiClient->delete('/ZoneChanges/'.$this->getName());
        if ($result && $result->isOk()) {
            if ($result->isComplete()) {
                return true;
            } else {
                return $result;
            }
        }

        return false;
    }
}
