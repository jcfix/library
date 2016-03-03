<?php

	require_once __DIR__.'/../vendor/autoload.php';
	require_once __DIR__."/../src/Book.php";
  	require_once __DIR__."/../src/Author.php";

	$app = new Silex\Application();

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
		return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors()));
	});

	// Post an author to a specific book
	$app->post('/book/{id}/add_author', function($id) use ($app) {
		$book = Book::find($id);
		$new_author = new Author($_POST['name'], $id = null);
		$new_author->save();
		$book->addAuthor($new_author);
		return $app['twig']->render('book.html.twig', array('book' => $book, 'authors' => $book->getAuthors()));
	});

	// Remove a specific book from library
	$app->delete('/book/{id}/delete', function($id) use ($app) {
		$book = Book::find($id);
		$book->deleteBook();
		return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
	});


	return $app;

?>
