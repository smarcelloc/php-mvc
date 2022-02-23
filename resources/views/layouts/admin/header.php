<header>
    <div class="py-3 bg-warning text-black">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="<?= APP_URL . '/admin' ?>" class="h3 d-flex align-items-center my-2 my-lg-0 me-lg-auto text-black text-decoration-none">
                    <?= APP_NAME ?> | ADMIN
                </a>

                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    <li class="my-auto">
                        <a href="<?= APP_URL . '/admin' ?>" class="nav-link text-black">
                            Home
                        </a>
                    </li>

                    <li class="my-auto">
                        <a href="<?= APP_URL .  '/admin/testimonials' ?>" class="nav-link text-black">
                            Testimonials
                        </a>
                    </li>

                    <li class="my-auto">
                        <a href="<?= APP_URL .  '/admin/users' ?>" class="nav-link text-black">
                            Users
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>