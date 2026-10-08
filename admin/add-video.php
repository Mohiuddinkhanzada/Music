<?php
include_once '../config.php';

if (isset($_POST['add_video'])) {

    $video_name = $_POST['title'];
    $album_id = $_POST['artist_id'];
    $genre_id = $_POST['genre'];
    $year_id = $_POST['year'];
    $image = $_POST['cover'];

    $video_file = $_FILES['video_file'];

    $file_name = $video_file['name'];
    $file_tmp = $video_file['tmp_name'];

    $upload_folder = 'uploads/videos/';

    if (!is_dir($upload_folder)) {
        mkdir($upload_folder, 0777, true);
    }

    move_uploaded_file($file_tmp, $upload_folder . $file_name);

    $query = "INSERT INTO videos
              (`video_name`, `album_id`, `genre_id`, `year_id`, `image`, `video_file`)
              VALUES
              ('$video_name', '$album_id', '$genre_id', '$year_id', '$image', '$file_name')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:all-videos.php');
        exit();
    }
}

$pageTitle = 'Add Video';
$adminPage = 'add-video';
include_once 'includes/header.php';

$sql = "SELECT * FROM `albums`";
$result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM `genre`";
$result1 = mysqli_query($conn, $sql1);

$sql2 = "SELECT * FROM `years`";
$result2 = mysqli_query($conn, $sql2);


?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Videos</div>
          <h1>Add Video</h1>
          <p>Add a new video to the library.</p>
        </div>
        <a class="ghost-btn" href="all-videos.php">← Back to Videos</a>
      </div>

      <div class="admin-form-card">
        <h2>Video Details</h2>
        <form method="POST" action="" id="addVideoForm"enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group">
              <label for="videoTitle">Enter Video Title</label>
              <input type="text" id="videoTitle" name="title" placeholder="Enter video title" maxlength="20">
              <div class="field-error" id="videoTitleError"></div>
            </div>
           <div class="form-group">
    <label for="videoArtist">Albums</label>
<select id="videoArtist" name="artist_id">

<option value="">Select Album</option>
<?php while($artist = mysqli_fetch_assoc($result)){ ?>
<option value="<?= $artist['album_id']; ?>">
<?= $artist['album_name']; ?>
</option>
 <?php } ?>
</select>
    <div class="field-error" id="videoArtistError"></div>

</div>
</div>
          <div class="form-row">
            <div class="form-group">
              <label for="videoGenre">Genre</label>
             <select id="videoGenre" name="genre">

    <option value="">Select genre</option>

    <?php while($genre = mysqli_fetch_assoc($result1)){ ?>

        <option value="<?= $genre['genre_id']; ?>">
            <?= $genre['genre_name']; ?>
        </option>

    <?php } ?>

</select>
              <div class="field-error" id="videoGenreError"></div>
            </div>
            <div class="form-group">
              <label for="videoYear">Year</label>
              <select id="videoYear" name="year">

    <option value="">Select year</option>

    <?php while($years = mysqli_fetch_assoc($result2)){ ?>

        <option value="<?= $years['year_id']; ?>">
            <?= $years['year_duration']; ?>
        </option>

    <?php } ?>

</select>
              <div class="field-error" id="videoYearError"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="videoCover">Image Video URL</label>
              <input type="url" id="videoCover" name="cover" placeholder="https://...">
              <div class="field-error" id="videoCoverError"></div>
            </div>
            <div class="form-group">
              <label for="videoFile">Add Video File</label>
              <input type="file" id="videoFile" name="video_file" accept="video/*">
              <div class="field-error" id="videoFileError"></div>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" name="add_video" class="gold-btn">Create Video</button>
            <a class="ghost-btn" href="all-videos.php">Cancel</a>
          </div>
        </form>
      </div>

      <script>
document.getElementById('addVideoForm').addEventListener('submit', function(e){

    var valid = true;

    var title = document.getElementById('videoTitle').value.trim();
    var titleError = document.getElementById('videoTitleError');

    titleError.textContent = '';

    if(!title){
        e.preventDefault();
        titleError.textContent = 'Video title is required';
        valid = false;
    }
    else if(/[^A-Za-z\s]/.test(title)){
        e.preventDefault();
        titleError.textContent = 'Only letters and spaces allowed';
        valid = false;
    }
    else if(title.length > 20){
        e.preventDefault();
        titleError.textContent = 'Max 20 characters';
        valid = false;
    }


    var albumError = document.getElementById('videoArtistError');
    var genreError = document.getElementById('videoGenreError');
    var yearError = document.getElementById('videoYearError');
    var coverError = document.getElementById('videoCoverError');
    var fileError = document.getElementById('videoFileError');

    albumError.textContent = '';
    genreError.textContent = '';
    yearError.textContent = '';
    coverError.textContent = '';
    fileError.textContent = '';


    if(!document.getElementById('videoArtist').value){
        e.preventDefault();
        albumError.textContent = 'Please select an album';
        valid = false;
    }


    if(!document.getElementById('videoGenre').value){
        e.preventDefault();
        genreError.textContent = 'Please select a genre';
        valid = false;
    }


    if(!document.getElementById('videoYear').value){
        e.preventDefault();
        yearError.textContent = 'Please select a year';
        valid = false;
    }


    if(!document.getElementById('videoCover').value){
        e.preventDefault();
        coverError.textContent = 'Please enter image URL';
        valid = false;
    }


    if(!document.getElementById('videoFile').files.length){
        e.preventDefault();
        fileError.textContent = 'Please select video file';
        valid = false;
    }

});


document.getElementById('videoTitle').addEventListener('input', function(){

    var error = document.getElementById('videoTitleError');
    var value = this.value;

    if(/[^A-Za-z\s]/.test(value)){
        error.textContent = 'Only letters and spaces allowed';
    }
    else if(value.length >= 20){
        error.textContent = 'Max 20 characters';
    }
    else{
        error.textContent = '';
    }

});


document.getElementById('videoArtist').addEventListener('change', function(){

    document.getElementById('videoArtistError').textContent =
    this.value ? '' : 'Please select an album';

});


document.getElementById('videoGenre').addEventListener('change', function(){

    document.getElementById('videoGenreError').textContent =
    this.value ? '' : 'Please select a genre';

});


document.getElementById('videoYear').addEventListener('change', function(){

    document.getElementById('videoYearError').textContent =
    this.value ? '' : 'Please select a year';

});
</script>

<?php include_once 'includes/footer.php'; ?>
