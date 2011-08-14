<?php

/**
 * Checks, if session.use_trans_sid is enabled.
 * 
 * @author Janos Pasztor <net@janoszen.hu>
 * @copyright 2011 János Pásztor All rights Reserved
 * @license https://github.com/janoszen/LAMPSecurityToolkit/wiki/License
 */
class TransparentSIDTest extends SecurityTest {
	/**
	 * Get the short name of the tests.
	 * 
	 * @return string
	 */
	function getName() {
		return 'Transparent SID';
	}
	/**
	 * Return the category name of the test
	 * @return string
	 */
	function getCategory() {
		return 'PHP';
	}
	/**
	 * Returns the detailed description of this test.
	 * 
	 * @return string
	 */
	function getDescription() {
		return 'Checks, if the session.use_trans_sid option is enabled.';
	}
	/**
	 * Returns the link to the details page of this issue.
	 * 
	 * @return string
	 */
	function getLink() {
		return 'https://github.com/janoszen/LAMPSecurityToolkit/wiki/Transparent-sid-test';
	}
	/**
	 * Run the test and return the result.
	 * 
	 * @param array $params
	 * @return SecurityTestResult
	 */
	function run($params = array()) {
		$result = &new SecurityTestResult();
		
		if (!is_callable('ini_get')) {
			$result->setCode(SecurityTestResult::SKIPPED);
			$result->setDescription('ini_get() is required to run this test.');
		} else {
			if (ini_get('session.use_trans_sid')) {
				$result->setCode(SecurityTestResult::CRITICAL);
				$result->setDescription('<p>The <a ' .
						'href="http://www.php.net/manual/en/session.configuration.php#ini.session.use-trans-sid">session.use_trans_sid</a> ' .
						'option is enabled. This means, that remote sites can steal the session ID using the refererlogs and such! ' .
						'Unless you must support cookieless sessions, disable this feature in ' .
						'php.ini: <code>session.use_trans_sid = off</code></p>');
			} else {
				$result->setCode(SecurityTestResult::OK);
			}
		}
		return $result;
	}
}
