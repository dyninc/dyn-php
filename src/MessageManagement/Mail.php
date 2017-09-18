<?php

namespace Dyn\MessageManagement;

use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Dyn\MessageManagement\Mail\MailInterface;
use RuntimeException;
use InvalidArgumentException;

class Mail extends Message implements MailInterface
{
    /**
     * @var array
     */
    protected $xheaders;


    /**
     * Returns the properties in an array format as expected by the API
     *
     * @return array
     */
    public function toApiParams()
    {
        $params = array();

        // From address (required)
        $fromAddress = $this->getFrom();
        if (count($fromAddress) == 1) {
            $params['from'] = $fromAddress->current()->toString();
        }


        $addressHeaders = array(
            'to' => 'To',
            'cc' => 'Cc',
            'bcc' => 'Bcc',
            'replyto' => 'ReplyTo'
        );

        foreach ($addressHeaders as $shortname => $name) {
            $addresses = $this->{'get'.$name}();
            if (count($addresses) > 0) {
                if (count($addresses) == 1) {
                    $params[$shortname] = $addresses->current()->toString();
                } else {
                    $params[$shortname] = array();
                    foreach ($addresses as $address) {
                        $params[$shortname][] = $address->toString();
                    }
                }
            }
        }

        // Subject (required)
        $params['subject'] = $this->getSubject();

        // Sender (optional)
        $sender = $this->getSender();
        if ($sender) {
            $params['sender'] = $sender->toString();
        }

        // Handle extra optional headers
        $extraHeaders = array(
            'messageid' => 'Message-ID',
            'comments' => 'Comments',
            'keywords' => 'Keywords',
            'replyby' => 'Reply-By',
            'importance' => 'Importance',
            'priority' => 'Priority',
            'sensitivity' => 'Sensitivity',
            'inreplyto' => 'In-Reply-To',
            'references' => 'References',
            'resent-date' => 'Resent-Date',
            'resent-from' => 'Resent-From',
            'resent-sender' => 'Resent-Sender',
            'resent-replyto' => 'Resent-Reply-To',
            'resent-messageid' => 'Resent-Message-ID'
        );

        $headers = $this->getHeaders();
        foreach ($extraHeaders as $shortname => $name) {
            $header = $headers->get($name);
            if ($header) {
                $value = $header->getFieldValue();
                if (!empty($value)) {
                    $params[$shortname] = $value;
                }
            }
        }

        // Mail body
        $body = $this->getBody();
        if (is_string($body)) {
            // assume plain text body
            $params['bodytext'] = $body;

        } elseif ($body instanceof MimeMessage) {
            $parts = $body->getParts();
            foreach ($parts as $part) {
                if ($part->type == 'text/plain') {
                    $params['bodytext'] = $part->getRawContent();
                } elseif ($part->type == 'text/html') {
                    $params['bodyhtml'] = $part->getRawContent();
                } else {
                    throw new RuntimeException(
                        'Currently, only text/plain and text/html MIME parts
                        are supported'
                    );
                }
            }
        }

        // X-Headers (optional)
        if (!empty($this->xheaders)) {
            foreach ($this->xheaders as $header => $value) {
                $params[$header] = $value;
            }
        }

        return $params;
    }

    /**
     * Setter for text body
     *
     * @param string $textBody
     */
    public function setTextBody($textBody)
    {
        if ($this->getBody() === null) {
            $message = new MimeMessage();
            $this->setBody($message);
        }

        $textPart = new MimePart($textBody);
        $textPart->type = "text/plain";

        $this->getBody()->addPart($textPart);

        return $this;
    }

    /**
     * Setter for HTML body
     *
     * @param string $htmlBody
     */
    public function setHtmlBody($htmlBody)
    {
        if ($this->getBody() === null) {
            $message = new MimeMessage();
            $this->setBody($message);
        }

        $htmlPart = new MimePart($htmlBody);
        $htmlPart->type = "text/html";

        $this->getBody()->addPart($htmlPart);

        return $this;
    }

    /**
     * Setter for X-Headers
     *
     * @param string $name  The header name, e.g. X-Foo
     * @param mixed  $value The header value
     */
    public function setXHeader($name, $value)
    {
        if (substr($name, 0, 2) !== 'X-') {
            throw new InvalidArgumentException(
                "Invalid X-Header name provided. X-Headers must start with 'X-'"
            );
        }

        if ($this->xheaders === null) {
            $this->xheaders = array();
        }

        $this->xheaders[$name] = $value;

        return $this;
    }
}
