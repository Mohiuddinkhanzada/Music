<?php
include_once '../config.php';

$allowed_genres = [
    'Pop',
    'Rock',
    'Folk',
    'Sufi',
    'Hip Hop',
    'R&B',
    'Electronic',
    'Classical',
    'Jazz',
    'Indie'
];

$id = $_GET['id'];

$query = "SELECT * FROM genre WHERE genre_id='$id'";
$result = mysqli_query($conn, $query);

$current_genre = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $genre_name = $_POST['genre_name'];
    $genre_select = $_POST['genre_select'];
    $image = $_POST['image'];

    if ($genre_name && $genre_select) {

        $error = "Use either the text field or the dropdown, not both";

    } elseif (!$genre_name && !$genre_select) {

        $error = "Genre name is required";

    } else {

        $final_genre = $genre_name ? $genre_name : $genre_select;

        $valid_genre = false;

        foreach ($allowed_genres as $allowed) {

            if (strtolower($allowed) == strtolower($final_genre)) {

                $valid_genre = true;
                $final_genre = $allowed;

                break;
            }
        }

        if (!$valid_genre) {

            $error = "Invalid genre name";

        } else {

            $check = "SELECT * FROM genre
                      WHERE LOWER(genre_name) = LOWER('$final_genre')
                      AND genre_id != '$id'";

            $check_result = mysqli_query($conn, $check);

            if (mysqli_num_rows($check_result) > 0) {

                $error = "Genre already exists";

            } else {

                $query = "UPDATE genre SET
                          genre_name='$final_genre',
                          image='$image'
                          WHERE genre_id='$id'";

                $result = mysqli_query($conn, $query);

                if ($result) {
                    header('location:all-genres.php');
                    exit();
                }
            }
        }
    }
}

$pageTitle = 'Edit Genre';
$adminPage = 'all-genres';
include_once 'includes/header.php';
?>

<div class="page-heading">
    <div>
        <div class="eyebrow">Genres</div>
        <h1>Edit Genre</h1>
        <p>Update genre information.</p>
    </div>
</div>

<div class="admin-form-card">

    <h2>Genre Details</h2>

    <form method="POST" action="">

        <div class="form-group">
            <label>Genre Name</label>

            <input type="text"
                   id="genreName"
                   name="genre_name"
                   value="<?php echo $current_genre['genre_name']; ?>">

            <div class="field-error" id="genreNameError">
                <?php
                if (isset($error)) {
                    echo $error;
                }
                ?>
            </div>
        </div>

        <div class="form-group">
            <label>Genre Image URL</label>

            <input type="url"
                   name="image"
                   value="<?php echo $current_genre['image']; ?>"
                   placeholder="https://...">
        </div>

        <div class="form-group">
            <label>Or Select from List</label>

            <select id="genreSelect" name="genre_select">

                <option value="">Choose a genre</option>

                <option value="Pop">Pop</option>
                <option value="Rock">Rock</option>
                <option value="Folk">Folk</option>
                <option value="Sufi">Sufi</option>
                <option value="Hip Hop">Hip Hop</option>
                <option value="R&amp;B">R&amp;B</option>
                <option value="Electronic">Electronic</option>
                <option value="Classical">Classical</option>
                <option value="Jazz">Jazz</option>
                <option value="Indie">Indie</option>

            </select>

            <div class="field-error" id="genreSelectError"></div>
        </div>

        <div class="form-actions">

            <button type="submit"
                    name="update"
                    class="gold-btn">
                Update Genre
            </button>

            <a class="ghost-btn"
               href="all-genres.php">
                Cancel
            </a>

        </div>

        <script>

        document.querySelector('form').addEventListener('submit', function(e){

            var name = document.getElementById('genreName').value.trim();
            var select = document.getElementById('genreSelect');
            var error = document.getElementById('genreNameError');

            error.textContent = '';

            if (name && select.value) {

                e.preventDefault();
                error.textContent = 'Use either the text field or the dropdown, not both';
                return;

            }

            if (!name && !select.value) {

                e.preventDefault();
                error.textContent = 'Genre name is required';
                return;

            }

        });


        document.getElementById('genreName').addEventListener('input', function(){

            var select = document.getElementById('genreSelect');

            if (this.value.trim()) {
                select.selectedIndex = 0;
            }

        });


        document.getElementById('genreSelect').addEventListener('change', function(){

            var name = document.getElementById('genreName');

            if (this.value) {
                name.value = '';
            }

        });

        </script>

    </form>

</div>

<?php include_once 'includes/footer.php'; ?>
