<?php

include_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = 'Home — Audio Zone';
$activePage = 'home';

$userId = isset($_SESSION['user_id'])
    ? (int) $_SESSION['user_id']
    : 0;




$ratedMusicIds = [];
$ratedVideoIds = [];

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

        while ($row = mysqli_fetch_assoc($ratedVideoResult)) {

            $ratedVideoIds[(int) $row['review_item']] = true;

        }

    }

}


include_once 'includes/header.php';

?>

<section class="page">


    

    <section class="hero">

        <div class="hero-copy">

            <div class="eyebrow">
                A premium listening experience
            </div>

            <h1>
                Music that<br><span>feels real.</span>
            </h1>

            <p>
                Discover music, artists and videos across every language and genre —
                curated inside your zone.
            </p>

            <div class="hero-actions">

                <a class="gold-btn" href="music.php">
                    Explore Music
                </a>

                <a class="ghost-btn" href="artists.php">
                    Meet the Artists
                </a>

            </div>

        </div>

    </section>


    

    <section class="section">

        <div class="section-head">

            <div>

                <h2>Latest Music</h2>

                <p>
                    Fresh releases from the latest year range Music.
                </p>

            </div>

            <a class="view-link" href="music.php">
                View all →
            </a>

        </div>


        <?php

        $latestMusicQuery = "
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
            ORDER BY music.music_id DESC
            LIMIT 5
        ";

        $latestMusicResult = mysqli_query(
            $conn,
            $latestMusicQuery
        );

        ?>


        <div class="grid">

            <?php if ($latestMusicResult) { ?>

                <?php while ($track = mysqli_fetch_assoc($latestMusicResult)) { ?>

                    <?php
                    $musicId = (int) $track['music_id'];

                    $musicIsRated =
                        isset($ratedMusicIds[$musicId]);
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
                                onerror="this.src='assets/images/artist-placeholder.svg';"
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
                                    <?= $musicIsRated ? '★' : '☆'; ?>
                                </button>

                            </div>

                        </div>

                    </article>

                <?php } ?>

            <?php } else { ?>

                <div class="empty">
                    Music not available.
                </div>

            <?php } ?>

        </div>

    </section>



    

    <section class="section">

        <div class="section-head">

            <div>

                <h2>Latest Videos</h2>

                <p>
                    Fresh releases from the latest year range Video.
                </p>

            </div>

            <a class="view-link" href="videos.php">
                View all →
            </a>

        </div>


        <?php

        $latestVideoQuery = "
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
            ORDER BY videos.video_id DESC
            LIMIT 5
        ";

        $latestVideoResult = mysqli_query(
            $conn,
            $latestVideoQuery
        );

        ?>


        <div class="grid">

            <?php if ($latestVideoResult) { ?>

                <?php while ($video = mysqli_fetch_assoc($latestVideoResult)) { ?>

                    <?php
                    $videoId = (int) $video['video_id'];

                    $videoIsRated =
                        isset($ratedVideoIds[$videoId]);
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
                                onerror="this.src='assets/images/artist-placeholder.svg';"
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
                                    <?= $videoIsRated ? '★' : '☆'; ?>
                                </button>

                            </div>

                        </div>

                    </article>

                <?php } ?>

            <?php } else { ?>

                <div class="empty">
                    Videos not available.
                </div>

            <?php } ?>

        </div>

    </section>



    

    <section class="section">

        <div class="section-head">

            <div>

                <h2>Popular Artists</h2>

                <p>
                    Top artists in every available language.
                </p>

            </div>

            <a class="view-link" href="artists.php">
                View all →
            </a>

        </div>


        <?php

        $artistLanguagesQuery = "
            SELECT DISTINCT albums.language AS lang
            FROM artists
            JOIN albums
                ON artists.artist_name = albums.artist_name
            WHERE albums.language IS NOT NULL
              AND albums.language != ''
            ORDER BY albums.language
        ";

        $artistLanguagesResult = mysqli_query(
            $conn,
            $artistLanguagesQuery
        );

        ?>


        <?php if ($artistLanguagesResult) { ?>

            <?php while ($langRow = mysqli_fetch_assoc($artistLanguagesResult)) { ?>

                <?php

                $lang = $langRow['lang'];

                $safeLang =
                    mysqli_real_escape_string(
                        $conn,
                        $lang
                    );


                $artistQuery = "
                    SELECT artists.*
                    FROM artists
                    JOIN albums
                        ON artists.artist_name = albums.artist_name
                    WHERE albums.language = '$safeLang'
                    GROUP BY artists.artist_id
                    ORDER BY
                        CASE

                            WHEN artists.followers LIKE '%M'
                              OR artists.followers LIKE '%m'

                            THEN
                                CAST(
                                    REPLACE(
                                        REPLACE(
                                            artists.followers,
                                            'M',
                                            ''
                                        ),
                                        'm',
                                        ''
                                    )
                                    AS DECIMAL(20,2)
                                ) * 1000000


                            WHEN artists.followers LIKE '%K'
                              OR artists.followers LIKE '%k'

                            THEN
                                CAST(
                                    REPLACE(
                                        REPLACE(
                                            artists.followers,
                                            'K',
                                            ''
                                        ),
                                        'k',
                                        ''
                                    )
                                    AS DECIMAL(20,2)
                                ) * 1000


                            ELSE
                                CAST(
                                    REPLACE(
                                        REPLACE(
                                            artists.followers,
                                            'M',
                                            ''
                                        ),
                                        'm',
                                        ''
                                    )
                                    AS DECIMAL(20,2)
                                )

                        END DESC

                    LIMIT 5
                ";


                $artistResult =
                    mysqli_query(
                        $conn,
                        $artistQuery
                    );

                ?>


                <div class="section-head">

                    <div>

                        <h3 class="artist-row-title">
                            <?= htmlspecialchars($lang); ?>
                        </h3>

                    </div>

                </div>


                <div class="grid artist-grid">

                    <?php if ($artistResult) { ?>

                        <?php while ($artist = mysqli_fetch_assoc($artistResult)) { ?>

                            <article class="artist-card">

                                <a
                                    href="artist.php?id=<?= (int) $artist['artist_id']; ?>"
                                    style="
                                        text-decoration:none;
                                        color:inherit;
                                    "
                                >

                                    <div class="artist-image-wrap">

                                        <img
                                            src="<?= htmlspecialchars(
                                                $artist['image']
                                                ?: 'assets/images/artist-placeholder.svg'
                                            ); ?>"
                                            alt="<?= htmlspecialchars(
                                                $artist['artist_name']
                                            ); ?>"
                                            loading="lazy"
                                            onerror="this.src='assets/images/artist-placeholder.svg';"
                                        >

                                    </div>


                                    <div class="artist-card-meta">

                                        <h3>
                                            <?= htmlspecialchars(
                                                $artist['artist_name']
                                            ); ?>
                                        </h3>

                                        <p>
                                            <?= htmlspecialchars(
                                                $artist['followers']
                                            ); ?>

                                            followers
                                        </p>

                                    </div>

                                </a>

                            </article>

                        <?php } ?>

                    <?php } ?>

                </div>

            <?php } ?>

        <?php } ?>

    </section>



    

    <section class="section">

        <div class="section-head">

            <div>

                <h2>Albums</h2>

                <p>
                    albums from the database — one per language.
                </p>

            </div>

            <a class="view-link" href="albums.php">
                View all →
            </a>

        </div>


        <?php

        $albumLanguageQuery = "
            SELECT DISTINCT language
            FROM albums
            WHERE language IS NOT NULL
              AND language != ''
            ORDER BY language
        ";

        $albumLanguageResult =
            mysqli_query(
                $conn,
                $albumLanguageQuery
            );


        $albumLanguages = [];


        if ($albumLanguageResult) {

            while ($row =
                mysqli_fetch_assoc(
                    $albumLanguageResult
                )
            ) {

                $albumLanguages[] =
                    $row['language'];

            }

        }


        $shownAlbums = 0;

        ?>


        <div class="grid">

            <?php foreach ($albumLanguages as $language) { ?>

                <?php

                if ($shownAlbums >= 5) {
                    break;
                }


                $safeLanguage =
                    mysqli_real_escape_string(
                        $conn,
                        $language
                    );


                $albumQuery = "
                    SELECT
                        album_id,
                        album_name,
                        artist_name,
                        language,
                        image
                    FROM albums
                    WHERE language = '$safeLanguage'
                    ORDER BY album_name
                    LIMIT 1
                ";


                $albumResult =
                    mysqli_query(
                        $conn,
                        $albumQuery
                    );


                if (
                    !$albumResult ||
                    mysqli_num_rows(
                        $albumResult
                    ) === 0
                ) {

                    continue;

                }


                $album =
                    mysqli_fetch_assoc(
                        $albumResult
                    );


                $shownAlbums++;

                ?>


                <a
                    class="album-card"
                    href="album.php?id=<?= (int) $album['album_id']; ?>"
                >

                    <div class="cover-wrap">

                        <img
                            src="<?= htmlspecialchars(
                                $album['image']
                                ?: 'assets/images/artist-placeholder.svg'
                            ); ?>"
                            alt="<?= htmlspecialchars(
                                $album['album_name']
                            ); ?>"
                            loading="lazy"
                            onerror="this.src='assets/images/artist-placeholder.svg';"
                        >

                    </div>


                    <div class="track-body">

                        <h3>
                            <?= htmlspecialchars(
                                $album['album_name']
                            ); ?>
                        </h3>

                        <p>
                            <?= htmlspecialchars(
                                $album['artist_name']
                            ); ?>

                            ·

                            <?= htmlspecialchars(
                                $album['language']
                            ); ?>
                        </p>

                    </div>

                </a>

            <?php } ?>

        </div>

    </section>

</section>


<?php

include_once 'includes/footer.php';

?>