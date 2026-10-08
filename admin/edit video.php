<?php
include_once '../config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM albums";
$album_result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM genre";
$genre_result = mysqli_query($conn, $sql1);

$sql2 = "SELECT * FROM years";
$year_result = mysqli_query($conn, $sql2);

$query = "SELECT * FROM videos WHERE video_id='$id'";
$result = mysqli_query($conn, $query);

$video = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $video_name = $_POST['video_name'];
    $album_id = $_POST['album_id'];
    $genre_id = $_POST['genre_id'];
    $year_id = $_POST['year_id'];
    $image = $_POST['image'];

    $video_file = $video['video_file'];

    if (!empty($_FILES['video_file']['name'])) {

        $file_name = $_FILES['video_file']['name'];
        $file_tmp = $_FILES['video_file']['tmp_name'];

        $upload_folder = 'uploads/videos/';

        if (!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }

        move_uploaded_file($file_tmp, $upload_folder . $file_name);

        $video_file = $file_name;
    }

    $query = "UPDATE videos SET
              video_name='$video_name',
              album_id='$album_id',
              genre_id='$genre_id',
              year_id='$year_id',
              image='$image',
              video_file='$video_file'
              WHERE video_id='$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:all-videos.php');
        exit();
    }
}

$pageTitle = 'Edit Video';
$adminPage = 'all-videos';
include_once 'includes/header.php';
?>

<div class="page-heading">
    <div>
        <div class="eyebrow">Videos</div>
        <h1>Edit Video</h1>
        <p>Update video information.</p>
    </div>
</div>

<div class="admin-form-card">

    <h2>Video Details</h2>

    <form method="POST"
          action=""
          enctype="multipart/form-data">

        <div class="form-group">
            <label>Video Title</label>

            <input type="text"
                   id="videoTitle"
                   name="video_name"
                   value="<?php echo $video['video_name']; ?>"
                   maxlength="20">

            <div class="field-error" id="videoTitleError"></div>
        </div>

        <div class="form-group">
            <label>Album</label>

            <select name="album_id">

                <option value="">Select Album</option>

                <?php while($album = mysqli_fetch_assoc($album_result)){ ?>

                    <option value="<?php echo $album['album_id']; ?>"
                        <?php if($video['album_id'] == $album['album_id']) echo 'selected'; ?>>
                        <?php echo $album['album_name']; ?>
                    </option>

                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label>Genre</label>

            <select name="genre_id">

                <option value="">Select Genre</option>

                <?php while($genre = mysqli_fetch_assoc($genre_result)){ ?>

                    <option value="<?php echo $genre['genre_id']; ?>"
                        <?php if($video['genre_id'] == $genre['genre_id']) echo 'selected'; ?>>
                        <?php echo $genre['genre_name']; ?>
                    </option>

                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label>Year</label>

            <select name="year_id">

                <option value="">Select Year</option>

                <?php while($year = mysqli_fetch_assoc($year_result)){ ?>

                    <option value="<?php echo $year['year_id']; ?>"
                        <?php if($video['year_id'] == $year['year_id']) echo 'selected'; ?>>
                        <?php echo $year['year_duration']; ?>
                    </option>

                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label>Video Image URL</label>

            <input type="url"
                   name="image"
                   value="<?php echo $video['image']; ?>"
                   placeholder="https://...">

            <div class="field-error" id="videoImageError"></div>
        </div>

        <div class="form-group">
            <label>Video File</label>

            <input type="file"
                   name="video_file"
                   accept="video/*">

            <div>
                Current File:
                <?php echo $video['video_file']; ?>
            </div>
        </div>

        <div class="form-actions">

            <button type="submit"
                    name="update"
                    class="gold-btn">
                Update Video
            </button>

            <a class="ghost-btn"
               href="all-videos.php">
                Cancel
            </a>

        </div>

        <script>
        document.querySelector('form').addEventListener('submit', function(e){

            var title = document.getElementById('videoTitle').value.trim();
            var titleError = document.getElementById('videoTitleError');

            titleError.textContent = '';

            if(!title){
                e.preventDefault();
                titleError.textContent = 'Video title is required';
                return;
            }

            if(/[^A-Za-z\s]/.test(title)){
                e.preventDefault();
                titleError.textContent = 'Only letters and spaces allowed';
                return;
            }

            if(title.length > 20){
                e.preventDefault();
                titleError.textContent = 'Max 20 characters';
                return;
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
        </script>

    </form>

</div>

<?php include_once 'includes/footer.php'; ?>
