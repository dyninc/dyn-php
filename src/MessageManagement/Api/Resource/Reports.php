<?php

namespace Dyn\MessageManagement\Api\Resource;

use InvalidArgumentException;
use DateTime;

class Reports extends AbstractResource
{
    /**
     * Build a params array from optional report values
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @param  null|string          $sender    Optional sender email address
     * @param  null|array           $xHeaders  Optional array of X-Header values
     * @return array
     */
    protected function buildBasicParams($startDate = null, $endDate = null, $sender = null, $xHeaders = null)
    {
        $params = array();

        // optional start date
        if ($startDate) {
            if (!($startDate instanceof DateTime)) {
                $startDate = new DateTime($startDate);
            }

            $params['starttime'] = $startDate->format(DateTime::ISO8601);
        }

        // add optional end date
        if ($endDate) {
            if (!($endDate instanceof DateTime)) {
                $endDate = new DateTime($endDate);
            }

            $params['endtime'] = $endDate->format(DateTime::ISO8601);
        }

        // filter by sender (email address)
        if ($sender) {
            if (filter_var($sender, FILTER_VALIDATE_EMAIL) === false) {
                throw new InvalidArgumentException(
                    'Invalid email address supplied for sender parameter'
                );
            }

            $params['sender'] = $sender;
        }

        // filter by X-Header value
        if ($xHeaders) {
            if (!is_array($xHeaders)) {
                throw new InvalidArgumentException(
                    'Invalid X-Headers parameter supplied'
                );
            }

            $params = array_merge($params, $xHeaders);
        }

        return $params;
    }

    /**
     * Returns the total number of emails sent through the specified account
     * for the specified date range, optionally filtered by sender.
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @param  null|string          $sender    Optional sender email address
     * @param  null|array           $xHeaders  Optional array of X-Header values
     * @return integer
     */
    public function getSentCount($startDate = null, $endDate = null, $sender = null, $xHeaders = null)
    {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);

        $result = $this->getApiClient()->get('/reports/sent/count', $params);
        if ($result && $result->isOk()) {
            return (int)$result->data->count;
        }

        return false;
    }

    /**
     * Returns a list of all emails sent through the specified account for the
     * specified date range, optionally filtered by start/end date, sender
     * and X-Headers. Including a date range is recommended.
     *
     * Returns a maximum of 500 email addresses at a time. If the total sent
     * (as returned by getSentCount()) is more than 500, use the start index
     * parameter and multiple API calls to retrieve all the results.
     *
     * @param  integer              $startIndex Optional start index
     * @param  null|DateTime|string $startDate  Optional start date
     * @param  null|DateTime|string $endDate    Optional end date
     * @param  null|string          $sender     Optional sender email address
     * @param  null|array           $xHeaders   Optional array of X-Header values
     * @return array|false
     */
    public function getSent($startIndex = 0, $startDate = null, $endDate = null, $sender = null, $xHeaders = null)
    {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        $result = $this->getApiClient()->get('/reports/sent', $params);
        if ($result && $result->isOk()) {
            // TODO parse the result into objects?
            return $result->data;
        }

        return false;
    }

    /**
     * Returns total number of successfully delivered emails, optionally filtered
     * by date range, sender and X-Headers. Including a date range is recommended.
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @param  null|string          $sender    Optional sender email address
     * @param  null|array           $xHeaders  Optional array of X-Header values
     * @return integer
     */
    public function getDeliveredCount($startDate = null, $endDate = null, $sender = null, $xHeaders = null)
    {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);

        $result = $this->getApiClient()->get('/reports/delivered/count', $params);
        if ($result && $result->isOk()) {
            return (int)$result->data->count;
        }

        return false;
    }

    /**
     * Returns a list of all successfully delivered emails, optionally filtered
     * by date range, sender and X-Headers. Including a date range is recommended.
     *
     * Returns a maximum of 500 results at a time. If the total sent (as
     * returned by getDeliveredCount()) is more than 500, use the start index
     * parameter and multiple API calls to retrieve all the results.
     *
     * @param  integer              $startIndex Optional start index
     * @param  null|DateTime|string $startDate  Optional start date
     * @param  null|DateTime|string $endDate    Optional end date
     * @param  null|string          $sender     Optional sender email address
     * @param  null|array           $xHeaders   Optional array of X-Header values
     * @return array|false
     */
    public function getDelivered($startIndex = 0, $startDate = null, $endDate = null, $sender = null, $xHeaders = null)
    {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        $result = $this->getApiClient()->get('/reports/delivered', $params);
        if ($result && $result->isOk()) {
            // TODO parse the result into objects?
            return $result->data;
        }

        return false;
    }

    /**
     * Get the count of various bounce types, optionally filtered by date,
     * sender, and X-Header value.
     *
     * Returns a stdClass object with the following properties:
     *   count
     *   totalcount
     *   hardbouncecount
     *   softbouncecount
     *   prevhardbouncecount
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @param  null|string          $sender    Optional sender email address
     * @param  null|array           $xHeaders  Optional array of X-Header values
     * @return stdClass
     */
    public function getBouncesCount($startDate = null, $endDate = null, $sender = null, $xHeaders = null)
    {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);

        $result = $this->getApiClient()->get('/reports/bounces/count', $params);
        if ($result && $result->isOk()) {
            return $result->data;
        }

        return false;
    }

    /**
     * Returns a list of email bounces, optionally filtered by date range,
     * and/or various other parameters. Including a date range is recommended.
     *
     * Returns a maximum of 500 results at a time. If the total (as
     * returned by getBouncesCount()) is more than 500, use the start index
     * parameter and multiple API calls to retrieve all the results.
     *
     * @param  integer              $startIndex
     * @param  null|DateTime|string $startDate
     * @param  null|DateTime|string $endDate
     * @param  null|string          $sender
     * @param  null|string          $emailAddress
     * @param  null|string          $bounceType
     * @param  null|boolean         $noHeaders
     * @param  null|array           $xHeaders
     * @return stdClass
     */
    public function getBounces(
        $startIndex = 0,
        $startDate = null,
        $endDate = null,
        $sender = null,
        $emailAddress = null,
        $bounceType = null,
        $noHeaders = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        if ($emailAddress) {
            $params['emailaddress'] = $emailAddress;
        }

        if ($bounceType) {
            $validBounceTypes = array(
                'hard', 'soft', 'suppressed', 'previouslyhardbounced',
                'previouslycomplained'
            );
            if (!in_array($bounceType, $validBounceTypes)) {
                throw new InvalidArgumentException(
                    "Invalid value '" . htmlspecialchars($bounceType) . "'
                    specified for bounce type. Must be one of: " .
                    implode(', ', $validBounceTypes)
                );
            }
            $params['bouncetype'] = $bounceType;
        }

        if ($noHeaders !== null) {
            $params['noheaders'] = $noHeaders ? '1' : '0';
        }

        $result = $this->getApiClient()->get('/reports/bounces', $params);
        if ($result && $result->isOk()) {
            // TODO parse the result into objects?
            return $result->data;
        }

        return false;
    }

    /**
     * Get the count of spam complaints, optionally filtered by date, sender
     * and X-Header value.
     *
     * Returns a stdClass object with the following properties:
     *   count
     *   totalcount
     *   complaintcount
     *   prevcomplaintcount
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @param  null|string          $sender    Optional sender email address
     * @param  null|array           $xHeaders  Optional array of X-Header values
     * @return stdClass
     */
    public function getComplaintsCount(
        $startDate = null,
        $endDate = null,
        $sender = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);

        $result = $this->getApiClient()->get('/reports/complaints/count', $params);
        if ($result && $result->isOk()) {
            return $result->data;
        }

        return false;
    }

    /**
     * Returns a list of spam complaints, optionally filtered by date range,
     * sender and X-Headers. Including a date range is recommended.
     *
     * Returns a maximum of 500 results at a time. If the total sent (as
     * returned by getComplaintsCount()) is more than 500, use the start index
     * parameter and multiple API calls to retrieve all the results.
     *
     * @param  integer              $startIndex Optional start index
     * @param  null|DateTime|string $startDate  Optional start date
     * @param  null|DateTime|string $endDate    Optional end date
     * @param  null|string          $sender     Optional sender email address
     * @param  null|array           $xHeaders   Optional array of X-Header values
     * @return array|false
     */
    public function getComplaints(
        $startIndex = 0,
        $startDate = null,
        $endDate = null,
        $sender = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        $result = $this->getApiClient()->get('/reports/complaints', $params);
        if ($result && $result->isOk()) {
            // TODO parse the result into objects?
            return $result->data;
        }

        return false;
    }

    /**
     * Get the count of issues, optionally filtered by date.
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @return stdClass
     */
    public function getIssuesCount($startDate = null, $endDate = null)
    {
        $params = $this->buildBasicParams($startDate, $endDate);

        $result = $this->getApiClient()->get('/reports/issues/count', $params);
        if ($result && $result->isOk()) {
            return $result->data;
        }

        return false;
    }

    /**
     * Returns a list of issues, optionally filtered by date range. Including
     * a date range is recommended.
     *
     * Returns a maximum of 500 results at a time. If the total sent (as
     * returned by getIssuesCount()) is more than 500, use the start index
     * parameter and multiple API calls to retrieve all the results.
     *
     * @param  integer              $startIndex Optional start index
     * @param  null|DateTime|string $startDate  Optional start date
     * @param  null|DateTime|string $endDate    Optional end date
     * @param  null|string          $sender     Optional sender email address
     * @param  null|array           $xHeaders   Optional array of X-Header values
     * @return array|false
     */
    public function getIssues($startIndex = 0, $startDate = null, $endDate = null)
    {
        $params = $this->buildBasicParams($startDate, $endDate);
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        $result = $this->getApiClient()->get('/reports/issues', $params);
        if ($result && $result->isOk()) {
            // TODO parse the result into objects?
            return $result->data;
        }

        return false;
    }

    /**
     * Get the open count, optionally filtered by date range and/or various
     * other parameters. Including a date range is recommended.
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @return stdClass
     */
    public function getOpensCount(
        $startDate = null,
        $endDate = null,
        $sender = null,
        $domain = null,
        $recipient = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);

        if ($domain) {
            $params['domain'] = $domain;
        }

        if ($recipient) {
            $params['recipient'];
        }

        $result = $this->getApiClient()->get('/reports/opens/count', $params);
        if ($result && $result->isOk()) {
            return $result->data;
        }

        return false;
    }

    /**
     * Returns a list of opens, optionally filtered by date range and/or
     * various other parameters. Including a date range is recommended.
     *
     * Returns a maximum of 500 results at a time. If the total sent (as
     * returned by getOpensCount()) is more than 500, use the start index
     * parameter and multiple API calls to retrieve all the results.
     *
     * @param  integer              $startIndex Optional start index
     * @param  null|DateTime|string $startDate  Optional start date
     * @param  null|DateTime|string $endDate    Optional end date
     * @param  null|string          $sender     Optional sender email address
     * @param  null|string          $domain     Optional domain of the recipient
     * @param  null|string          $recipient  Optional recipient email address
     * @param  null|array           $xHeaders   Optional array of X-Header values
     * @return array|false
     */
    public function getOpens(
        $startIndex = 0,
        $startDate = null,
        $endDate = null,
        $sender = null,
        $domain = null,
        $recipient = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate);
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        if ($domain) {
            $params['domain'] = $domain;
        }

        if ($recipient) {
            $params['recipient'] = $recipient;
        }

        $result = $this->getApiClient()->get('/reports/opens', $params);
        if ($result && $result->isOk()) {
            // TODO parse the result into objects?
            return $result->data;
        }

        return false;
    }

    /**
     * Get the unique open count, optionally filtered by date range and/or
     * various other parameters. Including a date range is recommended.
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @return stdClass
     */
    public function getUniqueOpensCount(
        $startDate = null,
        $endDate = null,
        $sender = null,
        $domain = null,
        $recipient = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);

        if ($domain) {
            $params['domain'] = $domain;
        }

        if ($recipient) {
            $params['recipient'] = $recipient;
        }

        $result = $this->getApiClient()->get('/reports/opens/count/unique', $params);
        if ($result && $result->isOk()) {
            return $result->data;
        }

        return false;
    }

    /**
     * Returns a list of unique opens, optionally filtered by date range
     * and/or various other parameters. Including a date range is recommended.
     *
     * Returns a maximum of 500 results at a time. If the total sent (as
     * returned by getOpensCount()) is more than 500, use the start index
     * parameter and multiple API calls to retrieve all the results.
     *
     * @param  integer              $startIndex Optional start index
     * @param  null|DateTime|string $startDate  Optional start date
     * @param  null|DateTime|string $endDate    Optional end date
     * @param  null|string          $sender     Optional sender email address
     * @param  null|string          $domain     Optional domain of the recipient
     * @param  null|string          $recipient  Optional recipient email address
     * @param  null|array           $xHeaders   Optional array of X-Header values
     * @return array|false
     */
    public function getUniqueOpens(
        $startIndex = 0,
        $startDate = null,
        $endDate = null,
        $sender = null,
        $domain = null,
        $recipient = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate);
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        if ($domain) {
            $params['domain'] = $domain;
        }

        if ($recipient) {
            $params['recipient'] = $recipient;
        }

        $result = $this->getApiClient()->get('/reports/opens/unique', $params);
        if ($result && $result->isOk()) {
            // TODO parse the result into objects?
            return $result->data;
        }

        return false;
    }

    /**
     * Get the click count, optionally filtered by date range and/or various
     * other parameters. Including a date range is recommended.
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @return stdClass
     */
    public function getClicksCount(
        $startDate = null,
        $endDate = null,
        $sender = null,
        $domain = null,
        $recipient = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);

        if ($domain) {
            $params['domain'] = $domain;
        }

        if ($recipient) {
            $params['recipient'];
        }

        $result = $this->getApiClient()->get('/reports/clicks/count', $params);
        if ($result && $result->isOk()) {
            return $result->data;
        }

        return false;
    }

    /**
     * Returns a list of clicks, optionally filtered by date range and/or
     * various other parameters. Including a date range is recommended.
     *
     * Returns a maximum of 500 results at a time. If the total sent (as
     * returned by getOpensCount()) is more than 500, use the start index
     * parameter and multiple API calls to retrieve all the results.
     *
     * @param  integer              $startIndex Optional start index
     * @param  null|DateTime|string $startDate  Optional start date
     * @param  null|DateTime|string $endDate    Optional end date
     * @param  null|string          $sender     Optional sender email address
     * @param  null|string          $domain     Optional domain of the recipient
     * @param  null|string          $recipient  Optional recipient email address
     * @param  null|array           $xHeaders   Optional array of X-Header values
     * @return array|false
     */
    public function getClicks(
        $startIndex = 0,
        $startDate = null,
        $endDate = null,
        $sender = null,
        $domain = null,
        $recipient = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate);
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        if ($domain) {
            $params['domain'] = $domain;
        }

        if ($recipient) {
            $params['recipient'] = $recipient;
        }

        $result = $this->getApiClient()->get('/reports/clicks', $params);
        if ($result && $result->isOk()) {
            // TODO parse the result into objects?
            return $result->data;
        }

        return false;
    }

    /**
     * Get the unique click count, optionally filtered by date range and/or
     * various other parameters. Including a date range is recommended.
     *
     * @param  null|DateTime|string $startDate Optional start date
     * @param  null|DateTime|string $endDate   Optional end date
     * @return stdClass
     */
    public function getUniqueClicksCount(
        $startDate = null,
        $endDate = null,
        $sender = null,
        $domain = null,
        $recipient = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate, $sender, $xHeaders);

        if ($domain) {
            $params['domain'] = $domain;
        }

        if ($recipient) {
            $params['recipient'] = $recipient;
        }

        $result = $this->getApiClient()->get('/reports/clicks/count/unique', $params);
        if ($result && $result->isOk()) {
            return $result->data;
        }

        return false;
    }

    /**
     * Returns a list of unique clicks, optionally filtered by date range
     * and/or various other parameters. Including a date range is recommended.
     *
     * Returns a maximum of 500 results at a time. If the total sent (as
     * returned by getUniqueClicksCount()) is more than 500, use the start index
     * parameter and multiple API calls to retrieve all the results.
     *
     * @param  integer              $startIndex Optional start index
     * @param  null|DateTime|string $startDate  Optional start date
     * @param  null|DateTime|string $endDate    Optional end date
     * @param  null|string          $sender     Optional sender email address
     * @param  null|string          $domain     Optional domain of the recipient
     * @param  null|string          $recipient  Optional recipient email address
     * @param  null|array           $xHeaders   Optional array of X-Header values
     * @return array|false
     */
    public function getUniqueClicks(
        $startIndex = 0,
        $startDate = null,
        $endDate = null,
        $sender = null,
        $domain = null,
        $recipient = null,
        $xHeaders = null
    ) {
        $params = $this->buildBasicParams($startDate, $endDate);
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        if ($domain) {
            $params['domain'] = $domain;
        }

        if ($recipient) {
            $params['recipient'] = $recipient;
        }

        $result = $this->getApiClient()->get('/reports/clicks/unique', $params);
        if ($result && $result->isOk()) {
            // TODO parse the result into objects?
            return $result->data;
        }

        return false;
    }
}
