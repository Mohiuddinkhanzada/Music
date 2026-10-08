<?php

include_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'Videos — Audio Zone';
$bodyClass = 'page-solid';
$activePage = 'videos';



$userId = isset($_SESSION['user_id'])
    ? (int) $_SESSION['user_id']
    : 0;



$ratedVideoIds = [];

if ($userId > 0) {

    $ratedVideoQuery = "
        SELECT review_item
        FROM reviews
        WHERE user_id = ?
          AND item_type = 'video'
    ";

    $ratedVideoStmt = $conn->prepare(
        $ratedVideoQuery
    );

    if ($ratedVideoStmt) {

        $ratedVideoStmt->bind_param(
            'i',
            $userId
        );

        $ratedVideoStmt->execute();

        $ratedVideoResult =
            $ratedVideoStmt->get_result();

        while (
            $row = mysqli_fetch_assoc(
                $ratedVideoResult
            )
        ) {

            $ratedVideoIds[
                (int) $row['review_item']
            ] = true;

        }

        $ratedVideoStmt->close();

    }

}



$language = trim(
    $_GET['language'] ?? ''
);

$genre = trim(
    $_GET['genre'] ?? ''
);

$artist = trim(
    $_GET['artist'] ?? ''
);

$era = trim(
    $_GET['era'] ?? ''
);



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
    '2020-2025' => '2020-2025'

];



$where = [];
$args  = [];


if ($language !== '') {

    $where[] = 'albums.language = ?';
    $args[] = $language;

}


if ($genre !== '') {

    $where[] = 'genre.genre_name = ?';
    $args[] = $genre;

}


if ($artist !== '') {

    $where[] = 'albums.artist_name = ?';
    $args[] = $artist;

}


if ($era !== '') {

    $mappedEra =
        $eraMap[$era] ?? $era;

    $where[] =
        'years.year_duration = ?';

    $args[] =
        $mappedEra;

}



$sql = "
    SELECT
        videos.*,
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
";


if (count($where) > 0) {

    $sql .=
        ' WHERE ' .
        implode(
            ' AND ',
            $where
        );

}


$sql .= "
    ORDER BY videos.video_id DESC
";


$stmt =
    $conn->prepare($sql);


if ($stmt) {

    if (count($args) > 0) {

        $types =
            str_repeat(
                's',
                count($args)
            );

        $stmt->bind_param(
            $types,
            ...$args
        );

    }

    $stmt->execute();

    $videoResult =
        $stmt->get_result();

} else {

    $videoResult = false;

}


$resultCount =
    ($videoResult)
        ? $videoResult->num_rows
        : 0;



include_once 'includes/header.php';

?>


<section class="page">


    

    <div class="page-heading">

        <div>

            <div class="eyebrow">
                Video Library
            </div>

            <h1>
                Watch the sound.
            </h1>

            <p>
                Every video below is a real release in the library.
                Combine any set of filters and the results stay tied
                to your selection.
            </p>

        </div>

    </div>


    

    <div
        class="grid"
        id="videosResultsPhp"
    >


        <?php if (
            $videoResult &&
            $resultCount > 0
        ) { ?>


            <?php while (
                $video =
                    mysqli_fetch_assoc(
                        $videoResult
                    )
            ) { ?>


                <?php

                $videoId =
                    (int) $video['video_id'];

                $videoIsRated =
                    isset(
                        $ratedVideoIds[$videoId]
                    );

                ?>


                <article class="track-card">


                    

                    <div
                        class="cover-wrap"
                        style="position:relative;"
                    >

                        <img
                            src="<?= htmlspecialchars(
                                $video['image']
                                ?: 'assets/images/artist-placeholder.svg'
                            ); ?>"
                            alt="<?= htmlspecialchars(
                                $video['video_name']
                            ); ?> cover"
                            loading="lazy"
                            onerror="
                                this.src='assets/images/artist-placeholder.svg';
                            "
                        >


                        

                        <a
                            class="play-fab"
                            href="play video.php?id=<?= $videoId; ?>"
                            aria-label="Play <?= htmlspecialchars(
                                $video['video_name']
                            ); ?>"
                            style="
                                position:absolute;
                                right:15px;
                                bottom:15px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                text-decoration:none;
                            "
                        >
                            ▶
                        </a>


                        <?php if (
                            $video['year_duration']
                            === '2020-2025'
                        ) { ?>

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
                                href="play video.php?id=<?= $videoId; ?>"
                                style="
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                    text-decoration:none;
                                "
                            >
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
                Content not available for this selection.
            </div>


        <?php } ?>


    </div>


</section>


<?php

include_once 'includes/footer.php';

?>