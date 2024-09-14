<?php $page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); ?>

<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
    <div class="container">
        <a class="navbar-brand" href="index.php">iLalin<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
            aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item <?= $page == 'index.php' ? 'active':''; ?>">
                    <a class="nav-link" href="index.php">Beranda</a>
                </li>
                <li class="nav-item <?= $page == 'tentang.php' ? 'active':''; ?>">
                    <a class="nav-link" href="tentang.php">Tentang</a>
                </li>
                <li class="nav-item <?= $page == 'layanan.php' ? 'active':''; ?>">
                    <a class=" nav-link" href="layanan.php">Layanan</a>
                </li>
                <li class="nav-item <?= $page == 'mitra.php' ? 'active':''; ?>"><a class="nav-link"
                        href="mitra.php">Mitra</a>
                </li>
            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <li>
                    <a class="nav-link" href="auth/login.php"><img src="images/user.svg" /></a>
                </li>
                <li>
                    <a class="nav-link" href="mulai/rute.php"><i class="ri-route-fill text-yellow fs-2"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>