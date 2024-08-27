<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | Details page</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <?php
    include 'storage.php';
    $bookStorage = new Storage(new JsonIO('data/books.json'));
    $books = $bookStorage->findAll();

    $book = $bookStorage->findById($_GET['id']);

    $title = $book['title'] ?? "";
    $author = $book['author'] ?? "";
    $description = $book['description'] ?? "";
    $image = $book['image'] ?? "";
    $year = $book['year'] ?? "";
    $planet = $book['planet'] ?? "";
    ?>
    <header>
        <h1><a href="index.php">IK-Library</a> > New Book</h1>
    </header>
    <div id="content">
        <a href="index.php" style="width: 100%; display: block;">Return back</a>
        <img src="<?php echo $book['image']; ?>" />
        <p>
            Title: <strong><?php echo $title; ?></strong>
            <br>
            Author: <strong><?php echo $author; ?></strong>
            <br>
            Description: <strong><?php echo $description; ?></strong>
            <br>
            Year of publication: <strong><?php echo $year; ?></strong>
            <br>
            Source planet: <strong><?php echo $planet; ?></strong>
        </p>
    </div>
    <footer>
        <p>IK-Library | ELTE IK Webprogramming</p>
    </footer>
</body>

</html>