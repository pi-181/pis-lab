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
                <li class="nav-item"><a class="nav-link" href="blog.php">Дім</a></li>
                <li class="nav-item"><a class="nav-link" href="newnote.php">Новий запис</a></li>
                <li class="nav-item"><a class="nav-link" href="email.php">Відправити повідомлення</a></li>
                <li class="nav-item"><a class="nav-link" href="photo.php">Фото</a></li>
                <li class="nav-item"><a class="nav-link" href="files.php">Файли</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Адміністратору</a></li>
                <li class="nav-item"><a class="nav-link" href="inform.php">Інформація</a></li>
            </ul>
        </div>
        <form class="form-inline" action="search.php" method="get">
            <label>
                <input type="text" class="form-control mb-2 mr-sm-2" name="usersearch" placeholder="Що будемо шукати?" value="<?php echo $_GET['usersearch']?>">
            </label>
            <button type="submit" class="btn btn-primary mb-2">Знайти</button>
        </form>
    </nav>
</header>
<main>
    <div class="container-fluid">
        <div class="container">
            <?php
            require_once("connections/pis_blog.php");

            $user_search = $_GET['usersearch'];
            if (!isset($user_search) || empty($user_search)) {
                die('Рядок пушуку пустий!');
            }

            $where_list = array();
            $query = "SELECT * FROM notes";

            $clean_search = str_replace(',', ' ', $user_search);
            $search_words = explode(' ', $user_search);

            $final_search_words = array();
            foreach ($search_words as $word) {
                if (!empty($word)) {
                    $final_search_words[] = mysqli_real_escape_string($connection, $word);
                }
            }

            foreach ($final_search_words as $word) {
                $where_list[] = " article LIKE '%$word%'";
            }

            $where_clause = implode(' OR ', $where_list);
            if (!empty($where_clause)) {
                $query .= " WHERE $where_clause";
            }

            $result = mysqli_query($connection, $query);
            while ($note = mysqli_fetch_array($result)) {
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
