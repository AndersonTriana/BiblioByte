<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>

    <div>
        <label for="search">Search</label>
        <input name="search" type="text">
    </div>

    <?php if ($books["books"] ?? false) :
        foreach ($books["books"] as $book) :
            ?>
            
            <a href="<?= "/book/{$book->get_id()}"; ?>">
            <img src="<?= $book->get_file_path(); ?>" alt="Cover <?= $book->get_title(); ?>" sizes="40,40">
            </a>
            <h2><?= $book->get_title(); ?></h2>
            
            <?php if ($book->get_author()) : ?>
                <p><?= $book->get_author(); ?></p>
            <?php endif; ?>

            <?php endforeach; ?>
            
            <?php else : ?>
                
                
        <h2><?= $books["message"] ?></h2>

    <?php endif; ?>
</body>

</html>