<?php

include_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'Genre — Audio Zone';
$activePage = 'genres';



$userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;



$requestedGenre = trim($_GET['genre'] ?? '');
$safeGenre = mysqli_real_escape_string($conn, $requestedGenre);

$genreRow = null;

if ($requestedGenre !== '') {

    $genreRes = mysqli_query(
        $conn,
        "
        SELECT genre_id, genre_name, image
        FROM genre
        WHERE genre_name = '$safeGenre'
        LIMIT 1
        "
    );

    if ($genreRes && mysqli_num_rows($genreRes) > 0) {

        $genreRow = mysqli_fetch_assoc($genreRes);
    }
}


if (!$genreRow) {

    header('Location: genres.php');
    exit();
}


$genreLabel = $genreRow['genre_name'];

$genreImage = $genreRow['image']
    ?: 'assets/images/artist-placeholder.svg';

$genreId = (int) $genreRow['genre_id'];



$ratedMusicIds = [];

if ($userId > 0) {

    $ratedMusicQuery = "
        SELECT review_item
        FROM reviews
        WHERE user_id = $userId
          AND item_type = 'music'
    ";

    $ratedMusicResult = mysqli_query(
        $conn,
        $ratedMusicQuery
    );

    if ($ratedMusicResult) {

        while ($ratedRow = mysqli_fetch_assoc($ratedMusicResult)) {

            $ratedMusicIds[
                (int) $ratedRow['review_item']
            ] = true;
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

    $ratedVideoResult = mysqli_query(
        $conn,
        $ratedVideoQuery
    );

    if ($ratedVideoResult) {

        while ($ratedRow = mysqli_fetch_assoc($ratedVideoResult)) {

            $ratedVideoIds[
                (int) $ratedRow['review_item']
            ] = true;
        }
    }
}



$sqlMusic = "
    SELECT music.*,
           albums.album_name,
           albums.language,
           albums.artist_name,
           genre.genre_name,
           years.year_duration
    FROM music
    JOIN albums
        ON music.album_id = albums.album_id
    JOIN genre
        ON music.genre_id = genre.genre_id
    JOIN years
        ON music.year_id = years.year_id
    WHERE music.genre_id = $genreId
    ORDER BY music.music_id DESC
";

$musicResult = mysqli_query(
    $conn,
    $sqlMusic
);



$sqlVideo = "
    SELECT videos.*,
           albums.album_name,
           albums.language,
           albums.artist_name,
           genre.genre_name,
           years.year_duration
    FROM videos
    JOIN albums
        ON videos.album_id = albums.album_id
    JOIN genre
        ON videos.genre_id = genre.genre_id
    JOIN years
        ON videos.year_id = years.year_id
    WHERE videos.genre_id = $genreId
    ORDER BY videos.video_id DESC
";

$videoResult = mysqli_query(
    $conn,
    $sqlVideo
);


$musicCount = ($musicResult)
    ? mysqli_num_rows($musicResult)
    : 0;

$videoCount = ($videoResult)
    ? mysqli_num_rows($videoResult)
    : 0;


include_once 'includes/header.php';

?>


<section class="page">

    <div class="page-heading">

        <div>

            <div class="eyebrow">
                Genre
            </div>

            <h1>
                <?= htmlspecialchars($genreLabel); ?>
            </h1>

            <p>
                Music and videos tagged with the
                <?= htmlspecialchars($genreLabel); ?>
                genre.
            </p>

        </div>


        <a
            class="view-link"
            href="genres.php">

            ← All genres

        </a>

    </div>


    

    <section class="section">

        <div class="section-head">

            <div>

                <h2>
                    Music
                </h2>

                <p>
                    Tracks in the
                    <?= htmlspecialchars($genreLabel); ?>
                    genre.
                </p>

            </div>

        </div>


        <div
            class="grid"
            id="genreMusicPhp">

            <?php if ($musicResult && $musicCount > 0) { ?>

                <?php while ($track = mysqli_fetch_assoc($musicResult)) { ?>

                    <?php

                    $musicId = (int) $track['music_id'];

                    $musicIsRated =
                        isset($ratedMusicIds[$musicId]);

                    ?>

                    <article class="track-card">


                        <div
                            class="cover-wrap"
                            style="position:relative;">

                            <img
                                src="<?= htmlspecialchars(
                                    $track['image']
                                    ?: $genreImage
                                ); ?>"
                                alt="<?= htmlspecialchars(
                                    $track['music_name']
                                ); ?> cover"
                                loading="lazy"
                                onerror="this.src='assets/images/artist-placeholder.svg'"
                            >


                            <a
                                class="play-fab"
                                href="play%20music.php?id=<?= $musicId; ?>"
                                aria-label="Play <?= htmlspecialchars(
                                    $track['music_name']
                                ); ?>"
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
                                        <?= htmlspecialchars(
                                            $track['music_name']
                                        ); ?>
                                    </h3>

                                    <p>
                                        <?= htmlspecialchars(
                                            $track['artist_name']
                                        ); ?>

                                        ·

                                        <?= htmlspecialchars(
                                            $track['language']
                                        ); ?>

                                        ·

                                        <?= htmlspecialchars(
                                            $track['genre_name']
                                        ); ?>
                                    </p>

                                </div>


                                <span class="year-pill">
                                    <?= htmlspecialchars(
                                        $track['year_duration']
                                    ); ?>
                                </span>

                            </div>


                            <div class="track-actions">


                                <a
                                    class="text-btn"
                                    href="play%20music.php?id=<?= $musicId; ?>"
                                    style="text-decoration:none;">

                                    Play

                                </a>


                                <button
                                    type="button"
                                    class="icon-btn rate-btn"
                                    title="<?= $musicIsRated
                                        ? 'Rated'
                                        : 'Rate this song'; ?>"
                                    data-item-id="<?= $musicId; ?>"
                                    data-item-type="music"
                                    <?php if ($musicIsRated) { ?>
                                        style="color:#1ed760;"
                                    <?php } ?>
                                >

                                    <?= $musicIsRated
                                        ? '★'
                                        : '☆'; ?>

                                </button>


                            </div>

                        </div>

                    </article>

                <?php } ?>

            <?php } else { ?>

                <div class="empty">
                    No music available for this genre.
                </div>

            <?php } ?>

        </div>

    </section>


    

    <section class="section">

        <div class="section-head">

            <div>

                <h2>
                    Videos
                </h2>

                <p>
                    Videos in the
                    <?= htmlspecialchars($genreLabel); ?>
                    genre.
                </p>

            </div>

        </div>


        <div
            class="grid"
            id="genreVideoPhp">

            <?php if ($videoResult && $videoCount > 0) { ?>

                <?php while ($video = mysqli_fetch_assoc($videoResult)) { ?>

                    <?php

                    $videoId = (int) $video['video_id'];

                    $videoIsRated =
                        isset($ratedVideoIds[$videoId]);

                    ?>

                    <article class="track-card">


                        <div
                            class="cover-wrap"
                            style="position:relative;">

                            <img
                                src="<?= htmlspecialchars(
                                    $video['image']
                                    ?: $genreImage
                                ); ?>"
                                alt="<?= htmlspecialchars(
                                    $video['video_name']
                                ); ?> cover"
                                loading="lazy"
                                onerror="this.src='assets/images/artist-placeholder.svg'"
                            >


                            <a
                                class="play-fab"
                                href="play%20video.php?id=<?= $videoId; ?>"
                                aria-label="Play <?= htmlspecialchars(
                                    $video['video_name']
                                ); ?>"
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
                                        <?= htmlspecialchars(
                                            $video['video_name']
                                        ); ?>
                                    </h3>

                                    <p>
                                        <?= htmlspecialchars(
                                            $video['artist_name']
                                        ); ?>

                                        ·

                                        <?= htmlspecialchars(
                                            $video['language']
                                        ); ?>

                                        ·

                                        <?= htmlspecialchars(
                                            $video['genre_name']
                                        ); ?>
                                    </p>

                                </div>


                                <span class="year-pill">
                                    <?= htmlspecialchars(
                                        $video['year_duration']
                                    ); ?>
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
                                    title="<?= $videoIsRated
                                        ? 'Rated'
                                        : 'Rate this video'; ?>"
                                    data-item-id="<?= $videoId; ?>"
                                    data-item-type="video"
                                    <?php if ($videoIsRated) { ?>
                                        style="color:#1ed760;"
                                    <?php } ?>
                                >

                                    <?= $videoIsRated
                                        ? '★'
                                        : '☆'; ?>

                                </button>


                            </div>

                        </div>

                    </article>

                <?php } ?>

            <?php } else { ?>

                <div class="empty">
                    No videos available for this genre.
                </div>

            <?php } ?>

        </div>

    </section>

</section>


<?php

include_once 'includes/footer.php';

?>