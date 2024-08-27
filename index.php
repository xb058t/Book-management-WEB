<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | Home</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <?php
    session_start();
    include 'storage.php';
    $bookStorage = new Storage(new JsonIO('data/books.json'));
    $books = $bookStorage->findAll();
    ?>
    <header>
        <h1><a href="index.php">IK-Library</a> > Home</h1>
        <?php
        if (isset($_SESSION['username'])) {
            echo '<p>Welcome, <a style="color: white;" href="userCabinet.php?username=' . $_SESSION['username'] . '">' . $_SESSION['username'] . '</a></p>';
        }
        ?>
    </header>
    <div id="content">
        <?php


        if (isset($_SESSION['username'])) {
            $userStorage = new Storage(new JsonIO('data/users.json'));
            $user = $userStorage->findOne(['username' => $_SESSION['username']]);
            echo '<a href="logout.php"> Logout </a>';
            if ($user && $user['isAdmin']) {
                echo '<a href="newbook.php"> New book </a>';
            }
        } else {
            echo '<a href="register.php"> Register </a>';
            echo '<a href="login.php"> Login </a>';
        }

        ?>
        <div id="card-list">
            <?php
            foreach ($books as $book) {
                echo '<div class="book-card">';
                echo '<div class="image"><img src="' . $book['image'] . '" alt="book cover"></div>';
                echo '<div class="details"><h2><a href="details.php?id=' . $book['id'] . '">' . $book['author'] . ' - ' . $book['title'] . '</a></h2></div>';
                if (isset($book['reviews']) && count($book['reviews']) > 0) {
                    $ratings = array_column($book['reviews'], 'rating');
                    $averageRating = array_sum($ratings) / count(array_column($book['reviews'], 'rating'));
                    echo '<div class="average-rating">Average rating: ' . round($averageRating, 1) . '</div>';
                } else {
                    echo '<div class="average-rating">Not Rated Yet</div>';
                }
                if (isset($_SESSION['username'])) {
                    echo '<form method="POST" action="review.php">';
                    echo '<input type="hidden" name="book_id" value="' . $book['id'] . '">';
                    echo '<div class="rate">';
                    echo '<select name="rating">';
                    for ($i = 1; $i <= 5; $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    echo '</select>';
                    echo '</div>';
                    echo '<div class="review">';
                    echo '<textarea name="review" placeholder="Write a review..."></textarea>';
                    echo '</div>';
                    echo '<button type="submit">Submit</button>';
                    echo '</form>';
                }
                if ($user && $user['isAdmin']) {
                    echo '<div class="edit"><a href="edit.php?id=' . $book['id'] . '"><button>Edit</button></a></div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <footer>
        <p>IK-Library | ELTE IK Webprogramming</p>
    </footer>
</body>

</html>