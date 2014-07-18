<?php

namespace Dyn\TrafficManagement\Service;

use Dyn\TrafficManagement\Service\AbstractService;

class HTTPRedirect extends AbstractService
{
    /**
     * @var string
     */
    protected $type = 'HTTPRedirect';

    /**
     * HTTP response code to return for redirection
     *
     * @var integer
     */
    protected $code;

    /**
     * A flag indicating whether the redirection should include the originally requested URI
     *
     * @var boolean
     */
    protected $keepUri;

    /**
     * The target URL where the client is sent. Must begin with either http:// or https://.
     *
     * @var string
     */
    protected $url;


    /**
     * Setter for code
     *
     * @param integer $code
     */
    public function setCode($code)
    {
        if (!is_numeric($code)) {
            throw new \InvalidArgumentException('Code must be numeric');
        }

        if ($code != 301 && $code != 302) {
            throw new \InvalidArgumentException('Invalid code provided');
        }

        $this->code = $code;

        return $this;
    }

    /**
     * Getter for code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Setter for keep URI
     *
     * @param boolean $keepUri
     */
    public function setKeepUri($keepUri)
    {
        $this->keepUri = $keepUri;

        return $this;
    }

    /**
     * Getter for keep URI
     *
     * @return boolean
     */
    public function getKeepUri()
    {
        return $this->keepUri;
    }

    /**
     * Setter for URL
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Getter for URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns an array of service params
     *
     * @return array
     */
    public function getParams()
    {
        return array(
            'code' => $this->getCode(),
            'keep_uri' => $this->getKeepUri(),
            'url' => $this->getUrl()
        );
    }
}
