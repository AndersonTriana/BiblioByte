<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Book</title>
</head>

<body>
    <h2>Upload Book</h2>

    <form action="/upload" method="post">
        <label for="title">Title</label>
        <input name="title" type="title" required>

        <label for="file_path">Book</label>
        <input name="file_path" type="file" accept=".pdf" required>

        <label for="cover_path">Cover</label>
        <input name="cover_path" type="file" accept=".png,.jpg">

        <label for="author">Author</label>
        <input name="author" type="author">

        <button type="submit">Upload Book</button>
    </form>
</body>

</html>