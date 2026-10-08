<?php
include_once './config.php';

$pageTitle = 'Artists — Audio Zone';
$activePage = 'artists';

include_once 'includes/header.php';
?>

      <section class="page">
        <div class="page-heading">
          <div>
            <div class="eyebrow">Artists</div>
            <h1>Select your favorite artist.</h1>
            <p>
              Artists are grouped by the languages they actually release in, sorted by followers.
              Open any profile to enjoy their music and videos.
            </p>
          </div>
        </div>

        <?php

        $langQuery = "SELECT DISTINCT albums.language AS lang
                      FROM artists
                      JOIN albums ON artists.artist_name = albums.artist_name
                      WHERE albums.language IS NOT NULL AND albums.language != ''
                      ORDER BY albums.language";

        $langResult = mysqli_query($conn, $langQuery);

        $hasRows = false;

        while ($lang = mysqli_fetch_assoc($langResult)) {

            $language = $lang['lang'];
            $safeLanguage = mysqli_real_escape_string($conn, $language);

            $artistQuery = "SELECT artists.*
                            FROM artists
                            JOIN albums ON artists.artist_name = albums.artist_name
                            WHERE albums.language = '$safeLanguage'
                            GROUP BY artists.artist_id
                            ORDER BY
                                CASE
                                    WHEN artists.followers LIKE '%M' OR artists.followers LIKE '%m'
                                        THEN CAST(REPLACE(REPLACE(artists.followers, 'M', ''), 'm', '') AS DECIMAL(20,2)) * 1000000
                                    WHEN artists.followers LIKE '%K' OR artists.followers LIKE '%k'
                                        THEN CAST(REPLACE(REPLACE(artists.followers, 'K', ''), 'k', '') AS DECIMAL(20,2)) * 1000
                                    ELSE CAST(REPLACE(REPLACE(artists.followers, 'M', ''), 'm', '') AS DECIMAL(20,2))
                                END DESC";

            $artistResult = mysqli_query($conn, $artistQuery);

            if (!$artistResult || mysqli_num_rows($artistResult) === 0) continue;

            $hasRows = true;
            ?>

            <div class="section-head">
              <div>
                <h3 class="artist-row-title"><?= htmlspecialchars($language); ?></h3>
              </div>
            </div>

            <div class="grid artist-grid">

              <?php while ($artist = mysqli_fetch_assoc($artistResult)) { ?>

                <article class="artist-card">
                  <a href="artist.php?id=<?= (int) $artist['artist_id']; ?>" style="text-decoration: none; color: inherit;">
                    <div class="artist-image-wrap">
                      <img
                        src="<?= htmlspecialchars($artist['image'] ?: 'assets/images/artist-placeholder.svg'); ?>"
                        alt="<?= htmlspecialchars($artist['artist_name']); ?>"
                        loading="lazy"
                        onerror="this.src='assets/images/artist-placeholder.svg'">
                    </div>
                    <div class="artist-card-meta">
                      <h3><?= htmlspecialchars($artist['artist_name']); ?></h3>
                      <p><?= htmlspecialchars($artist['followers']); ?> followers</p>
                    </div>
                  </a>
                </article>

              <?php } ?>

            </div>

        <?php } ?>

        <?php if (!$hasRows) { ?>
          <div class="empty">No artists available.</div>
        <?php } ?>
      </section>

<?php
include_once 'includes/footer.php';
?>
