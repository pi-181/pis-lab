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
                <li class="nav-item"><a class="nav-link" href="#">Увійти</a></li>
                <li class="nav-item active"><a class="nav-link" href="blog.php">Дім <span class="sr-only">(відкрито)</span></a></li>
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
            require_once ("connections/pis_blog.php");

            $result = mysqli_query($connection, "SELECT * FROM notes ORDER BY created");
            while ($note = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                if (strlen($content = $note['article']) > 1400) {
                    $content = substr($content, 0, 997) . '...';
                }

                echo '<div class="row">';
                echo '<h1> <a href="comments.php?note=' . $note['id'] . '">'. $note['title'] . '</a></h1>' . $note['created'] . '<br>';
                echo '<p>' . $content . '</p><br>';
                echo '</div><hr>';
            }

            mysqli_free_result($result);
            mysqli_close($connection);
            ?>
        </div>
    </div>
</main>
</body>

</html>