<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - <?= $book->get_title(); ?></title>
</head>

<body>
    <?php require "../views/Components/Nav.php" ?>

    <img src="<?= $book->get_file_path(); ?>" alt="Cover <?= $book->get_title(); ?>" sizes="40,40">

    <h2><?= $book->get_title(); ?></h2>

    <?php if ($book->get_author()) : ?>
        <p><?= $book->get_author(); ?></p>
    <?php endif; ?>

    <h2>Upload Book</h2>

    <form action="/edit" method="post">
        <input name="id" value="<?= $book->get_id(); ?>" hidden>

        <label for="title">Title</label>
        <input name="title" type="text" required>

        <label for="file_path">Book</label>
        <input name="file_path" type="file" accept=".pdf" required>

        <label for="cover_path">Cover</label>
        <input name="cover_path" type="file" accept=".png,.jpg">

        <label for="author">Author</label>
        <input name="author" type="text">

        <button type="submit">Edit Book</button>
    </form>
</body>

</html>