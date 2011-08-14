<?php

/**
 * Checks, if session.use_only_cookies is disabled.
 * 
 * @author Janos Pasztor <net@janoszen.hu>
 * @copyright 2011 János Pásztor All rights Reserved
 * @license https://github.com/janoszen/LAMPSecurityToolkit/wiki/License
 */
class UseOnlyCookiesTest extends SecurityTest {
	/**
	 * Get the short name of the tests.
	 * 
	 * @return string
	 */
	function getName() {
		return 'Use only cookies for SID';
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
		return 'Checks, if the session.use_only_cookies option is disabled.';
	}
	/**
	 * Returns the link to the details page of this issue.
	 * 
	 * @return string
	 */
	function getLink() {
		return 'https://github.com/janoszen/LAMPSecurityToolkit/wiki/Use-only-cookies-for-sid-test';
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
			if (!ini_get('session.use_only_cookies')) {
				$result->setCode(SecurityTestResult::WARNING);
				$result->setDescription('<p>The <a ' .
						'href="http://www.php.net/manual/en/session.configuration.php#ini.session.use-only-cookies">session.use_only_cookies</a> ' .
						'option is disabled. Enable it to prevent attacks by passing the SID ' .
						'in the URL in php.ini: <code>session.use_only_cookies = on</code></p>');
			} else {
				$result->setCode(SecurityTestResult::OK);
			}
		}
		return $result;
	}
}
