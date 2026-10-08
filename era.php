<?php

include_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'Era — Audio Zone';
$activePage = 'years';



$userId = isset($_SESSION['user_id'])
    ? (int) $_SESSION['user_id']
    : 0;



$eraMap = [
    '2000–2005' => '2002-2005',
    '2000-2005' => '2002-2005',
    '2002-2005' => '2002-2005',

    '2005–2010' => '2005-2010',
    '2005-2010' => '2005-2010',

    '2010–2015' => '2010-2015',
    '2010-2015' => '2010-2015',

    '2015–2020' => '2015-2020',
    '2015-2020' => '2015-2020',

    '2020–2025' => '2020-2025',
    '2020-2025' => '2020-2025',
];


$requestedEra = trim($_GET['era'] ?? '');

$eraValue = $eraMap[$requestedEra] ?? $requestedEra;

$eraRow = null;



if ($eraValue !== '') {

    $safeEra = mysqli_real_escape_string(
        $conn,
        $eraValue
    );

    $eraRes = mysqli_query(
        $conn,
        "
        SELECT year_id, year_duration, image
        FROM years
        WHERE year_duration = '$safeEra'
        LIMIT 1
        "
    );

    if ($eraRes && mysqli_num_rows($eraRes) > 0) {

        $eraRow = mysqli_fetch_assoc($eraRes);
    }
}


if (!$eraRow) {

    header('Location: years.php');
    exit();
}


$eraLabel = str_replace(
    '-',
    '–',
    $eraRow['year_duration']
);

$eraImage = $eraRow['image']
    ?: 'assets/images/artist-placeholder.svg';

$eraId = (int) $eraRow['year_id'];



$language = trim($_GET['language'] ?? '');
$genre    = trim($_GET['genre'] ?? '');
$artist   = trim($_GET['artist'] ?? '');
$type     = trim($_GET['type'] ?? '');



function loadEra(
    string $kind,
    mysqli $c,
    int $eraId,
    array $mapped
) {

    $where = [
        "m.year_id = $eraId"
    ];


    
    if ($mapped['language'] !== '') {

        $safe = mysqli_real_escape_string(
            $c,
            $mapped['language']
        );

        $where[] = "a.language = '$safe'";
    }


    
    if ($mapped['genre'] !== '') {

        $safe = mysqli_real_escape_string(
            $c,
            $mapped['genre']
        );

        $where[] = "g.genre_name = '$safe'";
    }


    
    if ($mapped['artist'] !== '') {

        $safe = mysqli_real_escape_string(
            $c,
            $mapped['artist']
        );

        $where[] = "a.artist_name = '$safe'";
    }


    if ($kind === 'music') {

        $prefix = 'music';
        $idCol = 'music_id';

    } else {

        $prefix = 'videos';
        $idCol = 'video_id';
    }


    $sql = "
        SELECT m.*,
               a.album_name,
               a.language,
               a.artist_name,
               g.genre_name,
               y.year_duration

        FROM $prefix AS m

        JOIN albums a
            ON m.album_id = a.album_id

        JOIN genre g
            ON m.genre_id = g.genre_id

        JOIN years y
            ON m.year_id = y.year_id

        WHERE " . implode(' AND ', $where) . "

        ORDER BY m.$idCol DESC
    ";


    return mysqli_query(
        $c,
        $sql
    );
}



$mappedFilters = [
    'language' => $language,
    'genre'    => $genre,
    'artist'   => $artist,
];



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

        while ($ratedRow = mysqli_fetch_assoc(
            $ratedMusicResult
        )) {

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

        while ($ratedRow = mysqli_fetch_assoc(
            $ratedVideoResult
        )) {

            $ratedVideoIds[
                (int) $ratedRow['review_item']
            ] = true;
        }
    }
}



$musicResult = null;
$videoResult = null;

if ($type === 'music') {

    $musicResult = loadEra(
        'music',
        $conn,
        $eraId,
        $mappedFilters
    );

} elseif ($type === 'video') {

    $videoResult = loadEra(
        'video',
        $conn,
        $eraId,
        $mappedFilters
    );

} else {

    $musicResult = loadEra(
        'music',
        $conn,
        $eraId,
        $mappedFilters
    );

    $videoResult = loadEra(
        'video',
        $conn,
        $eraId,
        $mappedFilters
    );
}


$musicCount = ($musicResult)
    ? $musicResult->num_rows
    : 0;

$videoCount = ($videoResult)
    ? $videoResult->num_rows
    : 0;


include_once 'includes/header.php';

?>


<section class="page">


    

    <div class="page-heading">

        <div>

            <div class="eyebrow">
                Era
            </div>

            <h1>
                <?= htmlspecialchars($eraLabel); ?>
            </h1>

            <p>
                This page is showed to the
                <?= htmlspecialchars($eraLabel); ?>
                era. Realted Music and video below and the results stay
                inside this era only.
            </p>

        </div>


        <a
            class="view-link"
            href="years.php">

            ← All eras

        </a>

    </div>


    

    <?php if ($type === 'music' || $type === '') { ?>

        <section class="section">

            <div class="section-head">

                <div>

                    <h2>
                        Music
                    </h2>

                    <p>
                        Tracks inside the
                        <?= htmlspecialchars($eraLabel); ?>
                        era.
                    </p>

                </div>

            </div>


            <div
                class="grid"
                id="eraMusicPhp">


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
                                        ?: $eraImage
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
                        No music available for this era.
                    </div>


                <?php } ?>


            </div>

        </section>

    <?php } ?>


    

    <?php if ($type === 'video' || $type === '') { ?>


        <section class="section">


            <div class="section-head">

                <div>

                    <h2>
                        Videos
                    </h2>

                    <p>
                        Videos inside the
                        <?= htmlspecialchars($eraLabel); ?>
                        era.
                    </p>

                </div>

            </div>


            <div
                class="grid"
                id="eraVideoPhp">


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
                                        ?: $eraImage
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
                        No videos available for this era.
                    </div>


                <?php } ?>


            </div>

        </section>


    <?php } ?>


</section>


<?php

include_once 'includes/footer.php';

?>