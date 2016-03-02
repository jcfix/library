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
	}
 ?>
