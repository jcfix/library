<?php
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Author.php";
	require_once "src/Book.php";

	$server = 'mysql:host=localhost;dbname=library_test';
	$user = 'root';
	$password = 'root';
	$DB = new PDO($server, $user, $password);

	class AuthorTest extends PHPUnit_Framework_TestCase
	{
		// protected function tearDown()
        // {
        //     Author::deleteAll();
        //     Book::deleteAll();
        // }

		function testGetName()
        {
            //Arrange
            $name = "Junot Diaz";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $result = $test_author->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

		function testGetId()
        {
            //Arrange
            $name = "Junot Diaz";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $result = $test_author->getId();

			//Assert
			$this->assertEquals(1, $result);
		}

		function testSave()
		{
			//Arrange
			$name = "Junot Diaz";
            $id = 1;
            $test_author = new Author($name, $id);

			//Act
			$test_author->save();

			//Assert
			$result = Author::getAll();
			$this->assertEquals($test_author, $result[0]);
		}

		function testGetAll()
		{
			//Arrange
			$name = "Junot Diaz";
            $id = 1;
            $test_author = new Author($name, $id);
			$test_author->save();

			$name2 = "Gabriel Garcia Marquez";
			$id2 = 2;
			$test_author2 = new Author($name2, $id2);
			$test_author2->save();

			//Act
			$result = Author::getAll();

			//Assert
			$this->assertEquals([$test_author, $test_author2], $result);
		}

	}

?>
