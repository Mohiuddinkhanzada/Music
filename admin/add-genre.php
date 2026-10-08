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
if (isset($_POST['add_genre'])) {

    $genre_name = $_POST['name'];
    $image = $_POST['image'];
    $genre_select = $_POST['genre_select'];

    if ($genre_name && $genre_select) {

        $error = "Use either the text field or the dropdown, not both";

    } elseif (!$genre_name && !$genre_select) {

        $error = "Genre name is required";

    } else {

        $final_genre = $genre_name ? $genre_name : $genre_select;

        $valid_genre = false;

        foreach ($allowed_genres as $genre) {

            if (strtolower($genre) == strtolower($final_genre)) {

                $valid_genre = true;
                $final_genre = $genre;

                break;
            }
        }

    if (!$valid_genre) {

    $error = "Invalid genre name";

} else {

    $check = "SELECT * FROM genre WHERE genre_name='$final_genre'";
    $check_result = mysqli_query($conn, $check);

    if (mysqli_num_rows($check_result) > 0) {

        $error = "Genre already exists";

    } else {

        $query = "INSERT INTO genre (`genre_name`,`image`)
                  VALUES ('$final_genre','$image')";

        $result = mysqli_query($conn, $query);

        if ($result) {

            header('location:all-genres.php');
            exit();
        }
    }
}
    }
}
$pageTitle = 'Add Genre';
$adminPage = 'add-genre';
include_once 'includes/header.php';
?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Genres</div>
          <h1>Add Genre</h1>
          <p>Add a new music genre.</p>
        </div>
        <a class="ghost-btn" href="all-genres.php">← Back to Genres</a>
      </div>

      <div class="admin-form-card">
        <h2>Genre Details</h2>
        <form method="POST" action="" id="addGenreForm">
          <div class="form-group">
            <label for="genreName">Enter Genre Name</label>
            <input type="text" id="genreName" name="name" placeholder="e.g. Metal">
            <div class="field-error" id="genreNameError"></div>
          </div>
          <div class="form-group">
    <label for="genreImage">Genre Image URL</label>
    <input type="url" id="genreImage" name="image" placeholder="https://...">
</div>
          <div class="form-group">
            <label for="genreSelect">Or Select from List</label>
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
          </div>
          <div class="form-actions">
            <button type="submit" name="add_genre"class="gold-btn">Create Genre</button>
            <a class="ghost-btn" href="all-genres.php">Cancel</a>
          </div>
<?php
if (isset($error)) {
    echo '<div class="field-error">' . $error . '</div>';
}
?>
        </form>
      </div>
      <script>
      document.getElementById('addGenreForm').addEventListener('submit',function(e){
        var name=document.getElementById('genreName').value.trim();
        var sel=document.getElementById('genreSelect').value;
        var err=document.getElementById('genreNameError');
        err.textContent='';
        if(name&&sel){e.preventDefault();err.textContent='Use either the text field or the dropdown, not both';return;}
        if(!name&&!sel){e.preventDefault();err.textContent='Genre name is required';return;}
        if(name){
          if(!/^[A-Za-z\s&]+$/.test(name)){e.preventDefault();err.textContent='Only letters, spaces, and & allowed';return;}
          if(name.length>20){e.preventDefault();err.textContent='Max 20 characters';return;}
        }
      });
      document.getElementById('genreName').addEventListener('input',function(){
        var err=document.getElementById('genreNameError');
        var sel=document.getElementById('genreSelect');
        if(this.value.trim()){sel.selectedIndex=0;}
        if(this.value.length>=20)err.textContent='Max 20 characters';
        else err.textContent='';
      });
      document.getElementById('genreSelect').addEventListener('change',function(){
        var err=document.getElementById('genreNameError');
        var name=document.getElementById('genreName');
        if(this.value){name.value='';}
        err.textContent='';
      });
      </script>

<?php include_once 'includes/footer.php'; ?>
