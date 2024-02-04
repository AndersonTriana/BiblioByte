<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <title>Login</title>
</head>

<body>
    <div class="app">
        <?php require "../views/Components/Nav.php" ?>

        <div class="form">
            <h1>Please sign in</h1>

            <form id="login-form" action="/login" method="post">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" autocomplete="email" required>

                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required>

                <div class="button-group">
                    <a class="button secondary" href="/register">Create account</a>
                    <button type="submit" form="login-form">Sign Up</button>
                </div>
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