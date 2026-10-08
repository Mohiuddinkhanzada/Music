<?php
include_once '../config.php';


if (isset($_POST['add_artist'])) {

    $artist_name = $_POST['name'];
    $image = $_POST['image'];
    $followers = $_POST['followers'];

    $query = "INSERT INTO artists
    (`artist_name`, `image`, `followers`)
    VALUES
    ('$artist_name', '$image', '$followers')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:all-artists.php');
        exit();
    }
}





$pageTitle = 'Add Artist';
$adminPage = 'add-artist';
include_once 'includes/header.php';
?>


      <div class="page-heading">
        <div>
          <div class="eyebrow">Artists</div>
          <h1>Add Artist</h1>
          <p>Add a new artist to the platform.</p>
        </div>
        <a class="ghost-btn" href="all-artists.php">← Back to Artists</a>
      </div>

      <div class="admin-form-card">
        <h2>Artist Details</h2>
        <form method="POST" action="" id="addArtistForm">
          <div class="form-group">
            <label for="artistName">Artist Name</label>
            <input type="text"id="artistName"name="name" placeholder="Enter artist name"  maxlength="20" required>
             <div class="field-error" id="artistNameError"></div>
          </div>
          
            <div class="form-group">
              <label for="artistImage">Artist Image URL</label>
              <input type="url" id="artistImage" name="image" placeholder="https://..." >
              <div class="field-error" id="artistImageError"></div>
            </div>
         
          <div class="form-group">
            <label for="artistFollowers">Followers</label>
            <input type="text" id="artistFollowers" name="followers" placeholder="e.g. 1M or 1K" maxlength="7">
            <div class="field-error" id="artistFollowersError"></div>
          </div>
          <div class="form-actions">
            <button type="submit" name="add_artist"class="gold-btn">Create Artist</button>
            <a class="ghost-btn" href="all-artists.php">Cancel</a>
          </div>
        </form>
      </div>
      <script>
      document.getElementById('addArtistForm').addEventListener('submit',function(e){
        var name=document.getElementById('artistName').value.trim();
        var ne=document.getElementById('artistNameError');
        ne.textContent='';
        if(!name){e.preventDefault();ne.textContent='Artist name is required';return;}
        if(!/^[A-Za-z\s]+$/.test(name)){e.preventDefault();  ne.textContent='Only letters and spaces allowed';
    return;
}
        if(name.length>20){
    e.preventDefault();
    ne.textContent='Max 20 characters';
    return;
}
        var img=document.getElementById('artistImage').value.trim();
        var ie=document.getElementById('artistImageError');
        ie.textContent='';
        if(!img){e.preventDefault();ie.textContent='Image is required';return;}
        var f=document.getElementById('artistFollowers').value.trim();
        var fe=document.getElementById('artistFollowersError');
        fe.textContent='';
        if(!f){e.preventDefault();fe.textContent='Followers is required';return;}
        if(!/^\d{1,3}(\.\d+)?[KMkm]?$/.test(f)){e.preventDefault();fe.textContent='Use 1-3 digits with optional decimal and K/M suffix (e.g. 8K, 300K, 48.85M)';return;}
      });
         document.getElementById('artistName').addEventListener('input',function(){

    var err=document.getElementById('artistNameError');
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


      document.getElementById('artistFollowers').addEventListener('input',function(){
        var err=document.getElementById('artistFollowersError');
        var v=this.value;
        if(!/^\d{0,3}(\.\d*)?[KMkm]?$/.test(v)){err.textContent='Use 1-3 digits, optional decimal and K/M suffix only';return;}
        err.textContent='';
      });
      </script>

<?php include_once 'includes/footer.php'; ?>
