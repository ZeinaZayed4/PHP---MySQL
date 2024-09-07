<?php
require 'config.php';
require 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    if ($_POST['title'] == '' or $_POST['body'] == '') {
        echo "A field is missing";
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $username = $_SESSION['username'];

        $insert = $conn->prepare("INSERT INTO `posts` (title, body, username) 
                    VALUES (:title, :body, :username)");
        $insert->execute([
            ':title' => $title,
            ':body' => $body,
            ':username' => $username
        ]);
        header("Location: index.php");
    }
}
?>

<main class="form-signin w-50 m-auto">
    <form action="create.php" method="POST">
        <h1 class="h3 mt-5 fw-normal text-center">Create Post</h1>
        <div class="form-floating">
            <input name="title" type="text" class="form-control" id="floatingInput" placeholder="title">
            <label for="floatingInput">Title</label>
        </div>

        <div class="form-floating mt-4">
            <textarea name="body" rows="9" placeholder="body" class="form-control"></textarea>
            <label for="floatingPassword">Body</label>
        </div>
        <button name="submit" class="w-100 btn btn-lg btn-primary mt-4" type="submit">Create Post</button>
    </form>
</main>

<?php
require 'includes/footer.php';
?>
