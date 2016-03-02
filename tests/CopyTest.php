<?php
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Copy.php";
	require_once "src/Book.php";

	$server = 'mysql:host=localhost;dbname=library_test';
	$user = 'root';
	$password = 'root';
	$DB = new PDO($server, $user, $password);

	class CopyTest extends PHPUnit_Framework_TestCase
	{
		function testGetId()
		{
			//Arrange
			$title = "Gardners Art Through the Ages";
			$id = 7;
			$test_book = new Book($title, $id);

			$id = 1;
			$book_id = $test_book->getId();
			$checkout = 0;
			$test_copy = new Copy($id, $book_id, $checkout);


			//Act
			$result = $test_copy->getId();

			//Assert
			$this->assertEquals(1, $result);
		}

		function testgetBookId()
		{
			//Arrange
			$title = "Gardners Art Through the Ages";
			$id = 7;
			$test_book = new Book($title, $id);
			
			$id = 1;
			$book_id = $test_book->getId();
			$checkout = 0;
			$test_copy = new Copy($id, $book_id, $checkout);


			//Act
			$result = $test_copy->getBookId();

			//Assert
			$this->assertEquals(7, $result);

		}
	}

?>
