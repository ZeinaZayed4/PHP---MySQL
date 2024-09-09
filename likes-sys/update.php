<?php

require "config.php";

if (isset($_POST['id']) and isset($_POST['val'])) {
    $id = $_POST['id'];
    $val = $_POST['val'];

    $update = $conn->prepare("UPDATE `posts` SET likes = :likes WHERE id = :id");
    $update->execute([
        ':likes' => $val,
        ':id' => $id
    ]);
}
