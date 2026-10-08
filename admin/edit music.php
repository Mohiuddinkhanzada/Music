<?php
include_once '../config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM albums";
$album_result = mysqli_query($conn, $sql);

$sql1 = "SELECT * FROM genre";
$genre_result = mysqli_query($conn, $sql1);

$sql2 = "SELECT * FROM years";
$year_result = mysqli_query($conn, $sql2);

$query = "SELECT * FROM music WHERE music_id='$id'";
$result = mysqli_query($conn, $query);

$music = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $music_name = $_POST['music_name'];
    $album_id = $_POST['album_id'];
    $genre_id = $_POST['genre_id'];
    $year_id = $_POST['year_id'];
    $image = $_POST['image'];

    $music_file = $music['music_file'];

    if (!empty($_FILES['music_file']['name'])) {

        $file_name = $_FILES['music_file']['name'];
        $file_tmp = $_FILES['music_file']['tmp_name'];

        $upload_folder = 'uploads/music/';

        if (!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777, true);
        }

        move_uploaded_file($file_tmp, $upload_folder . $file_name);

        $music_file = $file_name;
    }

    $query = "UPDATE music SET
              music_name='$music_name',
              album_id='$album_id',
              genre_id='$genre_id',
              year_id='$year_id',
              image='$image',
              music_file='$music_file'
              WHERE music_id='$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:all-music.php');
        exit();
    }
}

$pageTitle = 'Edit Music';
$adminPage = 'all-music';
include_once 'includes/header.php';
?>

<div class="page-heading">
    <div>
        <div class="eyebrow">Music</div>
        <h1>Edit Music</h1>
        <p>Update music information.</p>
    </div>
</div>

<div class="admin-form-card">

    <h2>Track Details</h2>

    <form method="POST"
          action=""
          enctype="multipart/form-data">

        <div class="form-group">
            <label>Track Title</label>

    <input type="text"
       id="trackTitle"
       name="music_name"
       value="<?php echo $music['music_name']; ?>"
       maxlength="20">
        </div>

 <div class="field-error" id="trackTitleError"></div>       

        <div class="form-group">
            <label>Album</label>

            <select name="album_id">

                <option value="">Select Album</option>

                <?php while($album = mysqli_fetch_assoc($album_result)){ ?>

                    <option value="<?php echo $album['album_id']; ?>"
                        <?php if($music['album_id'] == $album['album_id']) echo 'selected'; ?>>
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
                        <?php if($music['genre_id'] == $genre['genre_id']) echo 'selected'; ?>>
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
                        <?php if($music['year_id'] == $year['year_id']) echo 'selected'; ?>>
                        <?php echo $year['year_duration']; ?>
                    </option>

                <?php } ?>

            </select>
        </div>

        <div class="form-group">
            <label>Music Image URL</label>

            <input type="url"
                   name="image"
                   value="<?php echo $music['image']; ?>"
                   placeholder="https://...">
        </div>

        <div class="form-group">
            <label>Music File</label>

            <input type="file"
                   name="music_file"
                   accept="audio/*">

            <div>
                Current File:
                <?php echo $music['music_file']; ?>
            </div>
        </div>

        <div class="form-actions">

            <button type="submit"
                    name="update"
                    class="gold-btn">
                Update Music
            </button>

            <a class="ghost-btn"
               href="all-music.php">
                Cancel
            </a>

        </div>

    </form>
<script>
document.getElementById('trackTitle').addEventListener('input', function(){

    var err = document.getElementById('trackTitleError');
    var v = this.value;

    if(/[^A-Za-z\s]/.test(v)){
        err.textContent = 'Only letters and spaces allowed';
    }
    else if(v.length >= 20){
        err.textContent = 'Max 20 characters';
    }
    else{
        err.textContent = '';
    }

});

document.querySelector('form').addEventListener('submit', function(e){

    var title = document.getElementById('trackTitle').value.trim();
    var err = document.getElementById('trackTitleError');

    err.textContent = '';

    if(!title){
        e.preventDefault();
        err.textContent = 'Track title is required';
        return;
    }

    if(/[^A-Za-z\s]/.test(title)){
        e.preventDefault();
        err.textContent = 'Only letters and spaces allowed';
        return;
    }

    if(title.length > 20){
        e.preventDefault();
        err.textContent = 'Max 20 characters';
        return;
    }

});
</script>
</div>

<?php include_once 'includes/footer.php'; ?>
