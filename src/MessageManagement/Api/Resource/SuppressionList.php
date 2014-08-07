<?php

namespace Dyn\MessageManagement\Api\Resource;

use DateTime;
use Dyn\MessageManagement\Suppression;

class SuppressionList extends AbstractResource
{
    /**
     * Returns the number of email addresses in the suppression list,
     * optionally within the date range specified.
     *
     * @param  DateTime|string $startDate
     * @param  DateTime|string $endDate
     * @return integer
     */
    public function getCount($startDate = null, $endDate = null)
    {
        $params = array();

        if ($startDate) {
            if (!($startDate instanceof DateTime)) {
                $startDate = new DateTime($startDate);
            }

            $params['startdate'] = $startDate->format(DateTime::ISO8601);
        }

        if ($endDate) {
            if (!($endDate instanceof DateTime)) {
                $endDate = new DateTime($endDate);
            }

            $params['enddate'] = $endDate->format(DateTime::ISO8601);
        }

        $result = $this->getApiClient()->get('/suppressions/count', $params);
        if ($result && $result->isOk()) {
            return (int)$result->data->count;
        }

        return false;
    }

    /**
     * Returns up to 200 entries from the suppression list.
     *
     * @param  integer          $startIndex Optional start index
     * @param  DateTime|string  $startDate  Optional start datetime range
     * @param  DateTime|string  $endDate    Optional end datetime range
     * @return array|false
     */
    public function get($startIndex = 0, $startDate = null, $endDate = null)
    {
        $params = array();
        if ($startIndex) {
            $params['startindex'] = $startIndex;
        }

        if ($startDate) {
            if (!($startDate instanceof DateTime)) {
                $startDate = new DateTime($startDate);
            }

            $params['startdate'] = $startDate->format(DateTime::ISO8601);
        }

        if ($endDate) {
            if (!($endDate instanceof DateTime)) {
                $endDate = new DateTime($endDate);
            }

            $params['enddate'] = $endDate->format(DateTime::ISO8601);
        }

        $result = $this->getApiClient()->get('/suppressions', $params);
        if ($result && $result->isOk()) {
            $suppressions = array();

            foreach ($result->data->suppressions as $suppressionData) {
                $suppression = Suppression::fromJson($suppressionData);
                $suppressions[] = $suppression;
            }

            return $suppressions;
        }

        return false;
    }

    /**
     * Extracts the email address from the supplied parameter, which is either
     * a Suppression object or string. Returns the email address or false if
     * the parameter was invalid.
     *
     * @param  mixed $suppression
     * @return string|false
     */
    protected function extractEmailFromSuppressionListParam($suppression)
    {
        if ($suppression instanceof Suppression) {
            return $suppression->getEmailAddress();
        } elseif (is_string($suppression)) {
            return filter_var($suppression, FILTER_VALIDATE_EMAIL);
        }

        return false;
    }

    /**
     * Adds one or more email addresses to the suppression list for this
     * account.
     *
     * @param  Suppression|string|array $suppression Either a Suppression
     * instance, an email address (string), or an array of either
     * @return boolean
     */
    public function add($suppression)
    {
        $params = array();

        if (is_array($suppression)) {
            $emailAddresses = array();
            foreach ($suppression as $suppressionRow) {
                $emailAddress = $this->extractEmailFromSuppressionListParam(
                    $suppressionRow
                );

                if ($emailAddress === false) {
                    throw new InvalidArgumentException(
                        "Invalid parameter '" .
                        htmlspecialchars($suppressionRow) . "' supplied as
                        email address for suppression list"
                    );
                } else {
                    $emailAddresses[] = $emailAddress;
                }
            }

            $params['emailaddress'] = implode(',', $emailAddresses);

        } else {
            $emailAddress = $this->extractEmailFromSuppressionListParam(
                $suppression
            );

            if ($emailAddress === false) {
                throw new InvalidArgumentException(
                    "Invalid parameter '" . htmlspecialchars($suppressionRow) .
                    "' supplied as email address for suppression list"
                );
            }

            $params['emailaddress'] = $emailAddress;
        }

        if (empty($params['emailaddress'])) {
            throw new InvalidArgumentException(
                'No valid email addresses were supplied to add to the
                suppression list'
            );
        }

        $result = $this->getApiClient()->post('/suppressions', $params);
        if ($result && $result->isOk()) {
            return true;
        }

        return false;
    }

    /**
     * Removes one or more email addresses from the suppression list for this
     * account. Note that this does not unbounce/uncomplain the recipient(s),
     * it just allows you to send to them again.
     *
     * @param  Suppression|string|array $suppression Either a Suppression
     * instance, an email address (string), or an array of either
     * @return boolean
     */
    public function remove($suppression)
    {
        $params = array();

        if (is_array($suppression)) {
            $emailAddresses = array();
            foreach ($suppression as $suppressionRow) {
                $emailAddress = $this->extractEmailFromSuppressionListParam(
                    $suppressionRow
                );

                if ($emailAddress === false) {
                    throw new InvalidArgumentException(
                        "Invalid parameter '" .
                        htmlspecialchars($suppressionRow) . "' supplied as
                        email address for suppression list"
                    );
                } else {
                    $emailAddresses[] = $emailAddress;
                }
            }

            $params['emailaddress'] = implode(',', $emailAddresses);

        } else {
            $emailAddress = $this->extractEmailFromSuppressionListParam(
                $suppression
            );

            if ($emailAddress === false) {
                throw new InvalidArgumentException(
                    "Invalid parameter '" . htmlspecialchars($suppressionRow) .
                    "' supplied as email address for suppression list"
                );
            }

            $params['emailaddress'] = $emailAddress;
        }

        if (empty($params['emailaddress'])) {
            throw new InvalidArgumentException(
                'No valid email addresses were supplied to remove from the
                suppression list'
            );
        }

        $result = $this->getApiClient()->post('/suppressions/activate', $params);
        if ($result && $result->isOk()) {
            return true;
        }

        return false;
    }
}
