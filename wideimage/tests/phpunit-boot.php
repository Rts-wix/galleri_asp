<?php
	
	require dirname(__FILE__) . '/../lib/WideImage.php';
	
	define('TEST_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
	define('IMG_PATH', TEST_PATH . 'images' . DIRECTORY_SEPARATOR);
	
	class WideImage_TestCase extends PHPUnit_Framework_TestCase
	{
		protected function assertIdentical($a, $b)
		{
			$this->assertSame($a, $b);
		}
	}
	