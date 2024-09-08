<?php
require "includes/header.php";
require 'config.php';

$select = $conn->query("SELECT * FROM `posts`");
$select->execute();
$rows = $select->fetchAll(PDO::FETCH_OBJ);
?>

<main class="form-signin w-50 m-auto mt-5">
    <?php foreach ($rows as $row) : ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $row->title; ?></h5>
                <p class="card-text"><?= substr($row->body, 0, 100) . '.......'; ?></p>
                <a href="show.php?id=<?= $row->id; ?>" class="btn btn-primary">More..</a>
            </div>
    <?php endforeach; ?>
        </div>

</main>
<?php require "includes/footer.php"; ?>
