<?php
	/**
    This file is part of WideImage.
		
    WideImage is free software; you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation; either version 2.1 of the License, or
    (at your option) any later version.
		
    WideImage is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Lesser General Public License for more details.
		
    You should have received a copy of the GNU Lesser General Public License
    along with WideImage; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
    * @package Tests
  **/
	
	include WI_LIB_PATH . 'Mapper/PNG.php';
	
	/**
	 * @package Tests
	 */
	class PNGMapperTest extends UnitTestCase
	{
		protected $mapper;
		
		function setup()
		{
			$this->mapper = WideImage_MapperFactory::selectMapper(null, 'png');
		}
		
		function teardown()
		{
			$this->mapper = null;
			
			if (file_exists(IMG_PATH . 'temp/test.png'))
				unlink(IMG_PATH . 'temp/test.png');
		}
		
		function testLoad()
		{
			$handle = $this->mapper->load(IMG_PATH . '100x100-color-hole.png');
			$this->assertTrue($handle);
			$this->assertTrue(is_resource($handle));
			$this->assertEqual(100, imagesx($handle));
			$this->assertEqual(100, imagesy($handle));
			imagedestroy($handle);
		}
		
		function testSaveToString()
		{
			$handle = imagecreatefrompng(IMG_PATH . '100x100-color-hole.png');
			ob_start();
			$this->mapper->save($handle);
			$string = ob_get_clean();
			$this->assertTrue(strlen($string) > 0);
			imagedestroy($handle);
			
			// string contains valid image data
			$handle = imagecreatefromstring($string);
			$this->assertTrue($handle);
			$this->assertTrue(is_resource($handle));
			imagedestroy($handle);
		}
		
		function testSaveToFile()
		{
			$handle = imagecreatefrompng(IMG_PATH . '100x100-color-hole.png');
			$this->mapper->save($handle, IMG_PATH . 'temp/test.png');
			$this->assertTrue(filesize(IMG_PATH . 'temp/test.png') > 0);
			imagedestroy($handle);
			
			// file is a valid image
			$handle = imagecreatefrompng(IMG_PATH . 'temp/test.png');
			$this->assertTrue($handle);
			$this->assertTrue(is_resource($handle));
			imagedestroy($handle);
		}
		
		function testSaveCompression()
		{
			$handle = $this->mapper->load(IMG_PATH . '100x100-rainbow.png');
			$file1 = IMG_PATH . 'temp/test-comp-0.png';
			$file2 = IMG_PATH . 'temp/test-comp-9.png';
			$this->mapper->save($handle, $file1, 0);
			$this->mapper->save($handle, $file2, 9);
			$this->assertTrue(filesize($file1) > filesize($file2));
			
			unlink($file1);
			unlink($file2);
		}
	}
?>