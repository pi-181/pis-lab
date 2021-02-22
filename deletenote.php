<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Видалення запису</title>
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
    </nav>
</header>
<main>
    <div class="container-fluid">
        <div class="container">
            <?php
            function die_err($message) {
                die('<br><div class="alert alert-danger" role="alert">'.$message.'</div>');
            }

            if (!isset($_GET['note'])) {
                die_err('Ідентифікатор запису не вказаний!');
            }

            require_once("connections/pis_blog.php");
            $note_id = mysqli_real_escape_string($connection, $_GET['note']);
            if (!is_numeric($note_id)) {
                mysqli_close($connection);
                die_err('Ідентифікатор запису повинен бути числом!');
            }

            $result = mysqli_query($connection, "SELECT * FROM notes WHERE id = $note_id");
            if (mysqli_num_rows($result) < 1) {
                mysqli_close($connection);
                die_err('Запис був видалений або ніколи не існував!');
            }

            $note = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $note_title = $note['title'];
            $note_article = $note['article'];
            $submit = isset($_POST['submit']);
            ?>

            <form method="post" action="">
                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input type="text" class="form-control" name="title" id="title" disabled value="<?php echo $note_title?>">
                </div>
                <div class="form-group">
                    <label for="article">Зміст</label>
                    <textarea class="form-control" name="article" id="article" rows="3" disabled><?php echo $note_article?></textarea>
                </div>
                <?php
                if (!$submit) {
                    echo '<button type="submit" name="submit" class="btn btn-danger mx-1">Видалити запис</button>';
                    echo '<a class="btn btn-primary mx-1" href="comments.php?note='.$note_id.'">Повернутися</a>';
                } else {
                    echo '<a class="btn btn-primary mx-1" href="blog.php">Повернутися</a>';
                }
                ?>
            </form>

            <?php
            if ($submit) {
                $delete_result = mysqli_query($connection, "DELETE FROM notes WHERE id = $note_id");
                echo '<br><div class="alert alert-success" role="alert">Запис видалено!</div>';
            }

            mysqli_close($connection);
            ?>
        </div>
    </div>
</main>
</body>

</html>