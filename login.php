<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | Login</title>
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
    $password = $_POST['password'] ?? "";

    $errors = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userFound = false;
        foreach ($users as $user) {
            if ($user['username'] == $username && $user['password'] == $password) {
                $userFound = true;
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit();
            }
        }
        if (!$userFound) {
            $errors[] = "Invalid username or password";
        }
    }
    ?>
    <header>
        <h1><a href="index.php">IK-Library</a> > Login</h1>
    </header>
    <div id="content">

        <form method="POST" action="login.php">
            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" />
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
                Login
            </button>
        </form>

    </div>
    <footer>
        <p>IK-Library | ELTE IK Webprogramming</p>
    </footer>
</body>

</html>