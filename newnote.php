<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Новий запис</title>
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
                <li class="nav-item active"><a class="nav-link" href="newnote.php">Новий запис <span class="sr-only">(відкрито)</span></a></li>
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

            <form method="post" action="newnote.php">
                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input type="text" class="form-control" aria-describedby="titleHelp" name="title" id="title">
                    <small id="titleHelp" class="form-text text-muted">* Від 10 до 100 символів</small>
                </div>
                <div class="form-group">
                    <label for="article">Зміст</label>
                    <textarea class="form-control" aria-describedby="articleHelp" name="article" id="article" rows="3"></textarea>
                    <small id="articleHelp" class="form-text text-muted">* Мінімум 60 символів</small>
                </div>
                <button type="submit" class="btn btn-primary">Створити запис</button>
            </form>

            <?php
            $rawTitle = $_POST['title'];
            $rawArticle = $_POST['article'];

            if (isset($rawTitle, $rawArticle) ) {
                if (strlen($rawTitle) > 10 && strlen($rawArticle) > 60) {
                    require_once("connections/pis_blog.php");
                    $title = mysqli_real_escape_string($connection, $rawTitle);
                    $article = mysqli_real_escape_string($connection, $rawArticle);
                    $created = date('Y-m-d');

                    mysqli_query($connection,
                        "INSERT INTO notes (title, article, created) VALUES ('$title', '$article', '$created')");
                    echo '<br><div class="alert alert-success" role="alert">Новий запис створений!</div>';
                } else {
                    echo '<br><div class="alert alert-danger" role="alert">'
                        .'Неправильно заповнена форма!'
                        .'<br>'
                        .'Мінімальна кількість символів заголовку від 10 до 100, а змісту від 60.'
                        .'</div>';
                }
            }
            ?>
        </div>
    </div>
</main>
</body>

</html>