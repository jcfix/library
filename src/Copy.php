<?php
	 class Copy
	{

		private $id;
		private $book_id;
		private $checkout;
		private $due_date;

		function __construct($id = null, $book_id, $checkout, $due_date)
		{
			$this->id = $id;
			$this->book_id = $book_id;
			$this->checkout = $checkout;
			$this->due_date = $due_date;
		}

		function getId()
		{
			return $this->id;
		}

		function getBookId()
		{
			return $this->book_id;
		}

		function getCheckedOut()
		{
			return $this->checkout;
		}

		function getDueDate()
		{
			return $this->due_date;
		}

		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO copies (book_id, checkout, due_date) VALUES ({$this->getBookId()}, {$this->getCheckedOut()}, '{$this->getDueDate()}');");
			$this->id = $GLOBALS['DB']->lastInsertId();
		}

		static function getAll()
		{
			$query = $GLOBALS['DB']->query("SELECT * FROM copies;");
			$copies = array();
			foreach($query as $copy) {
				$id = $copy['id'];
				$book_id = $copy['book_id'];
				$checkout = $copy['checkout'];
				$due_date = $copy['due_date'];
				$new_copy = new Copy($id, $book_id, $checkout, $due_date);
				array_push($copies, $new_copy);
			}
			return $copies;
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM copies;");
		}

		function deleteACopy()
		{
			$GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");
			$GLOBALS['DB']->exec("DELETE FROM checkouts WHERE copy_id = {$this->getId()};");
		}

		static function find($search_id)
		{
			$found_copy = null;
			$copies = Copy::getAll();
			foreach($copies as $copy) {
				if($search_id == $copy->getId()) {
					$found_copy = $copy;
				}
			}
			return $found_copy;
		}

		function getBook($book_id)
		{
			return Book::find($book_id);
		}

			//GOAL: get a book from a copy.
			// copies table book_id and take it out and scan it on book table for a matching id.
//
// 			SELECT copies.* FROM books
// 			JOIN ON books.id = copies.book_id
// 			WHERE copy.id = {$this->getId()}
//
// 			$query = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$book->getId()};");
// 			$books = $query->fetchAll(PDO::FETCH_ASSOC);
// var_dump($query);
// 			$book_results = array();
// 			foreach($books as $book) {
// 				$title = $book['title'];
// 				$id = $book['id'];
// 				$new_book = new Book($title, $id);
// 				array_push($book_results, $new_book);
// 			}
// 			return $book_results;



		//
		// function getCopies()
		// {
		// 	$query = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$this->getId()};");
		// 	$copies = $query->fetchAll(PDO::FETCH_ASSOC);
		//
		// 	$copy_results = array();
		// 	foreach($copies as $copy) {
		// 		$id = $copy['id'];
		// 		$book_id = $copy['book_id'];
		// 		$checkout = $copy['checkout'];
		// 		$due_date = $copy['due_date'];
		// 		$new_copy = new Copy($id, $book_id, $checkout, $due_date);
		// 		array_push($copy_results, $new_copy);
		// 	}
		// 	return $copy_results;
		//
		// }

	}
 ?>
