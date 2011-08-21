<?php

/**
 * This class represents a test result.
 * This code is PHP 4 compatible, therefore all OOP declarations are missing.
 * 
 * @author Janos Pasztor <net@janoszen.hu>
 * @copyright 2011 János Pásztor All rights Reserved
 * @license https://github.com/janoszen/LAMPSecurityToolkit/wiki/License
 */
class SecurityTestResult {
	/**
	 * This result has not been initialized.
	 */
	const UNKNOWN = -1;
	/**
	 * Shows, that everything is fine.
	 */
	const OK = 0;
	/**
	 * Shows a potential security problem.
	 */
	const WARNING = 1;
	/**
	 * Shows a verified and existing security problem, that can under no circumstances be a feature.
	 */
	const CRITICAL = 2;
	/**
	 * Shows, that the test was skipped for some reason. (e.g. the function to run this test is not available.)
	 */
	const SKIPPED = 3;
	/**
	 * Result code for this test.
	 * @var integer
	 */
	var $code = -1;
	/**
	 * Detailed description for this result
	 * @var string
	 */
	var $description = '';
	/**
	 * The test object this result belongs to.
	 * @var SecurityTest
	 */
	var $test = null;
	/**
	 * The log text.
	 * @var logMessage
	 */	
	var $logMessage = "";
	
	/**
	 * Set one of the following codes:
	 * 
	 * SecurityTestResult::OK
	 * SecurityTestResult::WARNING
	 * SecurityTestResult::CRITICAL
	 * SecurityTestResult::SKIPPED
	 * 
	 * @param integer $code
	 * @return SecurityTestResult
	 */
	function setCode($code) {
		switch ($code) {
			case SecurityTestResult::OK:
			case SecurityTestResult::WARNING:
			case SecurityTestResult::CRITICAL:
			case SecurityTestResult::SKIPPED:
				$this->code = $code;
		}
		return $this;
	}
	/**
	 * Returns one of the following codes:
	 * 
	 * SecurityTestResult::UNKNOWN
	 * SecurityTestResult::OK
	 * SecurityTestResult::WARNING
	 * SecurityTestResult::CRITICAL
	 * SecurityTestResult::SKIPPED
	 * 
	 * @return integer
	 */
	function getCode() {
		return $this->code;
	}
	/**
	 * Set the detailed description for this test result.
	 * 
	 * @param string $description
	 * @return SecurityTestResult
	 */
	function setDescription($description) {
		if (is_string($description)) {
			$this->description = $description;
		}
		return $this;
	}
	/**
	 * Get the detailed description for this tests result.
	 * 
	 * @return string
	 */
	function getDescription() {
		return $this->description;
	}
	/**
	 * Set the test this test result belongs to.
	 * @param SecurityTest $test 
	 * @return SecurityTestResult
	 */
	function setTest(&$test) {
		$this->test = $test;
		return $this;
	}
	/**
	 * Returns the test this result belongs to if applicable.
	 * @return SecurityTest
	 */
	function getTest() {
		return $this->test;
	}
	
	/**
	 * Returns the log Message this result belongs to if applicable.
	 * @return SecurityTest
	 */
	function getLogMessage() {
		return $this->logMessage;
	}	
	
	/**
	 * Set the log message this test result belongs to.
	 * @param logMessage $logMessage 
	 * @return SecuritylogMessageResult
	 */
	function setLogMessage(&$oSecurityTest, $status, $logText = "") {
		
			if ( $oSecurityTest instanceof  SecurityTest )
			{
				switch ($status)
				{
					case SecurityTestResult::SKIPPED:
						if (!$logText){
							$this->logMessage = $oSecurityTest->getname()."... Skipped.\n";
						}
						else {
							$this->logMessage = $oSecurityTest->getname()."... Skipped.\n".$logText;
						}
					case SecurityTestResult::CRITICAL:
						if (!$logText){
							$this->logMessage = $oSecurityTest->getname()."... Critical.\n";
						}
						else {
							$this->logMessage = $oSecurityTest->getname()."... Critical.\n".$logText;
						}
					case SecurityTestResult::OK:
						if (!$logText) {
							$this->logMessage = $oSecurityTest->getname()."... Ok.\n";
						}
						else {
							$this->logMessage = $oSecurityTest->getname()."... Ok.\n".$logText;
						}
					case SecurityTestResult::WARNING:
						if (!$logText) {
							$this->logMessage = $oSecurityTest->getname()."... Warning.\n";
						}
						else {
							$this->logMessage = $oSecurityTest->getname()."... Warning.\n".$logText;
						}
				}
			} 
		return $this;
	}
	
	
	/**
	 * Convert test result to JSON. Doesn't work perfectly without the built-in JSON module, but it does the job
	 * good enough.
	 * 
	 * @return string
	 */
	function toJSON() {
		$json = '';
		if (function_exists('json_encode')) {
			$json = json_encode(array(
				'code' => $this->getCode(),
				'description' => $this->getDescription(),
				'logMessage' => $this->getLogMessage()
			));
		} else {
			$json .= '{code:' . $this->getCode() . ',';
			$json .= 'description:"' . addslashes($this->getDescription()) . '"}';
			$json .= 'logMessage:"' . addslashes($this->getLogMessage()) . '"}';
		}
		return $json;
	}
}
