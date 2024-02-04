<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="/imgs/favicon.svg">
    <title>Upload Book</title>
</head>

<body>
    <div class="app">
        <?php require "../views/Components/Nav.php" ?>

        <h2>Upload Book</h2>

        <div class="form">
            <form action="/upload" method="post" enctype="multipart/form-data">
                <label for="title">Title</label>
                <input id="title" name="title" type="title" value="<?php if (isset($_POST["title"])) echo $_POST["title"];  ?>" required>

                <label for="book">Book</label>
                <label for="book" class="file book-file">Select the book file</label>
                <input id="book" name="book" type="file" accept=".pdf" value="<?php if (isset($_POST["book"])) echo $_POST["book"];  ?>" required>

                <label for="cover">Cover</label>
                <label for="cover" class="file cover-file">Select the cover file</label>
                <input id="cover" name="cover" type="file" accept=".png,.jpg" value="<?php if (isset($_POST["cover"])) echo $_POST["cover"];  ?>">

                <label for="author">Author</label>
                <input id="author" name="author" type="author" value="<?php if (isset($_POST["author"])) echo $_POST["author"];  ?>">

                <button type="submit">Upload Book</button>
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

            input.previousElementSibling.classList.add("error");

            error_element = document.createElement("p");
            error_element.classList.add("error");
            error_element.innerText = error.message;

            input.insertAdjacentElement('afterend', error_element);
        }
    <?php endif; ?>

    // Show file name on inputs
    for (let input of document.querySelectorAll("input[type='file']")) {
        input.addEventListener("change", () => {
            console.log(input.files[0]);

            let max_name_size = 25;
            let file_name = input.files[0].name;

            if (file_name.length > max_name_size) {
                file_name = file_name.slice(0, max_name_size) + "...";
            }

            input.previousElementSibling.textContent = file_name;
        });
    }
</script>

</html>