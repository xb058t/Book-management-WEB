<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | Account registration</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <?php
    session_start();
    include 'storage.php';
    $userStorage = new Storage(new JsonIO('data/users.json'));
    $users = $userStorage->findAll();

    $username = $_POST['username'] ?? "";
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";

    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($username == "") {
            $errors[] = "Username is required";
        } else {
            foreach ($users as $user) {
                if ($user['username'] == $username) {
                    $errors[] = "Username already exists";
                    break;
                }
            }
        }
        if ($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email is required";
        } else {
            foreach ($users as $user) {
                if ($user['email'] == $email) {
                    $errors[] = "Email already exists";
                    break;
                }
            }
        }
        if ($password == "") {
            $errors[] = "Password is required";
        }

        if (count($errors) == 0) {
            $userStorage->add([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'reviews' => [],
                'booksRead' => [],
                'isAdmin' => false
            ]);
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit();
        }
    }
    ?>
    <header>
        <h1><a href="index.php">IK-Library</a> > Account registration</h1>
    </header>
    <div id="content">

        <form method="POST" action="register.php">
            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" />
            </div>

            <div>
                <label for="email">Email</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>" />
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="<?php echo $password; ?>" />
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