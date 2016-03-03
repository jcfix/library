<?php
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Author.php";
	require_once "src/Book.php";
	require_once "src/Copy.php";
	require_once "src/Patron.php";

	$server = 'mysql:host=localhost;dbname=library_test';
	$user = 'root';
	$password = 'root';
	$DB = new PDO($server, $user, $password);

	class PatronTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
        {
            Patron::deleteAll();
            Book::deleteAll();
			Copy::deleteAll();
        }

		function testGetName()
        {
            //Arrange
            $name = "Jessica Fix";
            $id = 1;
            $test_patron = new Patron($name, $id);

            //Act
            $result = $test_patron->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

		function testGetId()
        {
            //Arrange
			$name = "Jessica Fix";
            $id = 1;
            $test_patron = new Patron($name, $id);

            //Act
            $result = $test_patron->getId();

			//Assert
			$this->assertEquals(1, $result);
		}

		function testSave()
		{
			//Arrange
			$name = "Jessica Fix";
            $id = 1;
            $test_patron = new Patron($name, $id);

			//Act
			$test_patron->save();

			//Assert
			$result = Patron::getAll();
			$this->assertEquals($test_patron, $result[0]);
		}

		function testGetAll()
		{
			//Arrange
			$name = "Jessica Fix";
            $id = 1;
            $test_patron = new Patron($name, $id);
			$test_patron->save();

			$name2 = "Ryan Brown";
			$id2 = 2;
			$test_patron2 = new Patron($name2, $id2);
			$test_patron2->save();

			//Act
			$result = Patron::getAll();

			//Assert
			$this->assertEquals([$test_patron, $test_patron2], $result);
		}

		function testDeleteAll()
		{
			//Arrange
			$name = "Jessica Fix";
            $id = 1;
            $test_patron = new Patron($name, $id);
			$test_patron->save();

			$name2 = "Ryan Brown";
			$id2 = 2;
			$test_patron2 = new Patron($name2, $id2);
			$test_patron2->save();

			//Act
			Patron::deleteAll();
			$result = Patron::getAll();

			//Assert
			$this->assertEquals([], $result);
		}
		//
		// function testAddBook()
		// {
		// 	//Arrange
		// 	$title = "The General in his Labyrinth";
		// 	$id = 1;
		// 	$test_book = new Book($title, $id);
        //     $test_book->save();
		//
		// 	$name = "Gabriel Garcia Marquez";
        //     $id = 1;
        //     $test_author = new Patron($name, $id);
		// 	$test_author->save();
		//
		// 	//Act
		// 	$test_author->addBook($test_book);
		//
		// 	//Assert
		// 	$this->assertEquals($test_author->getBooks(), [$test_book]);
		// }
		//
		// function testGetBooks()
        // {
        //     //Arrange
		// 	$name = "Gabriel Garcia Marquez";
        //     $id = 1;
        //     $test_author = new Patron($name, $id);
		// 	$test_author->save();
		//
		// 	$title = "The General in his Labyrinth";
		// 	$id = 1;
		// 	$test_book = new Book($title, $id);
        //     $test_book->save();
		//
		// 	$title2 = "No One Writes to the Colonel";
		// 	$id2 = 2;
		// 	$test_book2 = new Book($title2, $id2);
        //     $test_book2->save();
		//
        //     //Act
        //     $test_author->addBook($test_book);
        //     $test_author->addBook($test_book2);
		//
        //     //Assert
        //     $this->assertEquals($test_author->getBooks(), [$test_book, $test_book2]);
        // }
		//
		// function testFindByPatron()
        // {
        //     //Arrange
		// 	$name = "Gabriel Garcia Marquez";
        //     $id = 1;
        //     $test_author = new Patron($name, $id);
		// 	$test_author->save();
		//
		// 	$title = "The General in his Labyrinth";
		// 	$id = 1;
		// 	$test_book = new Book($title, $id);
        //     $test_book->save();
		//
        //     //Act
        //     $result = Patron::findByPatron($test_author->getName());
		//
        //     //Assert
        //     $this->assertEquals($test_author, $result);
        // }

	}

?>
