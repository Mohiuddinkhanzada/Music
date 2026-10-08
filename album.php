<?php

include_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'Album — Audio Zone';
$activePage = 'albums';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$album = null;
$artistImage = '';
$albumArtistId = 0;

$musicResult = null;
$videoResult = null;


$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;

$ratedMusicIds = [];
$ratedVideoIds = [];

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



if ($id > 0) {

    $albumQuery = "
        SELECT album_id, album_name, image, language, artist_name
        FROM albums
        WHERE album_id = $id
        LIMIT 1
    ";

    $albumResult = mysqli_query($conn, $albumQuery);

    if ($albumResult && mysqli_num_rows($albumResult) > 0) {

        $album = mysqli_fetch_assoc($albumResult);

        $pageTitle = htmlspecialchars($album['album_name']) . ' — Audio Zone';

        $safeArtist = mysqli_real_escape_string(
            $conn,
            $album['artist_name']
        );

        $artistRow = mysqli_query(
            $conn,
            "
            SELECT artist_id, image
            FROM artists
            WHERE artist_name = '$safeArtist'
            LIMIT 1
            "
        );

        if ($artistRow && mysqli_num_rows($artistRow) > 0) {

            $artistInfo = mysqli_fetch_assoc($artistRow);

            $artistImage = $artistInfo['image'];
            $albumArtistId = (int) $artistInfo['artist_id'];
        }
    }
}



if ($album) {

    $musicQuery = "
        SELECT music.*,
               genre.genre_name,
               years.year_duration,
               albums.language
        FROM music
        JOIN albums
            ON music.album_id = albums.album_id
        JOIN genre
            ON music.genre_id = genre.genre_id
        JOIN years
            ON music.year_id = years.year_id
        WHERE albums.album_id = $id
        ORDER BY music.music_id DESC
    ";

    $musicResult = mysqli_query($conn, $musicQuery);


    $videoQuery = "
        SELECT videos.*,
               genre.genre_name,
               years.year_duration,
               albums.language
        FROM videos
        JOIN albums
            ON videos.album_id = albums.album_id
        JOIN genre
            ON videos.genre_id = genre.genre_id
        JOIN years
            ON videos.year_id = years.year_id
        WHERE albums.album_id = $id
        ORDER BY videos.video_id DESC
    ";

    $videoResult = mysqli_query($conn, $videoQuery);
}


$musicCount = ($musicResult)
    ? mysqli_num_rows($musicResult)
    : 0;

$videoCount = ($videoResult)
    ? mysqli_num_rows($videoResult)
    : 0;


include_once 'includes/header.php';

?>

<section class="page">

    <?php if ($album) { ?>

        <?php

        $firstPlayId = 0;

        if ($musicResult && mysqli_num_rows($musicResult) > 0) {

            $firstRow = mysqli_fetch_assoc($musicResult);

            $firstPlayId = (int) $firstRow['music_id'];

            mysqli_data_seek($musicResult, 0);

        } elseif ($videoResult && mysqli_num_rows($videoResult) > 0) {

            $firstRow = mysqli_fetch_assoc($videoResult);

            $firstPlayId = (int) $firstRow['video_id'];

            mysqli_data_seek($videoResult, 0);
        }

        ?>

        <div class="album-breadcrumb">
            <a class="view-link" href="albums.php">
                ← All albums
            </a>
        </div>


        <div class="album-hero">

            <div class="album-cover-wrap">

                <img
                    class="album-hero-art"
                    src="<?= htmlspecialchars($album['image'] ?: 'assets/images/artist-placeholder.svg'); ?>"
                    alt="<?= htmlspecialchars($album['album_name']); ?>"
                    onerror="this.src='assets/images/artist-placeholder.svg'">

            </div>


            <div class="album-hero-meta">

                <div class="eyebrow">
                    Album
                </div>

                <h1>
                    <?= htmlspecialchars($album['album_name']); ?>
                </h1>


                <div class="album-hero-artistline">

                    <a
                        class="album-hero-artist"
                        href="artist.php?id=<?= $albumArtistId; ?>">

                        <img
                            class="album-hero-avatar"
                            src="<?= htmlspecialchars($artistImage ?: 'assets/images/artist-placeholder.svg'); ?>"
                            alt="<?= htmlspecialchars($album['artist_name']); ?>"
                            onerror="this.src='assets/images/artist-placeholder.svg'">

                        <span>
                            <?= htmlspecialchars($album['artist_name']); ?>
                        </span>

                    </a>

                    <span class="album-hero-language">
                        · <?= htmlspecialchars($album['language']); ?>
                    </span>

                </div>


                <div class="album-hero-actions">

                    <button
                        class="gold-btn album-hero-play"
                        <?php if ($firstPlayId > 0) { ?>
                            data-play="<?= $firstPlayId; ?>"
                        <?php } ?>
                        aria-label="Play <?= htmlspecialchars($album['album_name']); ?>">

                        <span class="album-hero-play-icon">
                            ▶
                        </span>

                        Play

                    </button>

                </div>

            </div>

        </div>


        

        <section class="section">

            <div class="section-head">

                <div>

                    <h2>
                        Music
                        <span class="count-pill">
                            <?= $musicCount; ?>
                        </span>
                    </h2>

                    <p>
                        Tracks inside this album.
                    </p>

                </div>

            </div>


            <div class="grid">

                <?php if ($musicResult && $musicCount > 0) { ?>

                    <?php while ($track = mysqli_fetch_assoc($musicResult)) { ?>

                        <?php

                        $musicId = (int) $track['music_id'];

                        $musicIsRated = isset($ratedMusicIds[$musicId]);

                        ?>

                        <article class="track-card">

                            <div
                                class="cover-wrap"
                                style="position:relative;">

                                <img
                                    src="<?= htmlspecialchars($track['image'] ?: ($album['image'] ?: 'assets/images/artist-placeholder.svg')); ?>"
                                    alt="<?= htmlspecialchars($track['music_name']); ?> cover"
                                    loading="lazy"
                                    onerror="this.src='assets/images/artist-placeholder.svg'">


                                <a
                                    class="play-fab"
                                    href="play%20music.php?id=<?= $musicId; ?>"
                                    aria-label="Play <?= htmlspecialchars($track['music_name']); ?>"
                                    style="position:absolute; right:15px; bottom:15px; display:flex; align-items:center; justify-content:center; text-decoration:none;">

                                    ▶

                                </a>


                                <?php if ($track['year_duration'] === '2020-2025') { ?>

                                    <span class="type-badge new">
                                        NEW
                                    </span>

                                <?php } ?>

                            </div>


                            <div class="track-body">

                                <div class="track-title-row">

                                    <div>

                                        <h3>
                                            <?= htmlspecialchars($track['music_name']); ?>
                                        </h3>

                                        <p>
                                            <?= htmlspecialchars($album['artist_name']); ?>
                                            ·
                                            <?= htmlspecialchars($album['language']); ?>
                                        </p>

                                    </div>


                                    <span class="year-pill">
                                        <?= htmlspecialchars($track['year_duration']); ?>
                                    </span>

                                </div>


                                <div class="track-actions">

                                    <a
                                        class="text-btn"
                                        href="play%20music.php?id=<?= $musicId; ?>"
                                        style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none;">

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
                                        <?php } ?>>

                                        <?= $musicIsRated ? '★' : '☆'; ?>

                                    </button>

                                </div>

                            </div>

                        </article>

                    <?php } ?>

                <?php } else { ?>

                    <div class="empty">
                        No music available for this album.
                    </div>

                <?php } ?>

            </div>

        </section>


        

        <section class="section">

            <div class="section-head">

                <div>

                    <h2>
                        Videos
                        <span class="count-pill">
                            <?= $videoCount; ?>
                        </span>
                    </h2>

                    <p>
                        Videos inside this album.
                    </p>

                </div>

            </div>


            <div class="grid">

                <?php if ($videoResult && $videoCount > 0) { ?>

                    <?php while ($video = mysqli_fetch_assoc($videoResult)) { ?>

                        <?php

                        $videoId = (int) $video['video_id'];

                        $videoIsRated = isset($ratedVideoIds[$videoId]);

                        ?>

                        <article class="track-card">

                            <div
                                class="cover-wrap"
                                style="position:relative;">

                                <img
                                    src="<?= htmlspecialchars($video['image'] ?: ($album['image'] ?: 'assets/images/artist-placeholder.svg')); ?>"
                                    alt="<?= htmlspecialchars($video['video_name']); ?> cover"
                                    loading="lazy"
                                    onerror="this.src='assets/images/artist-placeholder.svg'">


                                <a
                                    class="play-fab"
                                    href="play%20video.php?id=<?= $videoId; ?>"
                                    aria-label="Play <?= htmlspecialchars($video['video_name']); ?>"
                                    style="position:absolute; right:15px; bottom:15px; display:flex; align-items:center; justify-content:center; text-decoration:none;">

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
                                            <?= htmlspecialchars($album['artist_name']); ?>
                                            ·
                                            <?= htmlspecialchars($album['language']); ?>
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
                                        style="display:inline-flex; align-items:center; justify-content:center; text-decoration:none;">

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
                                        <?php } ?>>

                                        <?= $videoIsRated ? '★' : '☆'; ?>

                                    </button>

                                </div>

                            </div>

                        </article>

                    <?php } ?>

                <?php } else { ?>

                    <div class="empty">
                        No videos available for this album.
                    </div>

                <?php } ?>

            </div>

        </section>


    <?php } else { ?>

        <div class="empty">
            This album could not be found.
        </div>

    <?php } ?>

</section>


<?php

include_once 'includes/footer.php';

?>