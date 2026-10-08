<?php
include_once '../config.php';
$sql = "SELECT * FROM artists";
$result = mysqli_query($conn, $sql);

if (isset($_POST['add_album'])) {

    $album_name = $_POST['name'];
    $image = $_POST['cover'];
   $artist_name = $_POST['artist_name'];
   $language = $_POST['language'];


    $check = "SELECT * FROM albums WHERE album_name='$album_name'";
    $check_result = mysqli_query($conn, $check);

    if (mysqli_num_rows($check_result) > 0) {

        $error = "Album already exists";

    } else {

        $query = "INSERT INTO albums
        (`album_name`, `image`, `artist_name`, `language`)
        VALUES
        ('$album_name', '$image', '$artist_name', '$language')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            header('location:all-albums.php');
            exit();
        }
    }
}


$pageTitle = 'Add Album';
$adminPage = 'add-album';
include_once 'includes/header.php';
?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Albums</div>
          <h1>Add Album</h1>
          <p>Create a new language album.</p>
        </div>
        <a class="ghost-btn" href="all-albums.php">← Back to Albums</a>
      </div>

      <div class="admin-form-card">
        <h2>Album Details</h2>
        <form method="POST" action="" id="addAlbumForm">
          <div class="form-row">
            <div class="form-group">
              <label for="albumName">Album Name</label>
             <input type="text"id="albumName"name="name"placeholder="e.g. Arzu etc" maxlength="20">
<div class="field-error" id="albumNameError"></div>
            </div>
            <div class="form-group">
              <label for="albumCover">Album Image URL</label>
              <input type="url" id="albumCover" name="cover" placeholder="https://...">
            </div>
</div>
<div class="form-row">

    <div class="form-group">
        <label for="albumArtist">Artist</label>

        <select id="albumArtist" name="artist_name" required>
            <option value="">Select Artist</option>

            <?php while($artist = mysqli_fetch_assoc($result)){ ?>

                <option value="<?php echo $artist['artist_name']; ?>">
                    <?php echo $artist['artist_name']; ?>
                </option>

            <?php } ?>

        </select>
    </div>

    <div class="form-group">
        <label for="albumLanguage">Language</label>

        <select id="albumLanguage" name="language" required>
            <option value="">Select Language</option>
            <option value="Urdu">Urdu</option>
            <option value="Sindhi">Sindhi</option>
            <option value="Punjabi">Punjabi</option>
            <option value="Pashto">Pashto</option>
            <option value="Balochi">Balochi</option>
            <option value="English">English</option>
        </select>
    </div>

</div>
          <div class="form-actions">
            <button type="submit" name="add_album" class="gold-btn">Create Album</button>
            <a class="ghost-btn" href="all-albums.php">Cancel</a>
          </div>
          <?php
      if (isset($error)) {
    echo '<div class="field-error">' . $error . '</div>';
}
?>
        </form>
      </div>
     
     <script>
document.getElementById('addAlbumForm').addEventListener('submit',function(e){

    var name = document.getElementById('albumName').value.trim();
    var ne = document.getElementById('albumNameError');

    ne.textContent = '';

    if(!name){
        e.preventDefault();
        ne.textContent = 'Album name is required';
        return;
    }

    if(!/^[A-Za-z\s]+$/.test(name)){
        e.preventDefault();
        ne.textContent = 'Only letters and spaces allowed';
        return;
    }

    if(name.length > 20){
        e.preventDefault();
        ne.textContent = 'Max 20 characters';
        return;
    }

});
</script>

<?php include_once 'includes/footer.php'; ?>
