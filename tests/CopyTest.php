<?php
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Copy.php";

	$server = 'mysql:host=localhost;dbname=library_test';
	$user = 'root';
	$password = 'root';
	$DB = new PDO($server, $user, $password);

	class CopyTest extends PHPUnit_Framework_TestCase
	{
		function testGetId()
		{
			//Arrange
			$id = 1;
			$book_id = 7;
			$checkout = 0;
			$test_copy = new Copy($id, $book_id, $checkout);

			//Act
			$result = $test_copy->getId();

			//Assert
			$this->assertEquals(1, $result);
		}

		// function getBookId()
		// {
		// 	//Arrange
		// 	$title = "Gardners Art Through the Ages";
		// 	$id = 1;
		// 	$test_book = new Book($title, $id);
        //     $test_book->save();
		//
        //     $name = "Richard Tansev";
        //     $id = 1;
        //     $test_author = new Author($name, $id);
        //     $test_author->save();
		//
		//
		// 	//Act
		// 	$result = $test_book->getId();
		// }
	}

?>
