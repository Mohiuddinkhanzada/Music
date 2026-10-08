<?php
include_once '../config.php';
$sql = "SELECT * FROM artists";
$artist_result = mysqli_query($conn, $sql);

$id = $_GET['id'];

$query = "SELECT * FROM albums WHERE album_id='$id'";
$result = mysqli_query($conn, $query);

$album = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $album_name = $_POST['album_name'];
    $image = $_POST['image'];
    $artist_name = $_POST['artist_name'];
    $language = $_POST['language'];

    $query = "UPDATE albums SET
              album_name='$album_name',
              image='$image',
              artist_name='$artist_name',
              language='$language'
              WHERE album_id='$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:all-albums.php');
        exit();
    }
}

$pageTitle = 'Edit Album';
$adminPage = 'all-albums';
include_once 'includes/header.php';
?>

<div class="page-heading">
    <div>
        <div class="eyebrow">Albums</div>
        <h1>Edit Album</h1>
        <p>Update album information.</p>
    </div>
</div>

<div class="admin-form-card">
    <h2>Album Details</h2>

    <form method="POST" action="">

        <div class="form-group">
            <label>Album Name</label>
           <input type="text"id="albumName"name="album_name"value="<?php echo $album['album_name']; ?>"maxlength="20">
<div class="field-error" id="albumNameError"></div>
        </div>

        <div class="form-group">
            <label>Album Image URL</label>
            <input type="url"
                   name="image"
                   value="<?php echo $album['image']; ?>">
        </div>
    <div class="form-group">
    <label>Artist</label>

    <select name="artist_name">
        <option value="">Select Artist</option>

        <?php while($artist = mysqli_fetch_assoc($artist_result)){ ?>

            <option value="<?php echo $artist['artist_name']; ?>"
                <?php if($album['artist_name'] == $artist['artist_name']) echo 'selected'; ?>>
                <?php echo $artist['artist_name']; ?>
            </option>

        <?php } ?>

    </select>
</div>

<div class="form-group">
    <label>Language</label>

    <select name="language">
    <option value="">Select Language</option>
     <option value="Urdu" <?php if($album['language'] == 'Urdu') echo 'selected'; ?>>Urdu</option>
    <option value="Sindhi" <?php if($album['language'] == 'Sindhi') echo 'selected'; ?>>Sindhi</option>
    <option value="Punjabi" <?php if($album['language'] == 'Punjabi') echo 'selected'; ?>>Punjabi</option>
    <option value="Pashto" <?php if($album['language'] == 'Pashto') echo 'selected'; ?>>Pashto</option>
    <option value="Balochi" <?php if($album['language'] == 'Balochi') echo 'selected'; ?>>Balochi</option>
    <option value="English" <?php if($album['language'] == 'English') echo 'selected'; ?>>English</option>
    </select>
</div>




        <div class="form-actions">

            <button type="submit" name="update" class="gold-btn">
                Update Album
            </button>

            <a class="ghost-btn" href="all-albums.php">
                Cancel
            </a>

        </div>

    </form>

    <script>
document.querySelector('form').addEventListener('submit', function(e){

    var name = document.getElementById('albumName').value.trim();
    var error = document.getElementById('albumNameError');

    error.textContent = '';

    if(!name){
        e.preventDefault();
        error.textContent = 'Album name is required';
        return;
    }

    if(!/^[A-Za-z\s]+$/.test(name)){
        e.preventDefault();
        error.textContent = 'Only letters and spaces allowed';
        return;
    }

    if(name.length > 20){
        e.preventDefault();
        error.textContent = 'Max 20 characters';
        return;
    }

});

document.getElementById('albumName').addEventListener('input', function(){

    var error = document.getElementById('albumNameError');
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

</div>
<?php include_once 'includes/footer.php'; ?>
