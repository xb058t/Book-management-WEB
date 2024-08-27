<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | New book</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <?php
    include 'storage.php';
    $bookStorage = new Storage(new JsonIO('data/books.json'));
    $books = $bookStorage->findAll();

    $title = $_POST['title'] ?? "";
    $author = $_POST['author'] ?? "";
    $description = $_POST['description'] ?? "";
    $image = $_POST['image'] ?? "";
    $year = $_POST['year'] ?? "";
    $planet = $_POST['planet'] ?? "";
    $genre = $_POST['genre'] ?? "";

    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($title == "") {
            $errors[] = "Title is required";
        }
        if ($author == "") {
            $errors[] = "Author is required";
        }
        if ($description == "") {
            $errors[] = "Description is required";
        }
        if ($image == "") {
            $errors[] = "Image is required";
        }
        if ($year == "") {
            $errors[] = "Year is required";
        }
        if ($planet == "") {
            $errors[] = "Planet is required";
        }
        if ($genre == "") {
            $errors[] = "Genre is required";
        }

        if (count($errors) == 0) {
            $bookStorage->add([
                'title' => $title,
                'author' => $author,
                'description' => $description,
                'image' => "assets/book_cover_" . $image . ".png",
                'year' => $year,
                'planet' => $planet,
                'genre' => $genre,
            ]);

            header('Location: index.php');
            exit();
        }
    }
    ?>
    <header>
        <h1><a href="index.php">IK-Library</a> > New Book</h1>
    </header>
    <div id="content">

        <form method="POST" action="newbook.php">
            <div>
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo $title; ?>" />
            </div>

            <div>
                <label for="author">Author</label>
                <input type="text" id="author" name="author" value="<?php echo $author; ?>" />
            </div>

            <div>
                <label for="description">Description</label>
                <textarea type="text" id="description" name="description"><?php echo $description; ?></textarea>
            </div>

            <div>
                <label for="image">Cover Image</label>
                <select id="image" name="image">
                    <?php
                    for ($i = 1; $i <= 6; $i++) {
                        echo '<option value="' . $i . '" ' . ($image == $i ? 'selected' : '') . '>Cover #' . $i . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="year">Year of publication</label>
                <input type="number" id="year" name="year" />
            </div>

            <div>
                <label for="planet">Source planet</label>
                <input type="text" id="planet" name="planet" />
            </div>

            <div>
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" />
            </div>

            <div>
                <?php
                if (count($errors) > 0) {
                    echo '<ul>';
                    foreach ($errors as $error) {
                        echo '<li style="color:red">' . $error . '</li>';
                    }
                    echo '</ul>';
                }
                ?>
            </div>

            <button type="submit">
                Create
            </button>
        </form>

    </div>
    <footer>
        <p>IK-Library | ELTE IK Webprogramming</p>
    </footer>
</body>

</html>