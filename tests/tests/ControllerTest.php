<?php

/** @file
 * @brief Empty unit testing template
 * @cond
 * @brief Unit tests for the class
 */

require __DIR__ . "/../../vendor/autoload.php";

class ControllerTest extends \PHPUnit_Framework_TestCase
{
	const SEED = 1422668587;

	//Test Controller construction
	public function test_construct() {
        $site = new \Steampunked\Site();
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($site, $steampunked, array());

		//Test if Controller class constructs without error
		$this->assertInstanceOf('\Steampunked\Controller', $controller);
		$this->assertEquals('game.php', $controller->getPage());
	}

	//Test post retrieval and redirects from posts
	public function test_actions() {
		//test addPiece post
        $site = new \Steampunked\Site();
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($site, $steampunked, array('add', "cap-e.png"));

		$this->assertInstanceOf('\Steampunked\Controller', $controller);
		$this->assertEquals('game.php', $controller->getPage());
		//next line would check if this piece is equal to piece that has been added to the grid
		//$this->assertEquals(original piece object, piece object in intended add position));

		//test rotatePiece post
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($site, $steampunked, array('rotate', "cap-e.png"));

		$this->assertInstanceOf('\Steampunked\Controller', $controller);
		//next line would check if posted piece object is not equal to the rotated pieces coordinates/values
		//$this->assertNotEquals(cap-e.png object, $controller->getPieceObject());
		$this->assertEquals('game.php', $controller->getPage());

		//test discardPiece post
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($site, $steampunked, array('discard', "cap-e.png"));

		$this->assertInstanceOf('\Steampunked\Controller', $controller);
		$this->assertEquals('game.php', $controller->getPage());

		//test giveUp post
		$steampunked = new \Steampunked\Steampunked(self::SEED);
		$controller = new \Steampunked\Controller($site, $steampunked, array('giveUp'));

		$this->assertInstanceOf('\Steampunked\Controller', $controller);
		//change to correct end game page.php
		$this->assertEquals('game.php', $controller->getPage());
	}
}

/// @endcond
?>
