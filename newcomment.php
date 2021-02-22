<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Новий коментар</title>
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="blog.php">Blog</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Увійти</a></li>
                <li class="nav-item"><a class="nav-link" href="blog.php">Дім</a></li>
                <li class="nav-item"><a class="nav-link" href="newnote.php">Новий запис</a></li>
                <li class="nav-item"><a class="nav-link" href="email.php">Відправити повідомлення</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Фото</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Файли</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Адміністратору</a></li>
                <li class="nav-item"><a class="nav-link" href="inform.html">Інформація</a></li>
            </ul>
        </div>
    </nav>
</header>
<main>
    <div class="container-fluid">
        <div class="container">
            <?php
            if (!isset($_GET['note'])) {
                die("Запис був видалений або ніколи не існував!");
            }

            require_once("connections/pis_blog.php");
            $note_id = mysqli_real_escape_string($connection, $_GET['note']);
            if (!is_numeric($note_id)) {
                die("Запис був видалений або ніколи не існував!");
            }

            $result = mysqli_query($connection, "SELECT * FROM notes WHERE id = $note_id");
            if (mysqli_num_rows($result) < 1) {
                die("Запис був видалений або ніколи не існував!");
            }

            $note = mysqli_fetch_array($result, MYSQLI_ASSOC);
            echo '<div class="row">';
            echo '<h1>' . $note['title'] . '</h1>' . $note['created'] . '<br>';
            echo '<p>' . $note['article'] . '</p><br>';
            echo '</div><hr>';
            mysqli_free_result($result);
            ?>

            <div class="row">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="author">Автор</label>
                        <input type="text" class="form-control" name="author" id="author">
                    </div>
                    <div class="form-group">
                        <label for="text">Зміст</label>
                        <textarea class="form-control" name="text" id="text" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Відправити коментар</button>
                </form>
            </div>
            <div class="row text-right">
                <?php
                echo '<a role="button" href="comments.php?note=' . $note_id . '">Перейти до коментарів</a></div>';
                ?>
            </div>

            <?php
            $raw_author = $_POST['author'];
            $raw_text = $_POST['text'];

            if (isset($raw_author, $raw_text) ) {
                if (strlen($raw_author) > 3 && strlen($raw_text) > 10) {
                    $author = mysqli_real_escape_string($connection, $raw_author);
                    $text = mysqli_real_escape_string($connection, $raw_text);
                    $created = date('Y-m-d');

                    mysqli_query($connection, "INSERT INTO comments (author, comment, created, art_id) VALUES ('$author', '$text', '$created', '$note_id')");
                    echo '<br><div class="alert alert-success" role="alert">Новий коментар створений!</div>';
                } else {
                    echo '<br><div class="alert alert-danger" role="alert">'
                        . 'Неправильно заповнена форма!'
                        . '<br>'
                        . 'Мінімальна кількість символів імені автору від 3, а змісту від 10.'
                        . '</div>';

                }
            }
            mysqli_close($connection);
            ?>
        </div>
    </div>
</main>
</body>

</html>