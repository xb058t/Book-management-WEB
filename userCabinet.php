<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <header>
        <h1><a href="index.php">IK-Library</a> > Home</h1>
    </header>
    <?php
    session_start();
    include 'storage.php';

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    $userStorage = new Storage(new JsonIO('data/users.json'));
    $user = $userStorage->findOne(['username' => $_SESSION['username']]);

    if (!$user) {
        echo 'User not found';
        exit();
    }


    $bookStorage = new Storage(new JsonIO('data/books.json'));

    echo '<div style="width: 300px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    echo '<h1 style="text-align: center; color: #333;">User Details</h1>';
    echo '<p><strong>Username:</strong> ' . $user['username'] . '</p>';
    echo '<p><strong>Email:</strong> ' . $user['email'] . '</p>';
    echo '<p><strong>Number of Reviews:</strong> ' . count($user['reviews']) . '</p>';
    if (count($user['reviews']) > 0) {
        echo '<h2>Reviews</h2>';
        foreach ($user['reviews'] as $review) {
            $book = $bookStorage->findById($review['book_id']);
            if ($book !== null) {
                echo '<div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">';
                echo '<p><strong>Book:</strong> ' . $book['title'] . '</p>';
                echo '<p><strong>Rating:</strong> ' . $review['rating'] . '</p>';
                echo '<p><strong>Review:</strong> ' . $review['review'] . '</p>';
                echo '</div>';
            }
        }
    }
    echo '</div>';
    ?>
</body>

</html>