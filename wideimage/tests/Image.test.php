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
	class WideImage_Operation_CustomOp
	{
		static public $args = null;
		
		function execute()
		{
			self::$args = func_get_args();
			return self::$args[0]->copy();
		}
	}
	
	/**
	 * @package Tests
	 */
	class WideImage_Mapper_FOO
	{
		public static $calls = array();
		public static $handle = null;
		
		function load()
		{
			self::$calls['load'] = func_get_args();
			return self::$handle;
		}
		
		function save($image, $uri = null)
		{
			self::$calls['save'] = func_get_args();
			if ($uri == null)
				echo 'out';
		}
	}
	
	/**
	 * @package Tests
	 */
	class ImageForOutput extends WideImage_TrueColorImage
	{
		public $headers = array();
		
		function writeHeader($name, $data)
		{
			$this->headers[$name] = $data;
		}
	}
	
	/**
	 * @package Tests
	 */
	class TestableImage extends WideImage_TrueColorImage
	{
		public $headers = array();
		
		function __destruct()
		{
			
		}
		
		function writeHeader($name, $data)
		{
			$this->headers[$name] = $data;
		}
	}
	
	/**
	 * @package Tests
	 */
	class ImageTest extends ImageTester
	{
		function testFactories()
		{
			$this->assertTrue(WideImage::createTrueColorImage(100, 100) instanceof WideImage_TrueColorImage);
			$this->assertTrue(WideImage::createPaletteImage(100, 100) instanceof WideImage_PaletteImage);
		}
		
		function testDestructorUponUnset()
		{
			Mock::generatePartial('WideImage_TrueColorImage', 'MockImage', array('destroy'));
			
			$img = new MockImage();
			$img->expectOnce('destroy');
			unset($img);
			$img = null;
			
			for ($i = 0; $i++; $i < 1000);
		}
		
		function testDestructorUponNull()
		{
			$img = new MockImage();
			$img->expectOnce('destroy');
			$img = null;
			
			for ($i = 0; $i++; $i < 1000);
		}
		
		function testAutoDestruct()
		{
			$img = WideImage_TrueColorImage::create(10, 10);
			$handle = $img->getHandle();
			
			unset($img);
			
			$this->assertFalse(WideImage::isValidImageHandle($handle));
		}
		
		function testAutoDestructWithRelease()
		{
			$img = WideImage_TrueColorImage::create(10, 10);
			$handle = $img->getHandle();
			
			$img->releaseHandle();
			unset($img);
			
			$this->assertTrue(WideImage::isValidImageHandle($handle));
			imagedestroy($handle);
		}
		
		function testCustomOpMagic()
		{
			$img = WideImage_TrueColorImage::create(10, 10);
			$result = $img->customOp(123, 'abc');
			$this->assertTrue($result instanceof WideImage_Image);
			$this->assertIdentical(WideImage_Operation_CustomOp::$args[0], $img);
			$this->assertIdentical(WideImage_Operation_CustomOp::$args[1], 123);
			$this->assertIdentical(WideImage_Operation_CustomOp::$args[2], 'abc');
		}
		
		function testCustomOpCaseInsensitive()
		{
			$img = WideImage_TrueColorImage::create(10, 10);
			$result = $img->CUSTomOP(123, 'abc');
			$this->assertTrue($result instanceof WideImage_Image);
			$this->assertIdentical(WideImage_Operation_CustomOp::$args[0], $img);
			$this->assertIdentical(WideImage_Operation_CustomOp::$args[1], 123);
			$this->assertIdentical(WideImage_Operation_CustomOp::$args[2], 'abc');
		}
		
		function testInternalOpCaseInsensitive()
		{
			$img = WideImage_TrueColorImage::create(10, 10);
			$result = $img->AUTOcrop();
			$this->assertTrue($result instanceof WideImage_Image);
			$this->assertIdentical(WideImage_Operation_CustomOp::$args[0], $img);
			$this->assertIdentical(WideImage_Operation_CustomOp::$args[1], 123);
			$this->assertIdentical(WideImage_Operation_CustomOp::$args[2], 'abc');
		}
		
		function testMapperLoad()
		{
			WideImage_Mapper_FOO::$handle = imagecreate(10, 10);
			$filename = dirname(__FILE__) . '/images/image.foo';
			$img = WideImage::load($filename);
			$this->assertEqual(WideImage_Mapper_FOO::$calls['load'], array($filename));
			imagedestroy(WideImage_Mapper_FOO::$handle);
		}
		
		function testMapperSaveToFile()
		{
			$img = WideImage::load(IMG_PATH . 'fgnl.jpg');
			$img->saveToFile('test.foo', '123', 789);
			$this->assertEqual(WideImage_Mapper_FOO::$calls['save'], array($img->getHandle(), 'test.foo', '123', 789));
		}
		
		function testMapperAsString()
		{
			$img = WideImage::load(IMG_PATH . 'fgnl.jpg');
			$str = $img->asString('foo', '123', 789);
			$this->assertEqual(WideImage_Mapper_FOO::$calls['save'], array($img->getHandle(), null, '123', 789));
			$this->assertEqual('out', $str);
		}
		
		function testOutput()
		{
			$tmp = WideImage::load(IMG_PATH . 'fgnl.jpg');
			$img = new ImageForOutput($tmp->getHandle());
			
			ob_start();
			$img->output('png');
			$data = ob_get_clean();
			
			$this->assertEqual(array('Content-length' => strlen($data), 'Content-type' => 'image/png'), $img->headers);
		}
		
		function testCanvasInstance()
		{
			$img = WideImage::load(IMG_PATH . 'fgnl.jpg');
			$canvas1 = $img->getCanvas();
			$this->assertTrue($canvas1 instanceof WideImage_Canvas);
			$canvas2 = $img->getCanvas();
			$this->assertTrue($canvas1 === $canvas2);
		}
		
		function testSerializeTrueColorImage()
		{
			$img = WideImage::load(IMG_PATH . 'fgnl.jpg');
			$img2 = unserialize(serialize($img));
			$this->assertEqual(get_class($img2), get_class($img));
			$this->assertTrue($img2->isTrueColor());
			$this->assertTrue($img2->isValid());
			$this->assertFalse($img2->isTransparent());
			$this->assertEqual($img->getWidth(), $img2->getWidth());
			$this->assertEqual($img->getHeight(), $img2->getHeight());
		}
		
		function testSerializePaletteImage()
		{
			$img = WideImage::load(IMG_PATH . '100x100-color-hole.gif');
			$img2 = unserialize(serialize($img));
			$this->assertEqual(get_class($img2), get_class($img));
			$this->assertFalse($img2->isTrueColor());
			$this->assertTrue($img2->isValid());
			$this->assertTrue($img2->isTransparent());
			$this->assertEqual($img->getWidth(), $img2->getWidth());
			$this->assertEqual($img->getHeight(), $img2->getHeight());
		}
	}
