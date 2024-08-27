<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'storage.php';
$bookStorage = new Storage(new JsonIO('data/books.json'));
$bookId = $_POST['book_id'];
$review = str_replace(["\r\n", "\n", "\r", "\t", "\0", "\v", "\f"], "", $_POST['review']);
$rating = $_POST['rating'];

$book = $bookStorage->findById($bookId);
if ($book === null) {
    header('Location: index.php');
    exit();
}

$book['reviews'][] = [
    'username' => $_SESSION['username'],
    'review' => $review,
    'rating' => $rating
];

$userStorage = new Storage(new JsonIO('data/users.json'));
$user = $userStorage->findOne(['username' => $_SESSION['username']]);

if ($user) {
    $user['reviews'][] = [
        'book_id' => $bookId,
        'review' => $review,
        'rating' => $rating
    ];
    $userStorage->update($user['id'], $user);
}

$bookStorage->update($bookId, $book);

header('Location: index.php');
exit();
?>