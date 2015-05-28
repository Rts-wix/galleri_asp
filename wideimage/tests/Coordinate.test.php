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
  **/
	
	/**
	 * @package Tests
	 */
	class CoordinateTest extends UnitTestCase
	{
		function testEvaluate()
		{
			$this->assertIdentical(400, WideImage_Coordinate::evaluate('+200%', 200));
			$this->assertIdentical(-1, WideImage_Coordinate::evaluate('-1', 200));
			$this->assertIdentical(10, WideImage_Coordinate::evaluate('+10', 200));
			$this->assertIdentical(40, WideImage_Coordinate::evaluate('+20%', 200));
			$this->assertIdentical(-11, WideImage_Coordinate::evaluate('-11.23', 200));
			$this->assertIdentical(-30, WideImage_Coordinate::evaluate('-15%', 200));
		}
		
		function testFix()
		{
			$this->assertIdentical(10, WideImage_Coordinate::fix('10%', 100));
			$this->assertIdentical(10, WideImage_Coordinate::fix('10', 100));
			
			$this->assertIdentical(-10, WideImage_Coordinate::fix('-10%', 100));
			$this->assertIdentical(-1, WideImage_Coordinate::fix('-1', 100));
			$this->assertIdentical(-50, WideImage_Coordinate::fix('-50%', 100));
			$this->assertIdentical(-100, WideImage_Coordinate::fix('-100%', 100));
			$this->assertIdentical(-1, WideImage_Coordinate::fix('-5%', 20));
			
			$this->assertIdentical(300, WideImage_Coordinate::fix('150.12%', 200));
			$this->assertIdentical(150, WideImage_Coordinate::fix('150', 200));
			
			$this->assertIdentical(100, WideImage_Coordinate::fix('100%-50%', 200));
			$this->assertIdentical(200, WideImage_Coordinate::fix('100%', 200));
			
			$this->assertIdentical(130, WideImage_Coordinate::fix('50%     -20', 300));
			$this->assertIdentical(12, WideImage_Coordinate::fix(' 12 - 0', 300));
			
			$this->assertIdentical(15, WideImage_Coordinate::fix('50%', 30));
			$this->assertIdentical(15, WideImage_Coordinate::fix('50%-0', 30));
			$this->assertIdentical(15, WideImage_Coordinate::fix('50%+0', 30));
			$this->assertIdentical(0, WideImage_Coordinate::fix(' -  50%  +   50%', 30));
			$this->assertIdentical(30, WideImage_Coordinate::fix(' 50%  + 49.6666%', 30));
		}
		
		function testAlign()
		{
			$this->assertIdentical(0, WideImage_Coordinate::fix('left', 300, 120));
			$this->assertIdentical(90, WideImage_Coordinate::fix('center', 300, 120));
			$this->assertIdentical(180, WideImage_Coordinate::fix('right', 300, 120));
			$this->assertIdentical(0, WideImage_Coordinate::fix('top', 300, 120));
			$this->assertIdentical(90, WideImage_Coordinate::fix('middle', 300, 120));
			$this->assertIdentical(180, WideImage_Coordinate::fix('bottom', 300, 120));
			
			$this->assertIdentical(200, WideImage_Coordinate::fix('bottom+20', 300, 120));
			$this->assertIdentical(178, WideImage_Coordinate::fix('-2 + right', 300, 120));
			$this->assertIdentical(90, WideImage_Coordinate::fix('right - center', 300, 120));
		}
		
		function testAlignWithoutSecondaryCoordinate()
		{
			$this->assertIdentical(0, WideImage_Coordinate::fix('left', 300));
			$this->assertIdentical(150, WideImage_Coordinate::fix('center', 300));
			$this->assertIdentical(300, WideImage_Coordinate::fix('right', 300));
			$this->assertIdentical(0, WideImage_Coordinate::fix('top', 300));
			$this->assertIdentical(150, WideImage_Coordinate::fix('middle', 300));
			$this->assertIdentical(300, WideImage_Coordinate::fix('bottom', 300));
			
			$this->assertIdentical(320, WideImage_Coordinate::fix('bottom+20', 300));
			$this->assertIdentical(280, WideImage_Coordinate::fix('-20 + right', 300));
			$this->assertIdentical(150, WideImage_Coordinate::fix('right - center', 300));
		}
	}
?>