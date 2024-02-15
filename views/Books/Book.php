<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.svg">
    <title><?= $book->get_title(); ?></title>
</head>

<body>
    <div class="app">
        <?php require "../views/Components/Nav.php" ?>

        <article class="book">
            <div class="info">
                <img class="cover" src="<?= $cover_uri ?? "/imgs/default_cover.png"; ?>" alt="Cover <?= $book->get_title(); ?>" sizes="40,40">

                <h2 class="title"><?= $book->get_title(); ?></h2>

                <p class="author">
                    <?= $book->get_author() != "" ? $book->get_author() : "Unknown"; ?>
                </p>
            </div>

            <div class="button-group vertical">
                <a id="read" class="button" href="/read/<?= $book->get_id() ?>">Read</a>
                <a class="button" href="<?= "/edit/{$book->get_id()}" ?>">Edit</a>
                <button id="delete" class="accent">Delete</button>
            </div>
        </article>
    </div>

</body>

<script>
    const deleteButton = document.getElementById("delete");
    deleteButton.addEventListener("click", () => {
        if (confirm("¿Are you sure to delete?")) {
            form = document.createElement("form");
            form.action = "/delete/<?= $book->get_id() ?>";
            form.method = "POST";

            document.body.appendChild(form);

            form.submit();
        }
    });

    const readButton = document.getElementById("read");
    deleteButton.addEventListener("click", () => {
        if (confirm("¿Are you sure to delete?")) {
            form = document.createElement("form");
            form.action = "/delete/<?= $book->get_id() ?>";
            form.method = "POST";

            document.body.appendChild(form);

            form.submit();
        }
    });
</script>

</html>