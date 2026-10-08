<?php
include_once './config.php';

$pageTitle = 'Albums — Audio Zone';
$activePage = 'albums';

$albumQuery = "SELECT album_id, album_name, image, language, artist_name
               FROM albums
               WHERE album_name IS NOT NULL AND album_name != ''
               ORDER BY album_name";

$albumResult = mysqli_query($conn, $albumQuery);

$albumRows = [];

if ($albumResult) {
    while ($row = mysqli_fetch_assoc($albumResult)) {
        $albumRows[] = $row;
    }
}

include_once 'includes/header.php';
?>

      <section class="page">
        <div class="page-heading">
          <div>
            <div class="eyebrow">Albums</div>
            <h1>Albums &amp; collections.</h1>
            <p>
              Every album below is a real release in the library. Open one to see its music and
              videos from the database.
            </p>
          </div>
        </div>

        <div class="grid" id="albumBrowseGrid">

          <?php if (count($albumRows) > 0) { ?>

            <?php foreach ($albumRows as $album) { ?>

              <a class="album-card" href="album.php?id=<?= (int) $album['album_id']; ?>" style="text-decoration: none; color: inherit;">
                <div class="cover-wrap">
                  <img
                    src="<?= htmlspecialchars($album['image'] ?: 'assets/images/artist-placeholder.svg'); ?>"
                    alt="<?= htmlspecialchars($album['album_name']); ?>"
                    loading="lazy"
                    onerror="this.src='assets/images/artist-placeholder.svg'">
                </div>
                <div class="track-body">
                  <h3><?= htmlspecialchars($album['album_name']); ?></h3>
                  <p><?= htmlspecialchars($album['artist_name']); ?> · <?= htmlspecialchars($album['language']); ?></p>
                </div>
              </a>

            <?php } ?>

          <?php } else { ?>

            <div class="empty">No albums available yet.</div>

          <?php } ?>

        </div>
      </section>

<?php
include_once 'includes/footer.php';
?>
