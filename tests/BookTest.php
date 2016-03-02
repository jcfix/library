<?php

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Book.php";
	require_once "src/Author.php";

	$server = 'mysql:host=localhost;dbname=library_test';
	$user = 'root';
	$password = 'root';
	$DB = new PDO($server, $user, $password);


	class BookTest extends PHPUnit_Framework_TestCase

	{
		protected function tearDown()
        {
          Book::deleteAll();
		//   Author::deleteAll();
        }

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
			$this->assertEquals(1, $result);

		}

		function testSave()
        {
            //Arrange
			$title = "Slaughterhouse Five";
			$id = 1;
			$test_book = new Book($title, $id);

            //Act
            $test_book->save();

            //Assert
			$result = Book::getAll();
            $this->assertEquals($test_book, $result[0]);
        }

		function testGetAll()
		{
			//Arrange
			$title = "Slaughterhouse Five";
			$id = 1;
			$test_book = new Book($title, $id);
            $test_book->save();

			$title2 = "A Visit from the Goon Squad";
			$id2 = 2;
			$test_book2 = new Book($title2, $id2);
			$test_book2->save();

			//Act
			$result = Book::getAll();

			//Assert
			$this->assertEquals([$test_book, $test_book2], $result);
		}

		function testDeleteAll()
		{
			//Arrange
			$title = "Slaughterhouse Five";
			$id = 1;
			$test_book = new Book($title, $id);
            $test_book->save();

			$title2 = "A Visit from the Goon Squad";
			$id2 = 2;
			$test_book2 = new Book($title2, $id2);
			$test_book2->save();

			//Act
			Book::deleteAll();
			$result = Book::getAll();

			//Assert
			$this->assertEquals([], $result);
		}

		function testFind()
        {
            //Arrange
			$title = "Slaughterhouse Five";
			$id = 1;
			$test_book = new Book($title, $id);
            $test_book->save();

			$title2 = "A Visit from the Goon Squad";
			$id2 = 2;
			$test_book2 = new Book($title2, $id2);
			$test_book2->save();

            //Act
            $result = Book::find($test_book->getId());

            //Assert
            $this->assertEquals($test_book, $result);
        }

		function testFindByTitle()
        {
            //Arrange
			$title = "Slaughterhouse Five";
			$id = 1;
			$test_book = new Book($title, $id);
            $test_book->save();

			$title2 = "A Visit from the Goon Squad";
			$id2 = 2;
			$test_book2 = new Book($title2, $id2);
			$test_book2->save();

            //Act
            $result = Book::findByTitle($test_book->getTitle());

            //Assert
            $this->assertEquals($test_book, $result);
        }

		function testAddAuthor()
		{
			//Arrange
			$title = "Slaughterhouse Five";
			$id = 1;
			$test_book = new Book($title, $id);
            $test_book->save();

			$name = "Kurt Vonnegut";
            $id = 1;
            $test_author = new Author($name, $id);
			$test_author->save();

			//Act
			$test_book->addAuthor($test_author);

			//Assert
			$this->assertEquals([$test_author], $test_book->getAuthors());
		}

		function testGetAuthors()
        {
            //Arrange
			$title = "Gardners Art Through the Ages";
			$id = 1;
			$test_book = new Book($title, $id);
            $test_book->save();

            $name = "Richard Tansev";
            $id = 1;
            $test_author = new Author($name, $id);
            $test_author->save();

            $name2 = "Horst De La Croix";
            $id2 = 2;
            $test_author2 = new Author($name2, $id2);
            $test_author2->save();

            //Act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            //Assert
            $this->assertEquals([$test_author, $test_author2], $test_book->getAuthors());
        }

		function testDeleteBook()
		{
			//Arrange
			$title = "A Visit from the Goon Squad";
			$id = 1;
			$test_book = new Book($title, $id);
			$test_book->save();

			$name = "Jennifer Egan";
			$id = 2;
			$test_author = new Author($name, $id);
			$test_author->save();

			//Act
			$test_book->addAuthor($test_author);
			$test_book->deleteBook();

			//Assert
			$this->assertEquals([], $test_author->getBooks());
		}

	}

?>
