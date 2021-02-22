<?php

if (isset($_GET['comment'])) {
    $rawComment = $_GET['comment'];

    require_once("connections/pis_blog.php");
    $commentId = mysqli_real_escape_string($connection, $rawComment);

    $selected = mysqli_query($connection, "SELECT * FROM comments WHERE id = $commentId");
    if (mysqli_num_rows($selected) < 1) {
        die('Comment not found!');
    }

    $row = mysqli_fetch_array($selected, MYSQLI_ASSOC);
    mysqli_query($connection, "DELETE FROM comments WHERE id = $commentId");
    mysqli_close($connection);

    header("Location: comments.php?note=".$row['art_id']);
    die();
}

die('Comment not found!');
