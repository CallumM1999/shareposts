<nav class="navbar navbar-expand-lg mb-3 navbar-dark bg-dark">
   <div class="container">
        <a class="navbar-brand" href="<?= URLROOT ?>"><?= SITENAME ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= URLROOT ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= URLROOT ?>/pages/about">About</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user_name'])): ?>

                    <li class="nav-item">
                        <a class="nav-link">Welcome <?= $_SESSION['user_name'] ?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT ?>/users/logout">Logout</a>
                    </li>

                <?php else: ?>

                    <li class="nav-item active">
                        <a class="nav-link" href="<?= URLROOT ?>/users/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= URLROOT ?>/users/login">Login</a>
                    </li>

                <?php endif; ?>


                
            </ul>
        </div>
   </div>
</nav>
