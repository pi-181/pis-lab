<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Редагування запису</title>
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
                <li class="nav-item"><a class="nav-link" href="inform.php">Інформація</a></li>
            </ul>
        </div>
        <form class="form-inline" action="search.php" method="get">
            <label>
                <input type="text" class="form-control mb-2 mr-sm-2"  name="usersearch" placeholder="Що будемо шукати?">
            </label>
            <button type="submit" class="btn btn-primary mb-2">Знайти</button>
        </form>
    </nav>
</header>
<main>
    <div class="container-fluid">
        <div class="container">

            <?php
            if (!isset($_GET['note'])) {
                die("Замітка не вказана!");
            }

            $raw_note = $_GET['note'];
            require_once ("connections/pis_blog.php");
            $note_id = mysqli_real_escape_string($connection, $raw_note);

            $result = mysqli_query($connection, "SELECT * FROM notes WHERE id = $note_id");
            if (mysqli_num_rows($result) < 1) {
                mysqli_free_result($result);
                mysqli_close($connection);
                die('<p>Невідома замітка</p>');
            }

            $db_note = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $db_title = $db_note['title'];
            $db_article = $db_note['article'];
            ?>
            <form method="post" action="">
                <input type="text" class="form-control" name="note" id="note" value="<?php echo $note_id?>" hidden>
                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input type="text" class="form-control" aria-describedby="titleHelp" name="title" id="title" value="<?php echo $db_title?>">
                    <small id="titleHelp" class="form-text text-muted">* Від 10 до 100 символів</small>
                </div>
                <div class="form-group">
                    <label for="article">Зміст</label>
                    <textarea class="form-control" aria-describedby="articleHelp" name="article" id="article" rows="3"><?php echo $db_article?></textarea>
                    <small id="articleHelp" class="form-text text-muted">* Мінімум 60 символів</small>
                </div>
                <button type="submit" class="btn btn-primary">Зберегти запис</button>
            </form>

            <?php
            $raw_title = $_POST['title'];
            $raw_article = $_POST['article'];

            if (isset($raw_note, $raw_title, $raw_article) ) {
                if (strlen($raw_title) > 10 && strlen($raw_article) > 60) {
                    require_once("connections/pis_blog.php");
                    $title = mysqli_real_escape_string($connection, $raw_title);
                    $article = mysqli_real_escape_string($connection, $raw_article);

                    mysqli_query($connection, "UPDATE notes SET title = '$title', article = '$article' WHERE id = $note_id");
                    echo '<br><div class="alert alert-success" role="alert">Запис збережено!</div>';
                } else {
                    echo '<br><div class="alert alert-danger" role="alert">'
                        .'Неправильно заповнена форма!'
                        .'<br>'
                        .'Мінімальна кількість символів заголовку від 10 до 100, а змісту від 60.'
                        .'</div>';
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