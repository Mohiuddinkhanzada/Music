<?php
$adminPage = $adminPage ?? '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $pageTitle ?? 'Admin'; ?> — Audio Zone</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="admin-shell">
    <aside class="admin-sidebar">
      <div class="brand">
        <a href="index.php">
          <img src="assets/images/audio-zone-logo.png" alt="Audio Zone">
        </a>
      </div>
      <nav class="admin-nav">

        <div class="admin-nav-section">
          <a class="admin-nav-link<?php echo $adminPage === 'dashboard' ? ' active' : ''; ?>" href="index.php">
            <span class="nav-icon">◈</span>Dashboard
          </a>
        </div>

        <div class="admin-nav-section">
          <div class="admin-nav-section-title">Management</div>
          <?php
          $usersOpen = in_array($adminPage, ['all-users','add-user']);
          ?>
          <div class="admin-dropdown<?php echo $usersOpen ? ' open' : ''; ?>">
            <button class="admin-dropdown-toggle">
              <span class="nav-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.4-3.6 4.3-5.4 8-5.4s6.6 1.8 8 5.4"/></svg></span>Users
              <span class="dropdown-arrow">›</span>
            </button>
            <div class="admin-dropdown-menu">
              <a class="admin-nav-link<?php echo $adminPage === 'all-users' ? ' active' : ''; ?>" href="all-users.php">All Users</a>
              <a class="admin-nav-link<?php echo $adminPage === 'add-user' ? ' active' : ''; ?>" href="add-user.php">Add User</a>
            </div>
          </div>
        </div>

        <div class="admin-nav-section">
          <div class="admin-nav-section-title">Content</div>

          <?php
          $artistsOpen = in_array($adminPage, ['all-artists','add-artist']);
          $albumsOpen = in_array($adminPage, ['all-albums','add-album']);
          $genresOpen = in_array($adminPage, ['all-genres','add-genre']);
          $yearsOpen = in_array($adminPage, ['all-years','add-year']);
          $musicOpen = in_array($adminPage, ['all-music','add-music']);
          $videosOpen = in_array($adminPage, ['all-videos','add-video']);
          ?>

          <div class="admin-dropdown<?php echo $artistsOpen ? ' open' : ''; ?>">
            <button class="admin-dropdown-toggle">
              <span class="nav-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.4-3.6 4.3-5.4 8-5.4s6.6 1.8 8 5.4"/></svg></span>Artists
              <span class="dropdown-arrow">›</span>
            </button>
            <div class="admin-dropdown-menu">
              <a class="admin-nav-link<?php echo $adminPage === 'all-artists' ? ' active' : ''; ?>" href="all-artists.php">All Artists</a>
              <a class="admin-nav-link<?php echo $adminPage === 'add-artist' ? ' active' : ''; ?>" href="add-artist.php">Add Artist</a>
            </div>
          </div>

          <div class="admin-dropdown<?php echo $albumsOpen ? ' open' : ''; ?>">
            <button class="admin-dropdown-toggle">
              <span class="nav-icon">▣</span>Albums
              <span class="dropdown-arrow">›</span>
            </button>
            <div class="admin-dropdown-menu">
              <a class="admin-nav-link<?php echo $adminPage === 'all-albums' ? ' active' : ''; ?>" href="all-albums.php">All Albums</a>
              <a class="admin-nav-link<?php echo $adminPage === 'add-album' ? ' active' : ''; ?>" href="add-album.php">Add Album</a>
            </div>
          </div>

          <div class="admin-dropdown<?php echo $genresOpen ? ' open' : ''; ?>">
            <button class="admin-dropdown-toggle">
              <span class="nav-icon">◈</span>Genres
              <span class="dropdown-arrow">›</span>
            </button>
            <div class="admin-dropdown-menu">
              <a class="admin-nav-link<?php echo $adminPage === 'all-genres' ? ' active' : ''; ?>" href="all-genres.php">All Genres</a>
              <a class="admin-nav-link<?php echo $adminPage === 'add-genre' ? ' active' : ''; ?>" href="add-genre.php">Add Genre</a>
            </div>
          </div>

          <div class="admin-dropdown<?php echo $yearsOpen ? ' open' : ''; ?>">
            <button class="admin-dropdown-toggle">
              <span class="nav-icon">◷</span>Years
              <span class="dropdown-arrow">›</span>
            </button>
            <div class="admin-dropdown-menu">
              <a class="admin-nav-link<?php echo $adminPage === 'all-years' ? ' active' : ''; ?>" href="all-years.php">All Years</a>
              <a class="admin-nav-link<?php echo $adminPage === 'add-year' ? ' active' : ''; ?>" href="add-year.php">Add Year</a>
            </div>
          </div>

          <div class="admin-dropdown<?php echo $musicOpen ? ' open' : ''; ?>">
            <button class="admin-dropdown-toggle">
              <span class="nav-icon">♫</span>Music
              <span class="dropdown-arrow">›</span>
            </button>
            <div class="admin-dropdown-menu">
              <a class="admin-nav-link<?php echo $adminPage === 'all-music' ? ' active' : ''; ?>" href="all-music.php">All Music</a>
              <a class="admin-nav-link<?php echo $adminPage === 'add-music' ? ' active' : ''; ?>" href="add-music.php">Add Music</a>
            </div>
          </div>

          <div class="admin-dropdown<?php echo $videosOpen ? ' open' : ''; ?>">
            <button class="admin-dropdown-toggle">
              <span class="nav-icon">▷</span>Videos
              <span class="dropdown-arrow">›</span>
            </button>
            <div class="admin-dropdown-menu">
              <a class="admin-nav-link<?php echo $adminPage === 'all-videos' ? ' active' : ''; ?>" href="all-videos.php">All Videos</a>
              <a class="admin-nav-link<?php echo $adminPage === 'add-video' ? ' active' : ''; ?>" href="add-video.php">Add Video</a>
            </div>
          </div>
        </div>

        <div class="admin-nav-section">
          <div class="admin-nav-section-title">Community</div>
          <?php
          $reviewsOpen = $adminPage === 'all-reviews';
          ?>
          <div class="admin-dropdown<?php echo $reviewsOpen ? ' open' : ''; ?>">
            <button class="admin-dropdown-toggle">
              <span class="nav-icon">★</span>Reviews
              <span class="dropdown-arrow">›</span>
            </button>
            <div class="admin-dropdown-menu">
              <a class="admin-nav-link<?php echo $adminPage === 'all-reviews' ? ' active' : ''; ?>" href="all-reviews.php">All Reviews</a>
            </div>
          </div>
        </div>

      </nav>
      <script>
      document.querySelectorAll('.admin-dropdown-toggle').forEach(function(btn){
        btn.addEventListener('click',function(){
          this.parentElement.classList.toggle('open');
        });
      });
      </script>
    </aside>

    <main class="admin-main">
      <header class="admin-topbar">
        <h1><?php echo $pageTitle ?? 'Dashboard'; ?></h1>
        <div class="admin-topbar-right">
          <span class="admin-badge">Admin</span>
          <a class="ghost-btn" href="../home.php" target="_blank">View Site</a>
        </div>
      </header>
      <div class="admin-content">
