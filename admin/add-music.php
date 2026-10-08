<?php
include_once '../config.php';

if (isset($_POST['add_music'])) {

    $music_name = $_POST['title'];
    $album_id = $_POST['artist_id'];
    $genre_id = $_POST['genre'];
    $year_id = $_POST['year'];
    $image = $_POST['cover'];

    $music_file = $_FILES['music_file'];

    $file_name = $music_file['name'];
    $file_tmp = $music_file['tmp_name'];

    $upload_folder = 'uploads/music/';

    if (!is_dir($upload_folder)) {
        mkdir($upload_folder, 0777, true);
    }

    move_uploaded_file($file_tmp, $upload_folder . $file_name);

    $query = "INSERT INTO music
              (`music_name`, `album_id`, `genre_id`, `year_id`, `image`, `music_file`)
              VALUES
              ('$music_name', '$album_id', '$genre_id', '$year_id', '$image', '$file_name')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:all-music.php');
        exit();
    }
}


$pageTitle = 'Add Music';
$adminPage = 'add-music';
include_once 'includes/header.php';


$sql = "SELECT * FROM `albums`";
$result = mysqli_query($conn,$sql);


$sql1 = "SELECT * FROM `genre`";
$result1 = mysqli_query($conn,$sql1);


$sql2 = "SELECT * FROM `years`";
$result2 = mysqli_query($conn,$sql2);



?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Music</div>
          <h1>Add Music</h1>
          <p>Add a new track to the library.</p>
        </div>
        <a class="ghost-btn" href="all-music.php">← Back to Music</a>
      </div>

      <div class="admin-form-card">
        <h2>Track Details</h2>
        <form method="POST" action="" id="addMusicForm"enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group">
              <label for="trackTitle">Enter Track Title</label>
              <input type="text" id="trackTitle" name="title" placeholder="Enter track title" maxlength="20">
              <div class="field-error" id="trackTitleError"></div>
            </div>
            <div class="form-group">
              <label for="trackArtist">Albums</label>
              <select id="trackArtist" name="artist_id">

                <option value="">Select Album</option>
                
                <?php while($artist = mysqli_fetch_assoc($result)){ ?>
  <option value="<?= $artist['album_id'];?>"><?= $artist['album_name']  ?></option>
<?php } ?>

              </select>
              <div class="field-error" id="trackArtistError"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="trackGenre">Genre</label>
              <select id="trackGenre" name="genre">
                <option value="">Select genre</option>
  <?php while($genre = mysqli_fetch_assoc($result1)){ ?>
<option value="<?= $genre['genre_id'];?>">
<?= $genre['genre_name']  ?>
</option>
<?php } ?>
  </select>

              <div class="field-error" id="trackGenreError"></div>
            </div>
            <div class="form-group">
              <label for="trackYear">Year</label>
              <select id="trackYear" name="year">
                <option value="">Select year</option>
<?php while($years = mysqli_fetch_assoc($result2)){ ?>
<option value="<?= $years['year_id']; ?>">
<?= $years['year_duration']; ?>
</option>
<?php } ?>       
</select>
             <div class="field-error" id="trackYearError"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="trackCover">Music Image URL</label>
              <input type="url" id="trackCover" name="cover" placeholder="https://...">
               <div class="field-error" id="trackCoverError"></div>
            </div>
            <div class="form-group">
              <label for="trackFile">Add Music File</label>
              <input type="file" id="trackFile" name="music_file" >
               <div class="field-error" id="trackFileError"></div>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit"  name="add_music" class="gold-btn">Create Track</button>
            <a class="ghost-btn" href="all-music.php">Cancel</a>
          </div>
        </form>
      </div>

<script>
document.getElementById('addMusicForm').addEventListener('submit',function(e){

    var valid=true;

    var title=document.getElementById('trackTitle').value.trim();
    var te=document.getElementById('trackTitleError');

    te.textContent='';

    if(!title){
        e.preventDefault();
        te.textContent='Track title is required';
        valid=false;
    }
    else if(/[^A-Za-z\s]/.test(title)){
        e.preventDefault();
        te.textContent='Only letters and spaces allowed';
        valid=false;
    }
    else if(title.length>20){
        e.preventDefault();
        te.textContent='Max 20 characters';
        valid=false;
    }

    var ae=document.getElementById('trackArtistError');
    var ge=document.getElementById('trackGenreError');
    var ye=document.getElementById('trackYearError');
    var ce=document.getElementById('trackCoverError');
    var fe=document.getElementById('trackFileError');

    ae.textContent='';
    ge.textContent='';
    ye.textContent='';
    ce.textContent='';
    fe.textContent='';

    if(!document.getElementById('trackArtist').value){
        e.preventDefault();
        ae.textContent='Please select an artist';
        valid=false;
    }

    if(!document.getElementById('trackGenre').value){
        e.preventDefault();
        ge.textContent='Please select a genre';
        valid=false;
    }

    if(!document.getElementById('trackYear').value){
        e.preventDefault();
        ye.textContent='Please select a year';
        valid=false;
    }

    if(!document.getElementById('trackCover').value){
        e.preventDefault();
        ce.textContent='Please enter image URL';
        valid=false;
    }

    if(!document.getElementById('trackFile').files.length){
        e.preventDefault();
        fe.textContent='Please select music file';
        valid=false;
    }

});


document.getElementById('trackTitle').addEventListener('input',function(){

    var err=document.getElementById('trackTitleError');
    var v=this.value;

    if(/[^A-Za-z\s]/.test(v)){
        err.textContent='Only letters and spaces allowed';
    }
    else if(v.length>=20){
        err.textContent='Max 20 characters';
    }
    else{
        err.textContent='';
    }

});


document.getElementById('trackArtist').addEventListener('change',function(){

    document.getElementById('trackArtistError').textContent=
    this.value?'':'Please select an artist';

});


document.getElementById('trackGenre').addEventListener('change',function(){

    document.getElementById('trackGenreError').textContent=
    this.value?'':'Please select a genre';

});


document.getElementById('trackYear').addEventListener('change',function(){

    document.getElementById('trackYearError').textContent=
    this.value?'':'Please select a year';

});
</script>
<?php include_once 'includes/footer.php'; ?>
