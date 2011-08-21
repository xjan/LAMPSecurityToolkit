<?php

/**
 * Checks, if session.cookie_httponly is disabled.
 * 
 * @author Janos Pasztor <net@janoszen.hu>
 * @copyright 2011 János Pásztor All rights Reserved
 * @license https://github.com/janoszen/LAMPSecurityToolkit/wiki/License
 */
class HTTPOnlySIDCookieTest extends SecurityTest {
	/**
	 * Get the short name of the tests.
	 * 
	 * @return string
	 */
	function getName() {
		return 'HTTPonly session cookies';
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
		return 'Checks, if the session.cookie_httponly option is enabled.';
	}
	/**
	 * Returns the link to the details page of this issue.
	 * 
	 * @return string
	 */
	function getLink() {
		return 'https://github.com/janoszen/LAMPSecurityToolkit/wiki/Http-only-session-cookie-test';
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
			$result->setLogMessage(&$this, SecurityTestResult::SKIPPED);
		} else {
			if (!ini_get('session.cookie_httponly')) {
				$result->setCode(SecurityTestResult::WARNING);
				$result->setLogMessage(&$this, SecurityTestResult::WARNING);
				$result->setDescription('<p>The <a ' .
						'href="http://www.php.net/manual/en/session.configuration.php#ini.session.cookie-httponly">session.cookie_httponly</a> ' .
						'option is disabled. This means, that JavaScript code can access the ' .
						'session ID. In case of an XSS the session ID can be stolen. To ' .
						'prevent this, adjust the following option in php.ini: ' .
						'<code>session.cookie_httponly = on</code></p>');
			} else {
				$result->setCode(SecurityTestResult::OK);
				$result->setLogMessage(&$this, SecurityTestResult::OK);
			}
		}
		return $result;
	}
}
