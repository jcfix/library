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

		function testFind()
        {
            //Arrange
			$name = "Jessica Fix";
			$id = 1;
			$test_patron = new Patron($name, $id);
			$test_patron->save();

            //Act
            $result = Patron::find($test_patron->getId());

            //Assert
            $this->assertEquals($test_patron, $result);
        }

		function testFindByName()
        {
            //Arrange
			$name = "Jessica Fix";
			$id = 1;
			$test_patron = new Patron($name, $id);
			$test_patron->save();

            //Act
            $result = Patron::findByName($test_patron->getName());

            //Assert
            $this->assertEquals($test_patron, $result);
        }

		function testAddPatronCopy()
		{
			//Arrange
			$name = "Jessica Fix";
			$id = 1;
			$test_patron = new Patron($name, $id);
			$test_patron->save();

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
			$test_patron->addPatronCopy($test_copy->getId());

			//Assert
			$this->assertEquals([$test_copy], $test_patron->getPatronCopies());
		}

		function testGetPatronCopies()
        {
            //Arrange
			$name = "Jessica Fix";
			$id = 1;
			$test_patron = new Patron($name, $id);
			$test_patron->save();

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
            $test_patron->addPatronCopy($test_copy->getId());
            $test_patron->addPatronCopy($test_copy2->getId());

            //Assert
            $this->assertEquals([$test_copy, $test_copy2], $test_patron->getPatronCopies());
        }


	}

?>
