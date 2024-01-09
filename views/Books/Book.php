<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Book</title>
</head>

<body>
    <h2>Upload Book</h2>

    <img src="<?= $book->get_file_path(); ?>" alt="Cover <?= $book->get_title(); ?>" sizes="40,40">

    <h2><?= $book->get_title(); ?></h2>

    <?php if ($book->get_author()): ?>
        <p><?= $book->get_author(); ?></p>
    <?php endif; ?>
    
    <button>Read</button>
    <button>Edit</button>
    <button>Delete</button>
</body>

</html>