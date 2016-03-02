<?php

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Book.php";
	// require_once "src/Author.php";

	$server = 'mysql:host=localhost;dbsubject=library_test';
	$usersubject = 'root';
	$password = 'root';
	$DB = new PDO($server, $usersubject, $password);


	class BookTest extends PHPUnit_Framework_TestCase

	{

		function testGetTitle()
		{
			//Arrange
			$title = "Slaughterhouse Five";
			$test_book = new Book($title);

			//Act
			$result = $test_book->getTitle();

			//Assert
			$this->assertEquals($title, $result);

		}

		function testGetId()
		{
			//Arrange
			$title = "Slaughterhouse Five";
			$id = 1;
			$test_book = new Book($title, $id);

			//Act
			$result = $test_book->getId();

			//Assert
			$this->assertEquals($id, $result);

		}

	}

?>
