<?php
// Obtener la URL actual
$currentUrl = $_SERVER['REQUEST_URI'];
?>

<?php if ($currentUrl == "/login" || $currentUrl == "/") : ?>
    <nav>
        <a href="/home">
            <img class="main-logo" src="/imgs/logo.svg" height="40px" alt="bibliotyte logo">
        </a>
    </nav>

<?php elseif ($currentUrl == "/register") : ?>
    <nav>
        <a href="/home">
            <img class="main-logo" src="/imgs/logo.svg" height="40px" alt="bibliotyte logo">
        </a>
        <a href="/login">
            <img src="/imgs/exit.svg" alt="return to login icon">
        </a>
    </nav>

<?php elseif ($_SESSION["user_id"] ?? null) : ?>
    <?php if ($_SERVER["REQUEST_URI"] == "/home") : ?>
        <nav>
            <a href="/home">
                <img class="main-logo" src="/imgs/logo.svg" height="40px" alt="bibliotyte logo">
            </a>


            <img class="nav-button" src="/imgs/menu.svg" alt="">

            <div class="context-menu hidden">
                <a class="button" href="/upload">Upload</a>

                <a class="button" href="/logout">Logout</a>
            </div>
        </nav>

        <script>
            document.addEventListener("click", () => {
                const menu = document.getElementsByClassName("context-menu")[0];

                if (!menu.classList.contains("hidden")) {
                    menu.classList.add("hidden");
                    menu.previousElementSibling.classList.remove("clicked");
                }
            });

            document.getElementsByClassName("nav-button")[0].addEventListener("click", e => {
                e.stopPropagation();
                const menu = e.target.nextElementSibling;

                if (menu.classList.contains("hidden")) {
                    const buttonX = e.target.getBoundingClientRect().x;
                    const menuWidth = menu.getBoundingClientRect().width;

                    menu.classList.remove("hidden");
                    menu.style.left = `${buttonX - menuWidth * 0.75}px`;
                    e.target.classList.add("clicked");
                } else {
                    menu.classList.add("hidden");
                    e.target.classList.remove("clicked");
                }
            });

            window.addEventListener("resize", (e) => {
                const menu = document.getElementsByClassName("context-menu")[0];
                const button = document.getElementsByClassName("nav-button")[0];
                const buttonX = button.getBoundingClientRect().x;
                const menuWidth = menu.getBoundingClientRect().width;

                if (!menu.classList.contains("hidden")) {
                    menu.style.left = `${buttonX - menuWidth * 0.75}px`;
                    console.log(menu.style);
                }
            });
        </script>

    <?php elseif (str_contains($_SERVER["REQUEST_URI"], "/book")) : ?>
        <nav>
            <a href="/home">
                <img class="main-logo" src="/imgs/logo.svg" height="40px" alt="bibliotyte logo">
            </a>

            <a href="/home">
                <img src="/imgs/exit.svg" alt="back to home icon">
            </a>
        </nav>
    <?php elseif (str_contains($_SERVER["REQUEST_URI"], "/edit")) : ?>
        <nav>
            <a href="/home">
                <img class="main-logo" src="/imgs/logo.svg" height="40px" alt="bibliotyte logo">
            </a>

            <a href="/book/<?= $book->get_id() ?>">
                <img src="/imgs/exit.svg" alt="back to home icon">
            </a>
        </nav>
    <?php elseif (str_contains($_SERVER["REQUEST_URI"], "/upload")) : ?>
        <nav>
            <a href="/home">
                <img class="main-logo" src="/imgs/logo.svg" height="40px" alt="bibliotyte logo">
            </a>

            <a href="/home">
                <img src="/imgs/exit.svg" alt="back to home icon">
            </a>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Sora&display=swap');
</style>