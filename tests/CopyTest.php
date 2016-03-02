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

		protected function tearDown()
        {
          Book::deleteAll();
		  Copy::deleteAll();
        }

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

		function testGetCheckedOut()
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
			$result = $test_copy->getCheckedOut();

			//Assert
			$this->assertEquals(0, $result);
		}

		function testSave()
		{
			//Assert
			$title = "Gardners Art Through the Ages";
			$id = 7;
			$test_book = new Book($title, $id);

			$id = null;
			$book_id = $test_book->getId();
			$checkout = 0;
			$test_copy = new Copy($id, $book_id, $checkout);

			//Act
			$test_copy->save();

			//Assert
			$result = Copy::getAll();
			$this->assertEquals($test_copy, $result[0]);
		}

		function testGetAll()
		{
			//Arrange
			$title = "Gardners Art Through the Ages";
			$id = 7;
			$test_book = new Book($title, $id);

			$id = 1;
			$book_id = $test_book->getId();
			$checkout = 0;
			$test_copy = new Copy($id, $book_id, $checkout);
			$test_copy->save();

			$id2 = 2;
			$book_id = $test_book->getId();
			$checkout2 = 0;
			$test_copy2 = new Copy($id2, $book_id, $checkout2);
			$test_copy2->save();

			//Act
			$result = Copy::getAll();

			//Assert
			$this->assertEquals([$test_copy, $test_copy2], $result);
		}

		function testDeleteAll()
		{
			//Arrange
			$title = "Gardners Art Through the Ages";
			$id = 7;
			$test_book = new Book($title, $id);

			$id = 1;
			$book_id = $test_book->getId();
			$checkout = 0;
			$test_copy = new Copy($id, $book_id, $checkout);
			$test_copy->save();

			$id2 = 2;
			$book_id = $test_book->getId();
			$checkout2 = 0;
			$test_copy2 = new Copy($id2, $book_id, $checkout2);
			$test_copy2->save();

			//Act
			Copy::deleteAll();
			$result = Copy::getAll();

			//Assert
			$this->assertEquals([], $result);
		}

		function testDeleteACopy()
		{
			//Arrange
			$title = "Gardners Art Through the Ages";
			$id = 7;
			$test_book = new Book($title, $id);

			$id = 1;
			$book_id = $test_book->getId();
			$checkout = 0;
			$test_copy = new Copy($id, $book_id, $checkout);
			$test_copy->save();

			//Act
			$test_copy->deleteACopy();

			//Assert
			$this->assertEquals([], $test_book->getCopies());
		}

	}

?>
