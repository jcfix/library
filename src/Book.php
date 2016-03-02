<?php
	 class Book
	{

		private $title;
		private $id;

		function __construct($title, $id =null)
		{
			$this->title = $title;
			$this->id = $id;
		}

		function getTitle()
		{
			return $this->title;
		}

		function getId()
		{
			return $this->id;
		}

		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}

		static function getAll()
		{
			$query = $GLOBALS['DB']->query("SELECT * FROM books;");
			$books = array();
			foreach($query as $book) {
				$title = $book['title'];
				$id = $book['id'];
				$new_book = new Book($title, $id);
				array_push($books, $new_book);
			}
			return $books;
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM books;");
		}

		static function find($search_id)
		{
			$found_book = null;
			$books = Book::getAll();
			foreach($books as $book) {
				if($search_id == $book->getId()) {
					$found_book = $book;
				}
			}
			return $found_book;
		}

		static function findByTitle($search_title)
		{
			$found_book = null;
			$books = Book::getAll();
			foreach($books as $book) {
				if($search_title == $book->getTitle()) {
					$found_book = $book;
				}
			}
			return $found_book;
		}

		function addAuthor($author)
		{
			$GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$this->getId()}, {$author->getId()});");
		}

		function getAuthors()
		{
			$query = $GLOBALS['DB']->query("SELECT authors.* FROM books
				JOIN books_authors ON (books.id = books_authors.book_id)
				JOIN authors ON (books_authors.author_id = authors.id)
				WHERE books.id = {$this->getId()};");
			$authors = $query->fetchAll(PDO::FETCH_ASSOC);

			$authors_result = array();
			foreach($authors as $author) {
				$name = $author['name'];
				$id = $author['id'];
				$new_author = new Author($name, $id);
				array_push($authors_result, $new_author);
			}
			return $authors_result;
		}

		function deleteBook()
		{
			$GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
			// $GLOBALS['DB']->exec("DELETE FROM books_authors WHERE book_id = {$this->getId()};");
		}






	}
 ?>
