<?php
	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Author.php";
	// require_once "src/Book.php";

	$server = 'mysql:host=localhost;dbsubject=library_test';
	$usersubject = 'root';
	$password = 'root';
	$DB = new PDO($server, $usersubject, $password);

	class AuthorTest extends PHPUnit_Framework_TestCase
	{
		// protected function tearDown()
        // {
        //     Author::deleteAll();
        //     // Course::deleteAll();
        // }

		function testGetName()
        {
            //Arrange
            $name = "Harry Houdini";
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
            $name = "Harry Houdini";
            $id = 1;
            $test_author = new Author($name, $id);

            //Act
            $result = $test_author->getId();

			//Assert
			$this->assertEquals(1, $result);
		}


	}

?>
