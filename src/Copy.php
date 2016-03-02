<?php
	 class Copy
	{

		private $id;
		private $book_id;
		private $checkout;

		function __construct($id = null, $book_id, $checkout)
		{
			$this->id = $id;
			$this->book_id = $book_id;
			$this->checkout = $checkout;
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

		function save()
		{
			$GLOBALS['DB']->exec("INSERT INTO copies (book_id, checkout) VALUES ({$this->getBookId()}, {$this->getCheckedOut()});");
			$this->id = $GLOBALS['DB']->lastInsertId();
	// var_dump($this);
		}

		static function getAll()
		{
			$query = $GLOBALS['DB']->query("SELECT * FROM copies;");
			$copies = array();
			foreach($query as $copy) {
				$id = $copy['id'];
				$book_id = $copy['book_id'];
				$checkout = $copy['checkout'];
				$new_copy = new Copy($id, $book_id, $checkout);
				array_push($copies, $new_copy);
			}
			return $copies;
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM copies;");
		}

	}
 ?>
