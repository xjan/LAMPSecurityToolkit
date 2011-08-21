<?php

/**
 * Checks, if the max_file_uploads option is set to something sensible
 *
 * @author Janos Pasztor <net@janoszen.hu>
 * @copyright 2011 János Pásztor All rights Reserved
 * @license https://github.com/janoszen/LAMPSecurityToolkit/wiki/License
 */
class MaxFileUploadsTest extends SecurityTest {
	/**
	 * Get the short name of the tests.
	 *
	 * @return string
	 */
	function getName() {
		return 'Maximized number of file uploads';
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
		return 'Checks, if the max_file_uploads option is set to something sensible.';
	}
	/**
	 * Returns the link to the details page of this issue.
	 *
	 * @return string
	 */
	function getLink() {
		return 'https://github.com/janoszen/LAMPSecurityToolkit/wiki/Maximized-number-of-file-uploads-test';
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
			$result->setLogMessage(&$this, SecurityTestResult::SKIPPED);
			$result->setDescription('ini_get() is required to run this test.');
		} else if (version_compare(PHP_VERSION, '5.2.12', '<')) {
			$result->setCode(SecurityTestResult::SKIPPED);
			$result->setDescription('<p>This option is only available from PHP version 5.2.12.</p>');
			$result->setLogMessage(&$this, SecurityTestResult::SKIPPED, $this->getDescription());
		} else {
			if (!ini_get('max_file_uploads') || (ini_get('max_file_uploads') > 100)) {
				$result->setCode(SecurityTestResult::WARNING);
				$result->setLogMessage(&$this, SecurityTestResult::WARNING);
				$result->setDescription('<p>The <a ' .
						'href="http://www.php.net/manual/en/ini.core.php#ini.max-file-uploads">max_file_uploads</a> ' .
						'option is not set to a sensible value. This allows a remote attacker ' .
						'to conduct a remote DoS by uploading a lot of files. To set this, ' .
						'configure the following option in php.ini: ' .
						'<code>max_file_uploads = 100</code></p>');
			} else {
				$result->setCode(SecurityTestResult::OK);
				$result->setLogMessage(&$this, SecurityTestResult::OK);
			}
		}
		return $result;
	}
}
