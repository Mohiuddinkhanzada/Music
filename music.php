<?php

include_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'Music — Audio Zone';
$bodyClass = 'page-solid';
$activePage = 'music';



$userId = isset($_SESSION['user_id'])
    ? (int) $_SESSION['user_id']
    : 0;



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

        while ($row = mysqli_fetch_assoc($ratedMusicResult)) {

            $ratedMusicIds[(int) $row['review_item']] = true;

        }

    }

}



$language = trim($_GET['language'] ?? '');
$genre    = trim($_GET['genre'] ?? '');
$artist   = trim($_GET['artist'] ?? '');
$era      = trim($_GET['era'] ?? '');



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

    $where[] = "albums.language = ?";
    $args[]  = $language;

}


if ($genre !== '') {

    $where[] = "genre.genre_name = ?";
    $args[]  = $genre;

}


if ($artist !== '') {

    $where[] = "albums.artist_name = ?";
    $args[]  = $artist;

}


if ($era !== '') {

    $mappedEra =
        $eraMap[$era] ?? $era;

    $where[] =
        "years.year_duration = ?";

    $args[] =
        $mappedEra;

}



$sql = "
    SELECT
        music.*,
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
";


if (count($where) > 0) {

    $sql .=
        " WHERE " .
        implode(' AND ', $where);

}


$sql .= "
    ORDER BY music.music_id DESC
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


    $musicResult =
        $stmt->get_result();

} else {

    $musicResult = false;

}


$resultCount =
    ($musicResult)
        ? $musicResult->num_rows
        : 0;



include_once 'includes/header.php';

?>


<section class="page">


    

    <div class="page-heading">

        <div>

            <div class="eyebrow">
                Music Library
            </div>

            <h1>
                Find your sound.
            </h1>

            <p>
                Filters are combinable. Artist selection always keeps
                results tied to that artist; era selection keeps results
                inside the chosen era.
            </p>

        </div>

    </div>


    

    <div
        class="grid"
        id="musicResultsPhp"
    >


        <?php if (
            $musicResult &&
            $resultCount > 0
        ) { ?>


            <?php while (
                $track =
                    mysqli_fetch_assoc(
                        $musicResult
                    )
            ) { ?>


                <?php

                $musicId =
                    (int) $track['music_id'];

                $musicIsRated =
                    isset(
                        $ratedMusicIds[$musicId]
                    );

                ?>


                

                <article class="track-card">


                    

                    <div class="cover-wrap">

                        <img
                            src="<?= htmlspecialchars(
                                $track['image']
                                ?: 'assets/images/artist-placeholder.svg'
                            ); ?>"
                            alt="<?= htmlspecialchars(
                                $track['music_name']
                            ); ?> cover"
                            loading="lazy"
                            onerror="
                                this.src='assets/images/artist-placeholder.svg';
                            "
                        >


                        

                        <a
                            class="play-fab"
                            href="play music.php?id=<?= $musicId; ?>"
                            aria-label="Play <?= htmlspecialchars(
                                $track['music_name']
                            ); ?>"
                            style="
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                text-decoration:none;
                            "
                        >
                            ▶
                        </a>


                        <?php if (
                            $track['year_duration']
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
                                href="play music.php?id=<?= $musicId; ?>"
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
                Content not available for this selection.
            </div>


        <?php } ?>


    </div>


</section>


<?php

include_once 'includes/footer.php';

?>