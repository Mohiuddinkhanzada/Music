<?php

$pageTitle = $pageTitle ?? 'Audio Zone';
$bodyClass = $bodyClass ?? '';
$activePage = $activePage ?? '';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
$userImage = $_SESSION['user_image'] ?? '';

if ($userImage != '') {

    if (strpos($userImage, 'assets/') === 0) {
        $profileImage = $userImage;
    } else {
        $profileImage = 'assets/images/users/' . $userImage;
    }

} else {

    $profileImage = 'assets/images/artist-placeholder.svg';
}

?>

<!doctype html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1">

  <title><?php echo $pageTitle; ?></title>

  <link
    rel="stylesheet"
    href="assets/style.css?v=2">

  <script
    src="admin/assets/data.js"
    defer>
  </script>

  <script
    src="admin/assets/app.js"
    defer>
  </script>

  <script>
    window.isLoggedIn =
    <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
  </script>

</head>

<body<?php if ($bodyClass): ?> class="<?php echo $bodyClass; ?>"<?php endif; ?>>

  <div class="shell">

    <aside class="sidebar">

      <div class="brand">

        <a href="home.php">

          <img
            src="assets/images/audio-zone-logo.png"
            alt="Audio Zone">

        </a>

      </div>

      <div class="nav-title">
        Explore
      </div>

      <nav class="nav">

        <a<?php echo $activePage === 'home' ? ' class="active"' : ''; ?>
          href="home.php">

          <span class="nav-icon">⌂</span>
          Home

        </a>

        <a<?php echo $activePage === 'artists' ? ' class="active"' : ''; ?>
          href="artists.php">

          <span class="nav-icon">

            <svg
              viewBox="0 0 24 24"
              width="14"
              height="14"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              aria-hidden="true">

              <circle
                cx="12"
                cy="8"
                r="4"/>

              <path
                d="M4 21c1.4-3.6 4.3-5.4 8-5.4s6.6 1.8 8 5.4"/>

            </svg>

          </span>

          Artists

        </a>

        <a<?php echo $activePage === 'music' ? ' class="active"' : ''; ?>
          href="music.php">

          <span class="nav-icon">♫</span>
          Music

        </a>

        <a<?php echo $activePage === 'videos' ? ' class="active"' : ''; ?>
          href="videos.php">

          <span class="nav-icon">▷</span>
          Videos

        </a>

        <a<?php echo $activePage === 'genres' ? ' class="active"' : ''; ?>
          href="genres.php">

          <span class="nav-icon">◈</span>
          Genres

        </a>

        <a<?php echo $activePage === 'albums' ? ' class="active"' : ''; ?>
          href="albums.php">

          <span class="nav-icon">▣</span>
          Albums

        </a>

        <a<?php echo $activePage === 'years' ? ' class="active"' : ''; ?>
          href="years.php">

          <span class="nav-icon">◷</span>
          Years

        </a>

        <a<?php echo $activePage === 'register' ? ' class="active"' : ''; ?>
          href="register.php">

          <span class="nav-icon">＋</span>
          Register

        </a>

      </nav>

    </aside>

    <main class="main">

      <header class="topbar">

        <button
          class="circle-btn mobile-menu"
          aria-label="Open menu">

          ☰

        </button>

        <div
          class="top-actions"
          style="margin-left:auto; display:flex; align-items:center; gap:12px;">

          <?php if ($isLoggedIn): ?>

            <div
              style="position:relative;">

              <button
                type="button"
                onclick="
                  var menu = document.getElementById('profileMenu');
                  if (menu.style.display == 'block') {
                      menu.style.display = 'none';
                  } else {
                      menu.style.display = 'block';
                  }
                "
                style="
                  border:none;
                  background:none;
                  padding:0;
                  margin:0;
                  cursor:pointer;
                ">

                <img
                  src="<?php echo htmlspecialchars($profileImage); ?>"
                  alt="Profile"
                  style="
                    width:40px;
                    height:40px;
                    border-radius:50%;
                    object-fit:cover;
                    display:block;
                  ">

              </button>


              <div
                id="profileMenu"
                style="
                  display:none;
                  position:absolute;
                  right:0;
                  top:50px;
                  width:150px;
                  background:#171717;
                  border:1px solid rgba(255,255,255,.12);
                  border-radius:12px;
                  padding:14px;
                  text-align:center;
                  z-index:1000;
                  box-shadow:0 12px 30px rgba(0,0,0,.35);
                ">

                <img
                  src="<?php echo htmlspecialchars($profileImage); ?>"
                  alt="Profile"
                  style="
                    width:52px;
                    height:52px;
                    border-radius:50%;
                    object-fit:cover;
                    display:block;
                    margin:0 auto 8px;
                  ">

                <div
                  style="
                    color:#fff;
                    font-size:14px;
                    font-weight:600;
                    margin-bottom:10px;
                  ">

                  <?php echo htmlspecialchars($userName); ?>

                </div>

                <a
                  href="edit-profile.php"
                  class="ghost-btn"
                  style="
                    display:block;
                    width:100%;
                    text-decoration:none;
                    text-align:center;
                  ">

                  Edit

                </a>

              </div>

            </div>


            <a
              class="ghost-btn"
              href="logout.php"
              style="
                color:#1ed760;
                border-color:#1ed760;
              ">

              Logout

            </a>


          <?php else: ?>

            <a
              class="ghost-btn"
              href="register.php">

              Create account

            </a>

            <a
              class="gold-btn"
              href="login.php"
              id="topbarLoginBtn">

              Login

            </a>

          <?php endif; ?>

        </div>

      </header>