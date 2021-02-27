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
            <a class="navbar-brand" href="blog.html">Blog</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Увійти</a></li>
                <li class="nav-item"><a class="nav-link" href="blog.php">Дім</a></li>
                <li class="nav-item"><a class="nav-link" href="newnote.php">Новий запис</a></li>
                <li class="nav-item"><a class="nav-link" href="email.php">Відправити повідомлення</a></li>
                <li class="nav-item"><a class="nav-link" href="photo.php">Фото</a></li>
                <li class="nav-item"><a class="nav-link" href="files.php">Файли</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Адміністратору</a></li>
                <li class="nav-item active"><a class="nav-link" href="inform.php">Інформація <span class="sr-only">(відкрито)</span></a>
                </li>
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
        <?php
        require_once("connections/pis_blog.php");

        // count of all notes
        $result = mysqli_query($connection, 'SELECT COUNT(*) as notes_count FROM notes');
        $notes_count = mysqli_fetch_array($result, MYSQLI_ASSOC)['notes_count'];
        mysqli_free_result($result);

        // count of all comments
        $result = mysqli_query($connection, 'SELECT COUNT(*) as comments_count FROM comments');
        $comments_count = mysqli_fetch_array($result, MYSQLI_ASSOC)['comments_count'];
        mysqli_free_result($result);

        // date init
        $date_array = getdate();
        $begin_date = date("Y-m-d", mktime(0, 0, 0, $date_array['mon'], 1, $date_array['year']));
        $end_date = date("Y-m-d", mktime(0, 0, 0, $date_array['mon'] + 1, 0, $date_array['year']));

        // notes for last month
        $result = mysqli_query($connection, "SELECT COUNT(*) AS month_notes FROM notes WHERE created>='$begin_date' AND created<='$end_date'");
        $month_notes_count = mysqli_fetch_assoc($result)['month_notes'];
        mysqli_free_result($result);

        // comments for last month
        $result = mysqli_query($connection, "SELECT COUNT(*) AS month_comments FROM comments WHERE created>='$begin_date' AND created<='$end_date'");
        $month_comments_count = mysqli_fetch_assoc($result)['month_comments'];
        mysqli_free_result($result);

        // latest note
        $result = mysqli_query($connection, 'SELECT id, title FROM notes ORDER BY created DESC LIMIT 0,1');
        $latest_note = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        // most commented note
        $result = mysqli_query($connection, 'SELECT notes.id, notes.title FROM comments, notes '
            .'WHERE comments.art_id = notes.id '
            .'GROUP BY notes.id '
            .'ORDER BY COUNT(comments.id) '
            .'DESC LIMIT 0,1');
        $most_commented_note = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        mysqli_close($connection);
        ?>

        <div class="container">
            <div class="row">
                <h2>Статистика</h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p>Зроблено записів: <?php echo $notes_count?></p><br>
                </div>
                <div class="col-md-4">
                    <p>Залишено коментарів: <?php echo $comments_count?></p><br>
                </div>
                <div class="col-md-4">
                    <p>За останній місяць створено записів: <?php echo $month_notes_count?></p><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p>За останній місяць залишено коментарів: <?php echo $month_comments_count?></p><br>
                </div>
                <div class="col-md-4">
                    <p>Останній запис: <a href="comments.php?note=<?php echo $latest_note['id']?>"><?php echo $latest_note['title']?></a></p><br>
                </div>
                <div class="col-md-4">
                    <p>Найбільш обговорюваний запис:<a href="comments.php?note=<?php echo $most_commented_note['id']?>"><?php echo $most_commented_note['title']?></a></p><br>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

</html>