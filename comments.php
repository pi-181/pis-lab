<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Comments</title>
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
                <li class="nav-item active"><a class="nav-link" href="blog.php">Дім <span
                                class="sr-only">(відкрито)</span></a></li>
                <li class="nav-item"><a class="nav-link" href="#">Новий запис</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Відправити повідомлення</a></li>
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

            function echo_comment($id, $created, $author, $comment) {
                echo '<div class="card bg-light mb-3" style="max-width: 18rem;"><div class="card-header"> ' . $created . '</div>';
                echo '<div class="card-body"><h5 class="card-title">' . $author . '</h5>';
                echo '<p class="card-text">' . $comment . '</p></div></div>';
            }

            $result = mysqli_query($connection, "SELECT * FROM comments WHERE art_id = $note_id ORDER BY created");
            if (mysqli_num_rows($result) < 1) {
                echo '<p>Цей запис ще ніхто не коментував</p><br>';
            } else {
                while ($comment = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo_comment($comment['id'], $comment['created'], $comment['author'], $comment['comment']);
                }
            }

            mysqli_free_result($result);
            mysqli_close($connection);
            ?>
        </div>
    </div>
</main>
</body>

</html>