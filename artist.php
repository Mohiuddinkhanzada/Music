<?php

include_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: artists.php');
    exit();
}


$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;


$artistQuery = "SELECT *
                FROM artists
                WHERE artist_id = $id
                LIMIT 1";

$artistResult = mysqli_query($conn, $artistQuery);

if (!$artistResult || mysqli_num_rows($artistResult) === 0) {
    header('Location: artists.php');
    exit();
}

$artist = mysqli_fetch_assoc($artistResult);

$artistName = mysqli_real_escape_string($conn, $artist['artist_name']);


$albumQuery = "SELECT album_id, album_name, image, language, artist_name
               FROM albums
               WHERE artist_name = '$artistName'
               ORDER BY album_name";

$albumResult = mysqli_query($conn, $albumQuery);


$ratedMusicIds = [];

if ($userId > 0) {

    $ratedMusicQuery = "
        SELECT review_item
        FROM reviews
        WHERE user_id = $userId
          AND item_type = 'music'
    ";

    $ratedMusicResult = mysqli_query($conn, $ratedMusicQuery);

    if ($ratedMusicResult) {
        while ($ratedRow = mysqli_fetch_assoc($ratedMusicResult)) {
            $ratedMusicIds[(int) $ratedRow['review_item']] = true;
        }
    }
}


$ratedVideoIds = [];

if ($userId > 0) {

    $ratedVideoQuery = "
        SELECT review_item
        FROM reviews
        WHERE user_id = $userId
          AND item_type = 'video'
    ";

    $ratedVideoResult = mysqli_query($conn, $ratedVideoQuery);

    if ($ratedVideoResult) {
        while ($ratedRow = mysqli_fetch_assoc($ratedVideoResult)) {
            $ratedVideoIds[(int) $ratedRow['review_item']] = true;
        }
    }
}

$pageTitle = 'Artist — Audio Zone';
$activePage = 'artists';

include_once 'includes/header.php';

?>

<section class="page">

    <div class="profile">

        <img
            class="profile-image"
            src="<?= htmlspecialchars($artist['image'] ?: 'assets/images/artist-placeholder.svg'); ?>"
            alt="<?= htmlspecialchars($artist['artist_name']); ?>"
            onerror="this.src='assets/images/artist-placeholder.svg'"
        >

        <div>

            <div class="eyebrow">Artist</div>

            <h1>
                <?= htmlspecialchars($artist['artist_name']); ?>
            </h1>

            <p>
                <?= htmlspecialchars($artist['followers']); ?> followers
            </p>

        </div>

    </div>

    <?php if (!$albumResult || mysqli_num_rows($albumResult) === 0) { ?>

        <div class="empty">
            No albums available for this artist.
        </div>

    <?php } else { ?>

        <?php while ($album = mysqli_fetch_assoc($albumResult)) { ?>

            <?php

            $albumId = (int) $album['album_id'];

            
            $musicQuery = "SELECT music.*,
                                  genre.genre_name,
                                  years.year_duration,
                                  albums.language
                           FROM music
                           JOIN albums ON music.album_id = albums.album_id
                           JOIN genre ON music.genre_id = genre.genre_id
                           JOIN years ON music.year_id = years.year_id
                           WHERE albums.album_id = $albumId
                           ORDER BY music.music_id DESC";

            $musicResult = mysqli_query($conn, $musicQuery);
            $musicCount = ($musicResult) ? mysqli_num_rows($musicResult) : 0;

            
            $videoQuery = "SELECT videos.*,
                                  genre.genre_name,
                                  years.year_duration,
                                  albums.language
                           FROM videos
                           JOIN albums ON videos.album_id = albums.album_id
                           JOIN genre ON videos.genre_id = genre.genre_id
                           JOIN years ON videos.year_id = years.year_id
                           WHERE albums.album_id = $albumId
                           ORDER BY videos.video_id DESC";

            $videoResult = mysqli_query($conn, $videoQuery);
            $videoCount = ($videoResult) ? mysqli_num_rows($videoResult) : 0;

            ?>

            <div class="album-block">

                <div class="section-head">

                    <div>

                        <h2>
                            <a
                                class="album-block-link"
                                href="album.php?id=<?= $albumId; ?>"
                            >
                                <?= htmlspecialchars($album['album_name']); ?>
                            </a>
                        </h2>

                        <p>
                            <?= htmlspecialchars($album['artist_name']); ?>
                            ·
                            <?= htmlspecialchars($album['language']); ?>
                            —
                            <?= $musicCount; ?> track<?= $musicCount === 1 ? '' : 's'; ?>
                            ·
                            <?= $videoCount; ?> video<?= $videoCount === 1 ? '' : 's'; ?>
                        </p>

                    </div>

                    <a
                        class="view-link"
                        href="album.php?id=<?= $albumId; ?>"
                    >
                        View album →
                    </a>

                </div>


                

                <div class="block-section">

                    <div class="block-subhead">
                        Music
                        <span class="count-pill"><?= $musicCount; ?></span>
                    </div>

                    <?php if ($musicCount > 0) { ?>

                        <div class="grid">

                            <?php while ($music = mysqli_fetch_assoc($musicResult)) { ?>

                                <?php
                                $musicId = (int) $music['music_id'];
                                $musicIsRated = isset($ratedMusicIds[$musicId]);
                                ?>

                                <article class="track-card">

                                    <div
                                        class="cover-wrap"
                                        style="position:relative;"
                                    >

                                        <img
                                            src="<?= htmlspecialchars($music['image'] ?: ($album['image'] ?: 'assets/images/artist-placeholder.svg')); ?>"
                                            alt="<?= htmlspecialchars($music['music_name']); ?> cover"
                                            loading="lazy"
                                            onerror="this.src='assets/images/artist-placeholder.svg'"
                                        >

                                        <a
                                            class="play-fab"
                                            href="play%20music.php?id=<?= $musicId; ?>"
                                            aria-label="Play <?= htmlspecialchars($music['music_name']); ?>"
                                            style="position:absolute; right:15px; bottom:15px; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                                        >
                                            ▶
                                        </a>

                                        <?php if ($music['year_duration'] === '2020-2025') { ?>

                                            <span class="type-badge new">
                                                NEW
                                            </span>

                                        <?php } ?>

                                    </div>


                                    <div class="track-body">

                                        <div class="track-title-row">

                                            <div>

                                                <h3>
                                                    <?= htmlspecialchars($music['music_name']); ?>
                                                </h3>

                                                <p>
                                                    <?= htmlspecialchars($artist['artist_name']); ?>
                                                    ·
                                                    <?= htmlspecialchars($music['language']); ?>
                                                </p>

                                            </div>

                                            <span class="year-pill">
                                                <?= htmlspecialchars($music['year_duration']); ?>
                                            </span>

                                        </div>


                                        <div class="track-actions">

                                            <a
                                                class="text-btn"
                                                href="play%20music.php?id=<?= $musicId; ?>"
                                                style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none;"
                                            >
                                                Play
                                            </a>


                                            <button
                                                type="button"
                                                class="icon-btn rate-btn"
                                                title="<?= $musicIsRated ? 'Rated' : 'Rate this song'; ?>"
                                                data-item-id="<?= $musicId; ?>"
                                                data-item-type="music"
                                                <?php if ($musicIsRated) { ?>
                                                    style="color:#1ed760;"
                                                <?php } ?>
                                            >
                                                <?= $musicIsRated ? '★' : '☆'; ?>
                                            </button>

                                        </div>

                                    </div>

                                </article>

                            <?php } ?>

                        </div>

                    <?php } else { ?>

                        <div class="empty">
                            No music available in this album.
                        </div>

                    <?php } ?>

                </div>


                

                <div class="block-section">

                    <div class="block-subhead">

                        Videos

                        <span class="count-pill">
                            <?= $videoCount; ?>
                        </span>

                    </div>


                    <?php if ($videoCount > 0) { ?>

                        <div class="grid">

                            <?php while ($video = mysqli_fetch_assoc($videoResult)) { ?>

                                <?php
                                $videoId = (int) $video['video_id'];
                                $videoIsRated = isset($ratedVideoIds[$videoId]);
                                ?>

                                <article class="track-card">

                                    <div
                                        class="cover-wrap"
                                        style="position:relative;"
                                    >

                                        <img
                                            src="<?= htmlspecialchars($video['image'] ?: ($album['image'] ?: 'assets/images/artist-placeholder.svg')); ?>"
                                            alt="<?= htmlspecialchars($video['video_name']); ?> cover"
                                            loading="lazy"
                                            onerror="this.src='assets/images/artist-placeholder.svg'"
                                        >

                                        <a
                                            class="play-fab"
                                            href="play%20video.php?id=<?= $videoId; ?>"
                                            aria-label="Play <?= htmlspecialchars($video['video_name']); ?>"
                                            style="position:absolute; right:15px; bottom:15px; display:flex; align-items:center; justify-content:center; text-decoration:none;"
                                        >
                                            ▶
                                        </a>

                                        <?php if ($video['year_duration'] === '2020-2025') { ?>

                                            <span class="type-badge new">
                                                NEW
                                            </span>

                                        <?php } ?>

                                    </div>


                                    <div class="track-body">

                                        <div class="track-title-row">

                                            <div>

                                                <h3>
                                                    <?= htmlspecialchars($video['video_name']); ?>
                                                </h3>

                                                <p>
                                                    <?= htmlspecialchars($artist['artist_name']); ?>
                                                    ·
                                                    <?= htmlspecialchars($video['language']); ?>
                                                </p>

                                            </div>

                                            <span class="year-pill">
                                                <?= htmlspecialchars($video['year_duration']); ?>
                                            </span>

                                        </div>


                                        <div class="track-actions">

                                            <a
                                                class="text-btn"
                                                href="play%20video.php?id=<?= $videoId; ?>"
                                                style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none;"
                                            >
                                                Play
                                            </a>


                                            <button
                                                type="button"
                                                class="icon-btn rate-btn"
                                                title="<?= $videoIsRated ? 'Rated' : 'Rate this video'; ?>"
                                                data-item-id="<?= $videoId; ?>"
                                                data-item-type="video"
                                                <?php if ($videoIsRated) { ?>
                                                    style="color:#1ed760;"
                                                <?php } ?>
                                            >
                                                <?= $videoIsRated ? '★' : '☆'; ?>
                                            </button>

                                        </div>

                                    </div>

                                </article>

                            <?php } ?>

                        </div>

                    <?php } else { ?>

                        <div class="empty">
                            No videos available in this album.
                        </div>

                    <?php } ?>

                </div>

            </div>

        <?php } ?>

    <?php } ?>

</section>

<?php

include_once 'includes/footer.php';

?>