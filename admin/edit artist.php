<?php
include_once '../config.php';



$id = $_GET['id'];

if (isset($_POST['update'])) {

    $artist_name = $_POST['artist_name'];
    $image = $_POST['image'];
    $followers = $_POST['followers'];

    $query = "UPDATE artists SET
        artist_name='$artist_name',
        image='$image',
        followers='$followers'
        WHERE artist_id='$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:all-artists.php');
        exit();
    }
}


$query = "SELECT * FROM artists WHERE artist_id='$id'";
$result = mysqli_query($conn, $query);

$artist = mysqli_fetch_assoc($result);



$pageTitle = 'Edit Artist';
$adminPage = 'all-artists';
include_once 'includes/header.php';
?>

<div class="page-heading">
    <div>
        <div class="eyebrow">Artists</div>
        <h1>Edit Artist</h1>
        <p>Update artist information.</p>
    </div>
</div>

<div class="admin-form-card">
    <h2>Artist Details</h2>

    <form method="POST" action="">

        <div class="form-group">
            <label>Artist Name</label>
           <input type="text" id="artistName" name="artist_name" value="<?php echo $artist['artist_name']; ?>" maxlength="20">
<div class="field-error" id="artistNameError"></div>
        </div>

        <div class="form-group">
            <label>Artist Image URL</label>
            <input type="url"
                   name="image"
                   value="<?php echo $artist['image']; ?>">
        </div>

        <div class="form-group">
            <label>Followers</label>
            <input type="text"
                   name="followers"
                   value="<?php echo $artist['followers']; ?>">
        </div>

        <div class="form-actions">

            <button type="submit" name="update" class="gold-btn">
                Update Artist
            </button>

            <a class="ghost-btn" href="all-artists.php">
                Cancel
            </a>

        </div>

    </form>
    <script>
document.querySelector('form').addEventListener('submit', function(e){

    var name = document.getElementById('artistName').value.trim();
    var error = document.getElementById('artistNameError');

    error.textContent = '';

    if(!name){
        e.preventDefault();
        error.textContent = 'Artist name is required';
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

document.getElementById('artistName').addEventListener('input', function(){

    var error = document.getElementById('artistNameError');
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












