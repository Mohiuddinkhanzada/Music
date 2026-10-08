<?php
include_once './config.php';

$pageTitle = 'Years — Audio Zone';
$activePage = 'years';

include_once 'includes/header.php';
?>

      <section class="page">
        <div class="page-heading">
          <div>
            <div class="eyebrow">Years</div>
            <h1>Choose your era.</h1>
            <p>Browse real music and videos released inside the era you pick.</p>
          </div>
        </div>
        <div class="genre-grid">

          <?php

          $yearQuery = "SELECT year_id, year_duration, image
                        FROM years
                        WHERE year_duration IS NOT NULL AND year_duration != ''
                        ORDER BY year_id";

          $yearResult = mysqli_query($conn, $yearQuery);

          if ($yearResult && mysqli_num_rows($yearResult) > 0) {

              while ($row = mysqli_fetch_assoc($yearResult)) {

                  $eraValue = $row['year_duration'];
                  $eraLabel = htmlspecialchars(str_replace('-', '–', $eraValue));
                  $eraImage = $row['image'] ?: 'assets/images/artist-placeholder.svg';
          ?>

            <a class="genre-chip" href="era.php?era=<?= rawurlencode($eraValue); ?>">
              <img
                class="genre-art"
                src="<?= htmlspecialchars($eraImage); ?>"
                alt=""
                onerror="this.src='assets/images/artist-placeholder.svg'">
              <strong><?= $eraLabel; ?></strong><span>Browse real tracks</span>
            </a>

          <?php
              }
          } else {
          ?>

            <div class="empty">No era records found in the database.</div>

          <?php } ?>

        </div>
      </section>

<?php
include_once 'includes/footer.php';
?>
