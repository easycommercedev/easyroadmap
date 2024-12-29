<?php

use PHPUnit\Framework\TestCase;
use EasyRoadmap\Controller\Front;

class FrontTest extends TestCase {

	public function test_hooks_added() {
		$front = new Front();

		// Check if 'wp_head' action is hooked to 'test' method
		$this->assertNotFalse( has_action( 'wp_head', [ $front, 'test' ] ) );
	}

	public function test_test_method_output() {
		$front = new Front();

		// Start output buffering
		ob_start();

		// Call the test method
		$front->test();

		// Get the output
		$output = ob_get_clean();

		// Assert the output is as expected
		$this->assertEquals( 'THIS IS LOADED FROM THE Front CONTROLLER', $output );
	}
}