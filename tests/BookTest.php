<?php

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Book.php";
	require_once "src/Author.php";
	require_once "src/Copy.php";

	$server = 'mysql:host=localhost;dbname=library_test';
	$user = 'root';
	$password = 'root';
	$DB = new PDO($server, $user, $password);


	class BookTest extends PHPUnit_Framework_TestCase

	{
		protected function tearDown()
        {
          Book::deleteAll();
		  Author::deleteAll();
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

		function testAddCopy()
		{
			//Arrange
			$title = "Gardners Art Through the Ages";
			$id = 7;
			$test_book = new Book($title, $id);
			$test_book->save();

			$id = 1;
			$book_id = $test_book->getId();
			$checkout = 0;
			$due_date = "2016-03-02";
			$test_copy = new Copy($id, $book_id, $checkout, $due_date);
			$test_copy->save();

			//Act
			$test_book->addCopy($test_copy);

			//Assert
			$this->assertEquals([$test_copy], $test_book->getCopies());
		}

		function testGetCopies()
		{
			//Arrange
			$title = "Gardners Art Through the Ages";
			$id = 7;
			$test_book = new Book($title, $id);
			$test_book->save();

			$id = 1;
			$book_id = $test_book->getId();
			$checkout = 0;
			$due_date = "2016-03-02";
			$test_copy = new Copy($id, $book_id, $checkout, $due_date);
			$test_copy->save();

			$id2 = 2;
			$book_id = $test_book->getId();
			$checkout2 = 0;
			$due_date2 = "2016-03-01";
			$test_copy2 = new Copy($id2, $book_id, $checkout2, $due_date2);
			$test_copy2->save();

			//Act
			$test_book->addCopy($test_copy);
			$test_book->addCopy($test_copy2);

			//Assert
			$this->assertEquals([$test_copy, $test_copy2], $test_book->getCopies());
		}

	}

?>
