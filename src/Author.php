<?php
	class Author
	{
		private $name;
		private $id;

		function __construct($name, $id)
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
			$GLOBALS['DB']->exec("INSERT INTO authors (name) VALUES ('{$this->getName()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}

		static function getAll()
		{
			$query = $GLOBALS['DB']->query("SELECT * FROM authors;");
			$authors = array();
			foreach($query as $author) {
				$name = $author['name'];
				$id = $author['id'];
				$new_author = new Author($name, $id);
				array_push($authors, $new_author);
			}
			return $authors;
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM authors;");
		}

		function addBook($book)
		{
			$GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$book->getId()}, {$this->getId()});");
		}

		function getBooks()
		{
			$query = $GLOBALS['DB']->query("SELECT books.* FROM authors
				JOIN books_authors ON (authors.id = books_authors.author_id)
				JOIN books ON (books_authors.book_id = books.id)
				WHERE authors.id = {$this->getId()};");
			$book_ids = $query->fetchAll(PDO::FETCH_ASSOC);

			$books = array();
			foreach($book_ids as $book) {
				$title = $book['title'];
				$id = $book['id'];
				$new_book = new Book($title, $id);
				array_push($books, $new_book);
			}
			return $books;
		}
	}
 ?>
