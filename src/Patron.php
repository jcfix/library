<?php
	class Patron
	{
		private $name;
		private $id;

		function __construct($name, $id = null)
		{
			$this->name = $name;
			$this->id = $id;
		}

		function getName()
        {
            return $this->name;
        }

		function getId()
        {
            return $this->id;
        }

		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO patrons (name) VALUES ('{$this->getName()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}

		static function getAll()
		{
			$query = $GLOBALS['DB']->query("SELECT * FROM patrons;");
			$patrons = array();
			foreach($query as $patron) {
				$name = $patron['name'];
				$id = $patron['id'];
				$new_patron = new Patron($name, $id);
				array_push($patrons, $new_patron);
			}
			return $patrons;
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM patrons;");
		}

		static function find($search_id)
		{
			$found_patron = null;
			$patrons = Patron::getAll();
			foreach($patrons as $patron) {
				if($search_id == $patron->getId()) {
					$found_patron = $patron;
				}
			}
			return $found_patron;
		}

		static function findByName($search_name)
		{
			$found_patron = null;
			$patrons = Patron::getAll();
			foreach($patrons as $patron) {
				if($search_name == $patron->getName()) {
					$found_patron = $patron;
				}
			}
			return $found_patron;
		}



		// function addBook($book)
		// {
		// 	$GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$book->getId()}, {$this->getId()});");
		// }
		//
		// function getBooks()
		// {
		// 	$query = $GLOBALS['DB']->query("SELECT books.* FROM authors
		// 		JOIN books_authors ON (authors.id = books_authors.author_id)
		// 		JOIN books ON (books_authors.book_id = books.id)
		// 		WHERE authors.id = {$this->getId()};");
		// 	$book_ids = $query->fetchAll(PDO::FETCH_ASSOC);
		//
		// 	$books = array();
		// 	foreach($book_ids as $book) {
		// 		$title = $book['title'];
		// 		$id = $book['id'];
		// 		$new_book = new Book($title, $id);
		// 		array_push($books, $new_book);
		// 	}
		// 	return $books;
		// }
		//
		// static function findByPatron($search_name)
		// {
		// 	$found_author = null;
		// 	$authors = Patron::getAll();
		// 	foreach($authors as $author) {
		// 		if ($search_name == $author->getName()) {
		// 			$found_author = $author;
		// 		}
		// 	}
		// 	return $found_author;
		// }
	}
 ?>
