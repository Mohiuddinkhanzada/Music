<?php

include_once '../config.php';

$pageTitle = 'All Reviews';
$adminPage = 'all-reviews';


$totalReviews = 0;

$totalQuery = "
    SELECT COUNT(*) AS total
    FROM reviews
";

$totalResult = mysqli_query(
    $conn,
    $totalQuery
);

if ($totalResult) {

    $totalRow = mysqli_fetch_assoc(
        $totalResult
    );

    $totalReviews =
        (int) ($totalRow['total'] ?? 0);
}


$reviewsQuery = "

    SELECT

        reviews.review_id,
        reviews.user_id,
        reviews.review_item,
        reviews.item_type,
        reviews.rating,

        users.name AS user_name,

        CASE

            WHEN reviews.item_type = 'music'
            THEN music.music_name

            WHEN reviews.item_type = 'video'
            THEN videos.video_name

            ELSE 'Unknown item'

        END AS item_name,


        CASE

            WHEN reviews.item_type = 'music'
            THEN musicAlbums.artist_name

            WHEN reviews.item_type = 'video'
            THEN videoAlbums.artist_name

            ELSE ''

        END AS artist_name


    FROM reviews


    LEFT JOIN users
        ON reviews.user_id = users.user_id


    LEFT JOIN music
        ON reviews.item_type = 'music'
        AND reviews.review_item = music.music_id


    LEFT JOIN videos
        ON reviews.item_type = 'video'
        AND reviews.review_item = videos.video_id


    LEFT JOIN albums AS musicAlbums
        ON music.album_id = musicAlbums.album_id


    LEFT JOIN albums AS videoAlbums
        ON videos.album_id = videoAlbums.album_id


    ORDER BY reviews.review_id DESC
";


$reviewsResult = mysqli_query(
    $conn,
    $reviewsQuery
);


include_once 'includes/header.php';

?>


<div class="page-heading">

    <div>

        <div class="eyebrow">
            Reviews
        </div>

        <h1>
            All Reviews
        </h1>

        <p>
            User-submitted ratings.
        </p>

    </div>

</div>



<div class="admin-table-wrap">


    <div class="admin-table-header">

        <h2>
            <?= $totalReviews; ?> Reviews
        </h2>

    </div>



    <table class="admin-table">

        <thead>

            <tr>

                <th>
                    User
                </th>

                <th>
                    Track
                </th>

                <th>
                    Rating
                </th>

            </tr>

        </thead>


        <tbody>


            <?php if (
                $reviewsResult &&
                mysqli_num_rows($reviewsResult) > 0
            ) { ?>


                <?php while (
                    $review =
                    mysqli_fetch_assoc(
                        $reviewsResult
                    )
                ) { ?>


                    <?php

                    $userName =
                        $review['user_name']
                        ?: 'Unknown User';


                    $itemName =
                        $review['item_name']
                        ?: 'Unknown Item';


                    $artistName =
                        $review['artist_name']
                        ?: '';


                    ?>


                    <tr>


                        <td>

                            <div class="user-cell">


                                <div class="avatar">

                                    <?= htmlspecialchars(
                                        strtoupper(
                                            substr(
                                                $userName,
                                                0,
                                                1
                                            )
                                        )
                                    ); ?>

                                </div>


                                <strong>

                                    <?= htmlspecialchars(
                                        $userName
                                    ); ?>

                                </strong>


                            </div>

                        </td>



                        <td>

                            <?= htmlspecialchars(
                                $itemName
                            ); ?>


                            <?php if ($artistName !== '') { ?>

                                —
                                <?= htmlspecialchars(
                                    $artistName
                                ); ?>

                            <?php } ?>


                        </td>



                        <td>

                            <span
                                style="
                                    color:#1ed760;
                                    font-size:18px;
                                    font-weight:600;
                                "
                                title="Rating: 1"
                            >
                                ★
                            </span>

                        </td>


                    </tr>


                <?php } ?>


            <?php } else { ?>


                <tr>

                    <td
                        colspan="3"
                        style="
                            text-align:center;
                            padding:30px;
                        "
                    >

                       

                    </td>

                </tr>


            <?php } ?>


        </tbody>

    </table>


</div>


<?php

include_once 'includes/footer.php';

?>