<header class=" header border-bottom shadow-sm" id="header" style="z-index: 999999;">
    <div class="header_toggle">
        <i class='bx bx-menu' id="header-toggle"></i>
    </div>
    <div class="d-flex flex gap-3 align-items-center">
        <span class="ts-uppper"><?= $profile['nama'] ?></span>
        <div class="header_img">
            <img src="<?= strpos($profile['profile_image'], 'data:image') === 0 ? $profile['profile_image'] : 'data:image/jpeg;base64,' . $profile['profile_image'] ?>"
                alt="<?= $profile["nama"] ?>">
        </div>

    </div>
</header>

<aside class="l-navbar" id="nav-bar" style="z-index: 999999;">
    <nav class="nav">
        <div>
            <a href="" class="nav_logo">
                <i class="ri-side-bar-fill nav_logo-icon"></i>
                <span class="nav_logo-name">iLalin</span>
            </a>
            <div class="nav_list">
                <a href="index.php" class="nav_link <?= $active_page == "dashboard" ? "active" : "" ?>">
                    <i class="ri-dashboard-horizontal-line nav_icon"></i>
                    <span class="nav_name">Dashboard</span>
                </a>
                <a href="profile.php" class="nav_link <?= $active_page == "users" ? "active" : "" ?>">
                    <i class="ri-user-line nav_icon"></i>
                    <span class="nav_name">Users</span>
                </a>
                <a href="#" class="nav_link <?= $active_page == "messages" ? "active" : "" ?>">
                    <i class="ri-message-2-line nav_icon"></i>
                    <span class="nav_name">Messages</span>
                </a>
                <a href="#" class="nav_link <?= $active_page == "settings" ? "active" : "" ?>">
                    <i class="ri-settings-5-line nav_icon"></i>
                    <span class="nav_name">Settings</span>
                </a>
            </div>
        </div>
        <div>

        </div>

        <div>
            <a href="../php/utils/session.destroy.php?home=../../../auth/login.php" class="nav_link">
                <i class="ri-switch-line nav_icon"></i>
                <span class="nav_name">Switch Role</span>
            </a>

            <!-- Redirect To Login Form -->
            <a href="../controller/php/utils/session.destroy.php?home=../../../auth/login.php" class="nav_link">
                <i class="ri-logout-box-line nav_icon"></i>
                <span class="nav_name">SignOut</span>
            </a>
        </div>
    </nav>
</aside>