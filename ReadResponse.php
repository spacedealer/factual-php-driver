<?php

/**
 * Identical to a FactualResponse but contains additional methods/properties for working with returned data
 *
 * @author Tyler
 * @author Dirk Adler
 * @package Factual
 * @license Apache 2.0
 */
class ReadResponse extends FactualResponse
{
    /**
     * @var null|int
     */
    protected $totalRowCount = null;
    /**
     * @var null|int
     */
    protected $includedRows = null;
    /**
     * @var string|null
     */
    protected $message = null;
    /**
     * @var string|null
     */
    protected $errorType = null;
    /**
     * @var string|null
     */
    protected $deprecatedId = null;
    /**
     * @var string|null
     */
    protected $currentId = null;

    /**
     * Parses JSON as array and assigns object values
     *
     * @param string $json JSON returned from API
     * @return array structured JSON
     */
    protected function parseJSON($json)
    {
        $rootJSON = parent::parseJSON($json);
        //assign total row count
        if (isset($rootJSON['response']['total_row_count'])) {
            $this->totalRowCount = $rootJSON['response']['total_row_count'];
        }
        if (isset($rootJSON['response']['included_rows'])) {
            $this->includedRows = $rootJSON['response']['included_rows'];
        }
        // assign data
        if (isset($rootJSON['response']['data'])) {
            $this->assignData($rootJSON['response']['data']);
        }
        // assign warning context
        if (isset($rootJSON['response']['error_type'])) {
            $this->errorType = $rootJSON['response']['error_type'];
        }
        if (isset($rootJSON['response']['message'])) {
            $this->message = $rootJSON['response']['message'];
        }
        if (isset($rootJSON['response']['deprecated_id'])) {
            $this->deprecatedId = $rootJSON['response']['deprecated_id'];
        }
        if (isset($rootJSON['response']['current_id'])) {
            $this->currentId = $rootJSON['response']['current_id'];
        }
        return $rootJSON;
    }

    /**
     * Assigns data element to object
     *
     * @param array $data The data array from API response
     */
    protected function assignData($data)
    {
        if ($data) {
            //assign data to iterator
            foreach ($data as $index => $datum) {
                $this[$index] = $datum;
            }
        }
    }

    /**
     * Get the returned entities as an array
     *
     * @return array
     */
    public function getData()
    {
        return $this->getArrayCopy();
    }

    /**
     * Get the return entities as JSON
     *
     * @return string the main data returned by Factual.
     */
    public function getDataAsJSON()
    {
        return json_encode($this->getArrayCopy());
    }

    /**
     * Get total result count. Must be specifically requested via Query::includeRowCount()
     *
     * @return int|null
     */
    public function getTotalRowCount()
    {
        return $this->totalRowCount;
    }

    /**
     * Alias of getTotalRowCount()
     *
     * @return int|null
     */
    public function getRowCount()
    {
        return $this->getTotalRowCount();
    }

    /**
     * Get type of error
     *
     * @return string|null
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * Get descriptive error message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get deprecated factual id
     *
     * @return string|null
     */
    public function getDeprecatedId()
    {
        return $this->deprecatedId;
    }

    /**
     * Get current factual id in case of redirects.
     *
     * @return string|null
     */
    public function getCurrentId()
    {
        return $this->currentId;
    }

    /**
     * Get count of result rows returned in this response.
     *
     * @return int
     */
    public function getIncludedRowCount()
    {
        if (!$this->includedRows) {
            $this->includedRows = count($this);
        }
        return $this->includedRows;
    }
}