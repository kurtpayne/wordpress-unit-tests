<?php

/**
 * Test WP_WXR_*_Writer classes
 *
 * @group export
 * @ticket 22435
 */
class Test_WP_WXR_Writers extends WP_UnitTestCase {
	function test_xml_returner_returns_all_the_return_values() {
		$returner = new WP_WXR_Returner( $this->get_x_generator() );
		$this->assertEquals( 'xxx' , $returner->export() );
	}

	private function get_x_generator() {
		$methods = array( 'before_posts', 'posts', 'after_posts' );
		$xml_generator = $this->getMock( 'WP_WXR_XML_Generator', $methods, array( null ) );
		foreach( $methods as $method ) {
			$return = 'posts' == $method? array( 'x' ) : 'x';
			$xml_generator->expects( $this->once() )->method( $method )->with()->will( $this->returnValue( $return ) );
		}
		return $xml_generator;
	}
}

