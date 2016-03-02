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
		}

	}
 ?>
