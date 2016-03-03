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
		protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

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

		function testAddBook()
		{
			//Arrange
			$title = "The General in his Labyrinth";
			$id = 1;
			$test_book = new Book($title, $id);
            $test_book->save();

			$name = "Gabriel Garcia Marquez";
            $id = 1;
            $test_author = new Author($name, $id);
			$test_author->save();

			//Act
			$test_author->addBook($test_book);

			//Assert
			$this->assertEquals($test_author->getBooks(), [$test_book]);
		}

		function testGetBooks()
        {
            //Arrange
			$name = "Gabriel Garcia Marquez";
            $id = 1;
            $test_author = new Author($name, $id);
			$test_author->save();

			$title = "The General in his Labyrinth";
			$id = 1;
			$test_book = new Book($title, $id);
            $test_book->save();

			$title2 = "No One Writes to the Colonel";
			$id2 = 2;
			$test_book2 = new Book($title2, $id2);
            $test_book2->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            //Assert
            $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);
        }

		function testFindByAuthor()
        {
            //Arrange
			$name = "Gabriel Garcia Marquez";
            $id = 1;
            $test_author = new Author($name, $id);
			$test_author->save();

			$title = "The General in his Labyrinth";
			$id = 1;
			$test_book = new Book($title, $id);
            $test_book->save();

            //Act
            $result = Author::findByAuthor($test_author->getName());

            //Assert
            $this->assertEquals($test_author, $result);
        }

		function testDeleteAll()
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
			Author::deleteAll();
			$result = Author::getAll();

			//Assert
			$this->assertEquals([], $result);
		}

	}

?>
