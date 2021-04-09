<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Blog</title>
</head>

<body>
<main>
    <div class="container-fluid">
        <div class="container">

            <form method="post" action="">
                <div class="form-group">
                    <label for="filename">Назва файлу</label>
                    <input type="text" class="form-control" name="filename"
                           id="filename" value="<?php echo $_POST['filename'] ?>">
                </div>
                <div class="form-group">
                    <label for="from">Що шукати</label>
                    <input type="text" class="form-control" name="from" id="from" value="<?php echo $_POST['from'] ?>">
                </div>
                <div class="form-group">
                    <label for="to">На що заміняти</label>
                    <input type="text" class="form-control" name="to" id="to" value="<?php echo $_POST['to'] ?>">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Замінити</button>
            </form>

            <?php
            // read data
            $filename = $_POST['filename'];
            $from = $_POST['from'];
            $to = $_POST['to'];

            if (!isset($_POST['submit'])) {
                return;
            }

            $failed = false;
            $path_to_file = "";

            // params check
            if (!isset($filename) || empty($filename)) {
                echo '<br><div class="alert alert-danger" role="alert">Параметр "filename" повинен бути вказаний!</div>';
                $failed = true;
            } else {
                $path_to_file = $_SERVER['DOCUMENT_ROOT'] . '/rgr/files/' . $filename;
                if (!file_exists($path_to_file)) {
                    echo '<br><div class="alert alert-danger" role="alert">Вказаний файл не існує!</div>';
                    $failed = true;
                }
            }
            if (!isset($from) || empty($from)) {
                echo '<br><div class="alert alert-danger" role="alert">Параметр "Що шукати" повинен бути вказаний!</div>';
                $failed = true;
            }
            if (!isset($to)) {
                echo '<br><div class="alert alert-danger" role="alert">Параметр "На що заміняти" повинен бути вказаний!</div>';
                $failed = true;
            }

            if ($failed) {
                return;
            }

            // do replacements
            $file_contents = file_get_contents($path_to_file);
            $count = 0;
            $file_contents_r = str_replace($from, $to, $file_contents, $count);
            file_put_contents($path_to_file, $file_contents_r);

            // print out info
            echo '<br><div class="alert alert-success" role="alert">Успішно виконано ' . $count
                . ' замін з ' . $from . ' на ' . $to . '!</div>';

            if ($count !== 0) {
                echo '<br><div class="alert alert-warning" role="alert">' . $file_contents . '</div>';
            }
            echo '<br><div class="alert alert-info" role="alert">' . $file_contents_r . '</div>';
            ?>
        </div>
    </div>
</main>
</body>

</html>
