<?php
if (isset($_POST['MAX_FILE_SIZE'])) {
    $tmp_file_name = $_FILES['file_upload']['tmp_name'];
    $dest_file_name = $_SERVER['DOCUMENT_ROOT'] . '/files/' . $_FILES['file_upload']['name'];
    move_uploaded_file($tmp_file_name, $dest_file_name);
}
?>

<?php
if (isset($_POST['file_delete'])) {
    if ($_POST['file_delete'] === '.htaccess') {
        return;
    }
    $file_name = $_SERVER['DOCUMENT_ROOT'] . '/files/' . $_POST['file_delete'];
    unlink($file_name);
}
?>

<?php
function startsWith($haystack, $needle)
{
    return strpos($haystack, $needle) === 0;
}

$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . '/files';
$image_dir_id = opendir($image_dir_path);

$array_files = null;
$i = 0;

while (($path_to_file = readdir($image_dir_id)) !== false) {
    if ($path_to_file !== '.' && $path_to_file !== '..' && $path_to_file !== '.htaccess') {
        $array_files[$i] = basename($path_to_file);
        $i++;
    }
}

closedir($image_dir_id);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Файли</title>
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
                <li class="nav-item"><a class="nav-link" href="email.php">Відправити повідомлення</a></li>
                <li class="nav-item"><a class="nav-link" href="photo.php">Фото</a></li>
                <li class="nav-item active"><a class="nav-link" href="files.php">Файли <span
                                class="sr-only">(відкрито)</span></a></li>
                <li class="nav-item"><a class="nav-link" href="inform.php">Інформація</a></li>
            </ul>
        </div>
        <form class="form-inline" action="search.php" method="get">
            <label>
                <input type="text" class="form-control mb-2 mr-sm-2" name="usersearch" placeholder="Що будемо шукати?">
            </label>
            <button type="submit" class="btn btn-primary mb-2">Знайти</button>
        </form>
    </nav>
</header>
<main>
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <form name="file_upload" action="files.php" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000"/>
                    <div class="custom-file my-2">
                        <input type="file" class="custom-file-input" id="photoInput"
                               name="file_upload">
                        <label class="custom-file-label" for="photoInput">Обрати файл</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Відправити</button>
                </form>
            </div>
            <div class="row">
                <table class="table my-2">
                    <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Photo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $array_files_count = count($array_files);
                    if ($array_files_count) {
                        echo '<hr/>';
                        sort($array_files);
                        for ($i = 0; $i < $array_files_count; $i++) {
                            ?>
                            <tr>
                                <th scope='row'><?php echo $i + 1 ?></th>
                                <td><p><a href='/files/<?php echo $array_files[$i] ?>'
                                          target='_blank'><?php echo $array_files[$i] ?></a></p>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <hr/>
            </div>
            <div class='row'>
                <form name='file_delete' action='files.php' method='post' enctype="application/x-www-form-urlencoded">
                    <label>
                        <div class='input-group mb-3'>
                            <div class='input-group-prepend'>
                                <label class='input-group-text' for='deleteSelect'>Файл</label>
                            </div>
                            <select class='custom-select' name='file_delete' size='1' id='deleteSelect'>
                                <?php
                                for ($i = 0; $i < $array_files_count; $i++) {
                                    echo "<option>$array_files[$i]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </label>
                    <input class='btn btn-primary' type='submit' name='submit' value='Удалить'/>
                </form>
            </div>
        </div>
    </div>
</main>
</body>

</html>