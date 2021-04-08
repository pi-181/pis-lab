<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Blog</title>
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
                <li class="nav-item"><a class="nav-link" href="blog.php">Дім</a></li>
                <li class="nav-item"><a class="nav-link" href="newnote.php">Новий запис</a></li>
                <li class="nav-item active"><a class="nav-link" href="email.php">Відправити повідомлення <span class="sr-only">(відкрито)</span></a></li>
                <li class="nav-item"><a class="nav-link" href="photo.php">Фото</a></li>
                <li class="nav-item"><a class="nav-link" href="files.php">Файли</a></li>
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

            <form method="post" action="email.php">
                <div class="form-group">
                    <label for="subject">Тема</label>
                    <input type="text" class="form-control" name="subject" id="subject">
                </div>
                <div class="form-group">
                    <label for="text">Текст</label>
                    <textarea class="form-control" name="text" id="text" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Відправити</button>
            </form>

            <?php
            $subject = $_POST['subject'];
            $text = $_POST['text'];

            if (isset($subject, $text)) {
                if (strlen($subject) > 0 && strlen($text) > 0) {
                    mail('admin@travel.notes', $subject, $text);
                    echo '<br><div class="alert alert-success" role="alert">Повідомлення успішно відправлено!</div>';
                } else {
                    echo '<br><div class="alert alert-danger" role="alert">Заповніть всі поля!</div>';
                }
            }
            ?>
        </div>
    </div>
</main>
</body>

</html>