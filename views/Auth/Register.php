<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <title>Register</title>
</head>

<body>
    <div class="app">
        <?php require "../views/Components/Nav.php" ?>

        <div class="form">
            <h1>Register</h1>

            <form action="/register" method="post">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" value="<?php if (isset($_POST["username"])) echo $_POST["username"];  ?>" autocomplete="name" required>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"];  ?>" autocomplete="email" required>

                <label for="password">Password</label>
                <input id="password" name="password" type="password" value="<?php if (isset($_POST["password"])) echo $_POST["password"];  ?>" autocomplete="current-password" required>

                <button type="submit">Register</button>
            </form>
        </div>
    </div>
</body>

<script>
    // Styling form errors
    <?php if ($error ?? null) : ?>
        let error = <?= json_encode($error) ?? null ?>;

        if (error) {
            let input = document.getElementById(error.input);
            input.classList.add("error");

            error_element = document.createElement("p");
            error_element.classList.add("error");
            error_element.innerText = error.message;

            input.insertAdjacentElement('afterend', error_element);
        }
    <?php endif; ?>
</script>

</html>