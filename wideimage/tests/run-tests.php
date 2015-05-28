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
  	
	if ($_SERVER['argc'] > 1)
		$path_to_simpletest = $_SERVER['argv'][1];
	else
		$path_to_simpletest = 'simpletest';
	
	if ($_SERVER['argc'] > 2)
		$filter = $_SERVER['argv'][2];
	else
		$filter = null;
	
	if (defined('E_DEPRECATED'))
		error_reporting(E_ALL & ~E_DEPRECATED);
	else
		error_reporting(E_ALL);
	
	// change if necessary
	define('WI_LIB_PATH', realpath(dirname(__FILE__) . '/../lib') . DIRECTORY_SEPARATOR);
	
	require_once $path_to_simpletest . '/unit_tester.php';
	require_once $path_to_simpletest . '/mock_objects.php';
	require_once $path_to_simpletest . '/reporter.php';
	include 'test.env.php';
	
	function collect_tests($dir, $test, $filter)
	{
		$di = new DirectoryIterator($dir);
		foreach ($di as $file)
			if ($file->isDir() && (substr($file->getFilename(), 0, 1) != '.'))
				collect_tests($dir . '/' . $file->getFilename(), $test, $filter);
			elseif (preg_match('/\.test\.php$/', $file->getFilename()))
			{
				if (($filter && preg_match("~{$filter}~", $file->getFilename())) || !$filter)
				{
					echo "Found test: {$dir}/{$file->getFilename()}\n";
					$test->addTestFile($dir . '/' . $file->getFilename());
				}
			}
	}
	
	$test = new GroupTest('WideImage tests');
	collect_tests(dirname(__FILE__), $test, $filter);
	$reporter = new TextReporter();
	$test->run($reporter);
	
	if ($reporter->getFailCount() == 0 && $reporter->getExceptionCount() == 0)
		exit(0);
	else
		exit(1);
	
