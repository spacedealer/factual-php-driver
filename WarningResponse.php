<?php

/**
 * Identical to a FactualResponse but contains additional methods/properties for working with returned warnings
 *
 * @author Dirk Adler
 * @package Factual
 * @license Apache 2.0
 */
class WarningResponse extends FactualResponse
{
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
}