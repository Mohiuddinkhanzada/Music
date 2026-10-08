<?php
include_once './config.php';

$pageTitle = 'Genres — Audio Zone';
$activePage = 'genres';

include_once 'includes/header.php';
?>

      <section class="page">
        <div class="page-heading">
          <div>
            <div class="eyebrow">Genres</div>
            <h1>Browse by genre.</h1>
            <p>
              Every genre below is a real record from the database. Pick a genre to see its music
              and videos.
            </p>
          </div>
        </div>
        <div class="genre-grid">

          <?php

          $genreQuery = "SELECT genre_id, genre_name, image
                         FROM genre
                         WHERE genre_name IS NOT NULL AND genre_name != ''
                         ORDER BY genre_id ASC";

          $genreResult = mysqli_query($conn, $genreQuery);

          if ($genreResult && mysqli_num_rows($genreResult) > 0) {

              while ($genre = mysqli_fetch_assoc($genreResult)) {

                  $genreName = $genre['genre_name'];
                  $genreImage = $genre['image'] ?: 'assets/images/artist-placeholder.svg';
          ?>

            <a class="genre-chip" href="genre.php?genre=<?= rawurlencode($genreName); ?>">
              <img
                class="genre-art"
                src="<?= htmlspecialchars($genreImage); ?>"
                alt=""
                onerror="this.src='assets/images/artist-placeholder.svg'">
              <strong><?= htmlspecialchars($genreName); ?></strong><span>All languages</span>
            </a>

          <?php
              }
          } else {
          ?>

            <div class="empty">No genre records found in the database.</div>

          <?php } ?>

        </div>
      </section>

<?php
include_once 'includes/footer.php';
?>
