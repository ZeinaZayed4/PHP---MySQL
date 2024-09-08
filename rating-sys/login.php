`<?php
require "includes/header.php";
require "config.php";

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    if ($_POST['email'] == '' or $_POST['password'] == '') {
        echo "A field is missing";
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            if (password_verify($password, $data['mypassword'])) {
                $_SESSION['username'] = $data['username'];
                $_SESSION['user_id'] = $data['id'];
                $_SESSION['email'] = $data['email'];
                header("Location: index.php");
            } else {
                echo "Email or password is wrong";
            }
        } else {
            echo "Email or password is wrong";
        }
    }
}
?>

<main class="form-signin w-50 m-auto">
    <form method="post" action="login.php">
        <h1 class="h3 mt-5 fw-normal text-center">Sign in</h1>

        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Sign in</button>
        <h6 class="mt-3">Don't have an account  <a href="register.php">Create your account</a></h6>
    </form>
</main>
<?php require "includes/footer.php"; ?>
