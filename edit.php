<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | Edit Book</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <?php
    session_start();
    include 'storage.php';
    $bookStorage = new Storage(new JsonIO('data/books.json'));
    $books = $bookStorage->findAll();

    $book = null;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $book = $bookStorage->findOne(['id' => $id]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $book !== null) {
        $book['title'] = $_POST['title'];
        $book['author'] = $_POST['author'];
        $book['description'] = $_POST['description'];
        $book['image'] = $_POST['image'];
        $book['year'] = $_POST['year'];
        $book['planet'] = $_POST['planet'];
        $book['genre'] = $_POST['genre'];

        $bookStorage->update($id, $book);

        header('Location: index.php');
        exit;
    }
    ?>

    <header>
        <h1><a href="index.php">IK-Library</a> > Edit Book</h1>
    </header>
    <div id="content">
        <?php if ($book !== null):
            echo '<div style="width: 300px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
            ?>

            <form method="post">
                <input type="hidden" name="id" <?= $id ?>">
                <label>
                    Title:
                    <input type="text" name="title" value="<?= $book['title'] ?>">
                </label>
                <label>
                    Author:
                    <input type="text" name="author" value="<?= $book['author'] ?>">
                </label>
                <label>
                    Description:
                    <textarea name="description"><?= $book['description'] ?></textarea>
                </label>
                <label>
                    Image:
                    <input type="text" name="image" value="<?= $book['image'] ?>">
                </label>
                <label>
                    Year:
                    <input type="text" name="year" value="<?= $book['year'] ?>">
                </label>
                <label>
                    Planet:
                    <input type="text" name="planet" value="<?= $book['planet'] ?>">
                </label>
                <label>
                    Planet:
                    <input type="text" name="genre" value="<?= $book['genre'] ?>">
                </label>
                <button type="submit">Save</button>
            </form>
        <?php else: ?>
            <p>Book not found.</p>
        <?php endif;
        echo '</div>' ?>
    </div>

    <footer>
        <p>IK-Library | ELTE IK Webprogramming</p>
    </footer>
</body>

</html>