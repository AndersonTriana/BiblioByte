<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <title>Home</title>
</head>

<body>
    <div class="app">
        <?php require "../views/Components/Nav.php" ?>

        <div class="search-bar">
            <img class="search-icon" src="/imgs/search.svg" alt="">
            <input class="search" name="search" type="text" placeholder="Titles, authors, or topics">
        </div>

        <main class="home">
            <?php if ($books["books"] ?? false) :
                foreach ($books["books"] as $book) : ?>
                    <article class="book book-card">
                        <a href="<?= "/book/{$book->get_id()}"; ?>">
                            <img class="cover" src="<?php echo $book->get_cover_path() != '' ? $book->get_cover_path() : "/imgs/default_cover.png" ?>" alt="Cover <?= $book->get_title(); ?>" sizes="40,40">
                        </a>

                        <h2 class="title"><?= $book->get_title(); ?></h2>

                        <p class="author">
                            <?= $book->get_author() != "" ? $book->get_author() : "Unknown"; ?>
                        </p>

                    </article>

                <?php endforeach; ?>

            <?php else : ?>

                <h2><?= $books["message"] ?></h2>

            <?php endif; ?>
        </main>
    </div>
</body>

</html>