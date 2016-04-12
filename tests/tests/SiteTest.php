<?php

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
require __DIR__ . "/../../vendor/autoload.php";


class SiteTest extends \PHPUnit_Framework_TestCase
{
	public function test_email() {
		$site = new Steampunked\Site();

		$site->setEmail("email");
		$this->assertEquals("email", $site->getEmail());


	}
	public function test_root() {
		$site = new Steampunked\Site();

		$site->setRoot("root");
		$this->assertEquals("root", $site->getRoot());

	}
	public function test_table() {
		$site = new Steampunked\Site();

		$site->setTablePrefix("prefix");
		$this->assertEquals("prefix", $site->getTablePrefix());

	}
	public function test_localize() {
		$site = new Steampunked\Site();
		$localize = require 'localize.inc.php';
		if(is_callable($localize)) {
			$localize($site);
		}
//		$this->assertEquals('test_', $site->getTablePrefix());
	}
}

/// @endcond
?>
