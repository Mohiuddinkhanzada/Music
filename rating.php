<?php

include_once './config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');




if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        'success' => false,
        'message' => 'Please login first.'
    ]);

    exit();
}


$userId = (int) $_SESSION['user_id'];




$itemId = isset($_POST['item_id'])
    ? (int) $_POST['item_id']
    : 0;

$itemType = trim($_POST['item_type'] ?? '');




if ($itemId <= 0) {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid item ID.'
    ]);

    exit();
}


if ($itemType !== 'music' && $itemType !== 'video') {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid item type.'
    ]);

    exit();
}




if ($itemType === 'music') {

    $itemCheckQuery = "
        SELECT music_id
        FROM music
        WHERE music_id = ?
        LIMIT 1
    ";

} else {

    $itemCheckQuery = "
        SELECT video_id
        FROM videos
        WHERE video_id = ?
        LIMIT 1
    ";

}


$itemCheckStmt = mysqli_prepare(
    $conn,
    $itemCheckQuery
);


if (!$itemCheckStmt) {

    echo json_encode([
        'success' => false,
        'message' => 'Item check failed: ' . mysqli_error($conn)
    ]);

    exit();
}


mysqli_stmt_bind_param(
    $itemCheckStmt,
    'i',
    $itemId
);


mysqli_stmt_execute(
    $itemCheckStmt
);


$itemCheckResult =
    mysqli_stmt_get_result(
        $itemCheckStmt
    );


if (
    !$itemCheckResult ||
    mysqli_num_rows($itemCheckResult) === 0
) {

    echo json_encode([
        'success' => false,
        'message' => 'Music or video item was not found.'
    ]);

    exit();
}


mysqli_stmt_close(
    $itemCheckStmt
);




$checkQuery = "
    SELECT review_id
    FROM reviews
    WHERE user_id = ?
      AND review_item = ?
      AND item_type = ?
    LIMIT 1
";


$checkStmt = mysqli_prepare(
    $conn,
    $checkQuery
);


if (!$checkStmt) {

    echo json_encode([
        'success' => false,
        'message' => 'Rating check failed: ' . mysqli_error($conn)
    ]);

    exit();
}


mysqli_stmt_bind_param(
    $checkStmt,
    'iis',
    $userId,
    $itemId,
    $itemType
);


mysqli_stmt_execute(
    $checkStmt
);


$checkResult =
    mysqli_stmt_get_result(
        $checkStmt
    );


$alreadyRated =
    $checkResult &&
    mysqli_num_rows($checkResult) > 0;


mysqli_stmt_close(
    $checkStmt
);




if ($alreadyRated) {

    

    $deleteQuery = "
        DELETE FROM reviews
        WHERE user_id = ?
          AND review_item = ?
          AND item_type = ?
        LIMIT 1
    ";


    $deleteStmt = mysqli_prepare(
        $conn,
        $deleteQuery
    );


    if (!$deleteStmt) {

        echo json_encode([
            'success' => false,
            'message' => 'Delete preparation failed: ' . mysqli_error($conn)
        ]);

        exit();
    }


    mysqli_stmt_bind_param(
        $deleteStmt,
        'iis',
        $userId,
        $itemId,
        $itemType
    );


    if (!mysqli_stmt_execute($deleteStmt)) {

        echo json_encode([
            'success' => false,
            'message' => 'Rating could not be removed: ' .
                         mysqli_stmt_error($deleteStmt)
        ]);

        mysqli_stmt_close($deleteStmt);

        exit();
    }


    mysqli_stmt_close($deleteStmt);


    $rated = false;

} else {

    

    $insertQuery = "
        INSERT INTO reviews
        (
            user_id,
            review_item,
            item_type,
            rating
        )
        VALUES
        (
            ?,
            ?,
            ?,
            1
        )
    ";


    $insertStmt = mysqli_prepare(
        $conn,
        $insertQuery
    );


    if (!$insertStmt) {

        echo json_encode([
            'success' => false,
            'message' => 'Insert preparation failed: ' . mysqli_error($conn)
        ]);

        exit();
    }


    mysqli_stmt_bind_param(
        $insertStmt,
        'iis',
        $userId,
        $itemId,
        $itemType
    );


    if (!mysqli_stmt_execute($insertStmt)) {

        echo json_encode([
            'success' => false,
            'message' => 'Rating could not be added: ' .
                         mysqli_stmt_error($insertStmt)
        ]);

        mysqli_stmt_close($insertStmt);

        exit();
    }


    mysqli_stmt_close($insertStmt);


    $rated = true;

}




$countQuery = "
    SELECT COUNT(*) AS total
    FROM reviews
    WHERE review_item = ?
      AND item_type = ?
";


$countStmt = mysqli_prepare(
    $conn,
    $countQuery
);


if (!$countStmt) {

    echo json_encode([
        'success' => false,
        'message' => 'Count preparation failed: ' . mysqli_error($conn)
    ]);

    exit();
}


mysqli_stmt_bind_param(
    $countStmt,
    'is',
    $itemId,
    $itemType
);


mysqli_stmt_execute(
    $countStmt
);


$countResult =
    mysqli_stmt_get_result(
        $countStmt
    );


if (!$countResult) {

    echo json_encode([
        'success' => false,
        'message' => 'Rating count failed: ' . mysqli_error($conn)
    ]);

    mysqli_stmt_close($countStmt);

    exit();
}


$countRow =
    mysqli_fetch_assoc(
        $countResult
    );


$totalRatings =
    (int) ($countRow['total'] ?? 0);


mysqli_stmt_close(
    $countStmt
);




if ($itemType === 'music') {

    $updateQuery = "
        UPDATE music
        SET rating = ?
        WHERE music_id = ?
    ";

} else {

    $updateQuery = "
        UPDATE videos
        SET rating = ?
        WHERE video_id = ?
    ";

}


$updateStmt = mysqli_prepare(
    $conn,
    $updateQuery
);


if (!$updateStmt) {

    echo json_encode([
        'success' => false,
        'message' => 'Rating update preparation failed: ' .
                     mysqli_error($conn)
    ]);

    exit();
}


mysqli_stmt_bind_param(
    $updateStmt,
    'ii',
    $totalRatings,
    $itemId
);


if (!mysqli_stmt_execute($updateStmt)) {

    echo json_encode([
        'success' => false,
        'message' => 'Rating count could not be updated: ' .
                     mysqli_stmt_error($updateStmt)
    ]);

    mysqli_stmt_close($updateStmt);

    exit();
}


mysqli_stmt_close(
    $updateStmt
);




echo json_encode([
    'success' => true,
    'rated' => $rated,
    'total_ratings' => $totalRatings
]);

exit();

?>