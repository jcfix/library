<?php

	require_once __DIR__.'/../vendor/autoload.php';
	require_once __DIR__."/../src/Book.php";
  	require_once __DIR__."/../src/Author.php";
	require_once __DIR__."/../src/Copy.php";
	require_once __DIR__."/../src/Patron.php";

	$app = new Silex\Application();

	// $app['debug'] = true;

	$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

	// Setup server for database
    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    // Allow patch and delete request to be handled by browser
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

	// Gets homepage
	$app->get('/', function() use ($app) {
		return $app['twig']->render('index.html.twig');
	});

	// Get librarian page with book-list and add-book form
	$app->get('/librarian', function() use ($app) {
		return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
	});

	// Post a book to librarian page
	$app->post('/add_book', function() use ($app) {
		$new_book = new Book($_POST['title']);
		$new_book->save();
		return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()
	  ));
	});

	// Get specific book page with add-author form
	$app->get('/book/{id}', function($id) use ($app) {
		$book = Book::find($id);
		return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'copies' => $book->getCopies()));
	});

	// Post an author to a specific book
	$app->post('/book/{id}/add_author', function($id) use ($app) {
		$book = Book::find($id);
		$new_author = new Author($_POST['name'], $id = null);
		$new_author->save();
		$book->addAuthor($new_author);
		return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors()));
	});

	// Delete a specific book from library
	$app->delete('/book/{id}/delete', function($id) use ($app) {
		$book = Book::find($id);
		$book->deleteBook();
		return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
	});

	// Delete all books
	$app->post('/delete_all_books', function() use ($app) {
		Book::deleteAll();
		return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()
	  ));
	});

	// Add a copy of a book
	$app->post('/book/{id}/add_copy', function($id) use ($app) {
		$book = Book::find($id);
		$book_id = $book->getId();
		$new_copy = new Copy($id = null, $book_id, $_POST['checkout'], $_POST['date']);
		$new_copy->save();
		$book->addCopy($new_copy);
		return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'copies' => $book->getCopies()
	  ));
	});

	// Go to copy edit page
	$app->get('/copy/{id}/edit', function($id) use ($app) {
		$copy = Copy::find($id);
		$book = $copy->getBook($copy->getBookId());
		return $app['twig']->render('copy_edit.html.twig', array('copy' => $copy, 'book' => $book));
	});

	// Remove single copy
	$app->delete('/book/{book_id}/copy/{id}/delete', function($book_id, $id) use ($app) {
		$book = Book::find($book_id);
		$copy = Copy::find($id);
		// $copy->getBook($book_id);
		$copy->deleteACopy();
		return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors(), 'copies' => $book->getCopies()

	  ));
	});


	// Update copy
	$app->patch('/book/{id}/edit', function($id) use ($app) {
		$copy = Copy::find($id);
		$
	});

	return $app;

?>
