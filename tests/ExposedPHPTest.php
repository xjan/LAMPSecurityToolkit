<?php

/**
 * Checks, if expose_php is set to on.
 * 
 * @author Janos Pasztor <net@janoszen.hu>
 * @copyright 2011 János Pásztor All rights Reserved
 * @license https://github.com/janoszen/LAMPSecurityToolkit/wiki/License
 */
class ExposedPHPTest extends SecurityTest {
	/**
	 * Get the short name of the tests.
	 * 
	 * @return string
	 */
	function getName() {
		return 'Exposed PHP';
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
		return 'Checks, if expose_php is disabled.';
	}
	/**
	 * Returns the link to the details page of this issue.
	 * 
	 * @return string
	 */
	function getLink() {
		return 'https://github.com/janoszen/LAMPSecurityToolkit/wiki/Exposed-php-test';
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
			if (ini_get('expose_php')) {
				$result->setCode(SecurityTestResult::CRITICAL);
				$result->setLogMessage(&$this, SecurityTestResult::CRITICAL);
				$result->setDescription('<p>The <a href="http://www.php.net/manual/en/ini.core.php#ini.expose-php">expose_php</a> ' .
						'option is set. This means, an <code>X-Powered-By</code> header is sent ' .
						'to the browser, which reveals the exact PHP version in use. To disable ' .
						'it, set the following option in php.ini: ' .
						'<code>expose_php = Off</code></p>');
			} else {
				$result->setCode(SecurityTestResult::OK);
				$result->setLogMessage(&$this, SecurityTestResult::OK);
			}
		}
        return $result;
	}
}