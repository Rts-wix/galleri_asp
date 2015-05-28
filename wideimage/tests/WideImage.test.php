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
	
	/**
	 * @package Tests
	 */
	class WideImageTest extends ImageTester
	{
		protected $_FILES;
		function setup()
		{
			$this->_FILES = $_FILES;
			$_FILES = array();
		}
		
		function teardown()
		{
			$_FILES = $this->_FILES;
			
			if (PHP_OS == 'WINNT')
			{
				chdir(IMG_PATH . "temp");
				
				foreach (new DirectoryIterator(IMG_PATH . "temp") as $file)
					if (!$file->isDot())
						if ($file->isDir())
							exec("rd /S /Q {$file->getFilename()}\n");
						else
							unlink($file->getFilename());
			}
			else
				exec("rm -rf " . IMG_PATH . 'temp/*');
		}
		
		function testLoadFromFile()
		{
			$img = WideImage::load(IMG_PATH . '100x100-red-transparent.gif');
			$this->assertTrue($img instanceof WideImage_PaletteImage);
			$this->assertTrue($img->isValid());
			$this->assertFalse($img->isTrueColor());
			$this->assertTrue(100, $img->getWidth());
			$this->assertTrue(100, $img->getHeight());
			
			$img = WideImage::load(IMG_PATH . '100x100-rainbow.png');
			$this->assertTrue($img instanceof WideImage_TrueColorImage);
			$this->assertTrue($img->isValid());
			$this->assertTrue($img->isTrueColor());
			$this->assertTrue(100, $img->getWidth());
			$this->assertTrue(100, $img->getHeight());
		}
		
		function testLoadFromString()
		{
			$img = WideImage::load(file_get_contents(IMG_PATH . '100x100-rainbow.png'));
			$this->assertTrue($img instanceof WideImage_TrueColorImage);
			$this->assertTrue($img->isValid());
			$this->assertTrue($img->isTrueColor());
			$this->assertTrue(100, $img->getWidth());
			$this->assertTrue(100, $img->getHeight());
		}
		
		function testLoadFromHandle()
		{
			$handle = imagecreatefrompng(IMG_PATH . '100x100-rainbow.png');
			$img = WideImage::loadFromHandle($handle);
			$this->assertTrue($img->isValid());
			$this->assertTrue($img->isTrueColor());
			$this->assertTrue($handle === $img->getHandle());
			$this->assertTrue(100, $img->getWidth());
			$this->assertTrue(100, $img->getHeight());
			unset($img);
			$this->assertFalse(WideImage::isValidImageHandle($handle));
		}
		
		function testLoadFromUpload()
		{
			copy(IMG_PATH . '100x100-rainbow.png', IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg');
			$_FILES = array(
				'testupl' => array(
					'name' => '100x100-rainbow.png',
					'type' => 'image/png',
					'size' => strlen(file_get_contents(IMG_PATH . '100x100-rainbow.png')),
					'tmp_name' => IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg',
					'error' => false,
				)
			);
			
			$img = WideImage::loadFromUpload('testupl');
			$this->assertTrue($img instanceof WideImage_Image);
			$this->assertTrue($img->isValid());
		}
		
		function testLoadFromMultipleUploads()
		{
			copy(IMG_PATH . '100x100-rainbow.png', IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg1');
			copy(IMG_PATH . '100x100-color-hole.gif', IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg2');
			$_FILES = array(
				'testupl' => array(
					'name' => array('100x100-rainbow.png', '100x100-color-hole.gif'),
					'type' => array('image/png', 'image/gif'),
					'size' => array(
							strlen(file_get_contents(IMG_PATH . '100x100-rainbow.png')), 
							strlen(file_get_contents(IMG_PATH . '100x100-color-hole.gif'))
						),
					'tmp_name' => array(
							IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg1',
							IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg2'
						),
					'error' => array(false, false),
				)
			);
			
			/*
			$img = WideImage::loadFromUpload('testupl');
			$this->assertTrue($img instanceof WideImage_Image);
			$this->assertTrue($img->isValid());
			*/
		}
		
		function testLoadMagical()
		{
			// from a handle
			$img = WideImage::load(imagecreatefrompng(IMG_PATH . '100x100-rainbow.png'));
			$this->assertTrue($img->isValid());
			
			// from binary string
			$img = WideImage::load(file_get_contents(IMG_PATH . '100x100-rainbow.png'));
			$this->assertTrue($img->isValid());
			
			// from a file
			$img = WideImage::load(IMG_PATH . '100x100-rainbow.png');
			$this->assertTrue($img->isValid());
			
			// from upload
			copy(IMG_PATH . 'fgnl.bmp', IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg');
			$_FILES = array(
				'testupl' => array(
					'name' => 'fgnl.bmp',
					'type' => 'image/bmp',
					'size' => strlen(file_get_contents(IMG_PATH . 'fgnl.bmp')),
					'tmp_name' => IMG_PATH . 'temp' . DIRECTORY_SEPARATOR . 'upltmpimg',
					'error' => false,
				)
			);
			$img = WideImage::load('testupl');
			$this->assertTrue($img->isValid());
		}
		
		function testLoadingByExtensionHint()
		{
			$img = WideImage::load(IMG_PATH . 'actually-a-png.jpg', 'png');
			$this->assertTrue($img->isValid());
		}
		
		function testLoadingByMimeTypeHint()
		{
			$img = WideImage::load(IMG_PATH . 'actually-a-png.jpg', 'image/pNG');
			$this->assertTrue($img->isValid());
		}
		
		function testExceptions()
		{
			try
			{
				@WideImage::loadFromFile(IMG_PATH . 'fakeimage.png');
				$this->fail("Exception expected");
			}
			catch (WideImage_InvalidImageSourceException $e)
			{
				$this->pass();
			}
			
			try
			{
				@WideImage::loadFromString('asdf');
				$this->fail("Exception expected");
			}
			catch (WideImage_InvalidImageSourceException $e)
			{
				$this->pass();
			}
			
			try
			{
				WideImage::loadFromHandle(0);
				$this->fail("Exception expected");
			}
			catch (WideImage_InvalidImageSourceException $e)
			{
				$this->pass();
			}
			
			try
			{
				WideImage::loadFromUpload('xyz');
				$this->fail("Exception expected");
			}
			catch (WideImage_InvalidImageSourceException $e)
			{
				$this->pass();
			}
		}
	}
?>