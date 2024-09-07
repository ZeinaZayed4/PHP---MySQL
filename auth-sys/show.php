<?php
require 'config.php';
require 'includes/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $onePost = $conn->query("SELECT * FROM `posts` WHERE id = '$id'");
    $onePost->execute();

    $posts = $onePost->fetch(PDO::FETCH_OBJ);
}

$comments = $conn->query("SELECT * FROM `comments` WHERE post_id = '$id'");
$comments->execute();

$comment = $comments->fetchAll(PDO::FETCH_OBJ);

?>

<div class="row">
    <div class="card mt-5">
        <div class="card-body">
            <h5 class="card-title"><?= $posts->title; ?></h5>
            <p class="card-text"><?= $posts->body; ?></p>
        </div>
    </div>
</div>

<div class="row">
    <form action="" method="POST" id="comment_data">
        <div class="form-floating">
            <input name="username" type="hidden" value="<?php echo $_SESSION['username']; ?>" class="form-control" id="username">
        </div>

        <div class="form-floating">
            <input name="post_id" type="hidden" value="<?php echo $posts->id; ?>" class="form-control" id="post_id">
        </div>

        <div class="form-floating mt-4">
            <textarea name="comment" rows="9" placeholder="body" class="form-control" id="comment"></textarea>
            <label for="floatingPassword">Comment</label>
        </div>
        <button name="submit" id="submit" class="w-100 btn btn-lg btn-primary mt-4" type="submit">Create Comment</button>
    </form>
    <div id="msg" class="nothing"></div>
    <div id="delete-msg" class="nothing"></div>
</div>

<div class="row">
    <?php foreach ($comment as $singleComment) : ?>
    <div class="card mt-2 mb-2">
        <div class="card-body">
            <h5 class="card-title"><?= $singleComment->username; ?></h5>
            <p class="card-text"><?= $singleComment->comment; ?></p>
            <?php if((isset($_SESSION['username'])) and $_SESSION['username'] == $singleComment->username) : ?>
            <button class="delete-btn btn btn-danger" value="<?= $singleComment->id; ?>">Delete</button>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require 'includes/footer.php'; ?>
<script>
    $(document).ready(function() {
        $(document).on('submit', '#comment_data', function (e) {
            e.preventDefault();
            var formData = $("#comment_data").serialize() + '&submit=submit';
            $.ajax({
                type: 'post',
                url: 'insert-comments.php',
                data: formData,
                success: function(response) {
                    $("#comment").val('');
                    $("#username").val('');
                    $("#post_id").val('');

                    $("#msg").html("Added Successfully").toggleClass("alert alert-success bg-success text-white mt-3");
                    fetch();
                }
            });
        });

        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var id = $(this).val(); // Get the comment ID
            $.ajax({
                type: 'post',
                url: 'delete-comments.php',
                data: {
                    delete: 'delete',
                    id: id
                },
                success: function(response) {
                    $("#delete-msg").html("Deleted Successfully").toggleClass("alert alert-success bg-success text-white mt-3");
                    fetch();
                }
            });
        });
        function fetch() {
            $("body").load("show.php?id=<?= $_GET['id'] ?>");
        }
    });

</script>
