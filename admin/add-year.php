<?php
include_once '../config.php';
if (isset($_POST['add_year'])) {

    $year_duration = $_POST['label'];
    $image = $_POST['image'];

    $new_year = preg_replace('/\s+/', '', $year_duration);

    preg_match('/^(\d{4})/', $new_year, $new_match);

    $new_start_year = isset($new_match[1]) ? $new_match[1] : '';

    $duplicate = false;

    $check = "SELECT year_duration FROM years";
    $check_result = mysqli_query($conn, $check);

    while ($existing = mysqli_fetch_assoc($check_result)) {

        $existing_year = preg_replace('/\s+/', '', $existing['year_duration']);

        preg_match('/^(\d{4})/', $existing_year, $existing_match);

        if (isset($existing_match[1]) && $existing_match[1] == $new_start_year) {
            $duplicate = true;
            break;
        }
    }

    if ($duplicate) {

        $error = "Year already exists";

    } else {

        $query = "INSERT INTO years (`year_duration`, `image`)
                  VALUES ('$year_duration', '$image')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            header('location:all-years.php');
            exit();
        }
    }
}

$pageTitle = 'Add Year';
$adminPage = 'add-year';
include_once 'includes/header.php';
?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Years</div>
          <h1>Add Year</h1>
          <p>Add a new era range.</p>
        </div>
        <a class="ghost-btn" href="all-years.php">← Back to Years</a>
      </div>

      <div class="admin-form-card">
        <h2>Era Details</h2>
        <form method="POST" action="" id="addYearForm">
          <div class="form-group">
            <label for="yearLabel">Enter Era</label>
            <input type="text" id="yearLabel" name="label" placeholder="e.g. 2020–2025" maxlength="11">
            <div class="field-error" id="yearLabelError"></div>
          </div>

<div class="form-group">
    <label for="yearImage">Year Image URL</label>
    <input type="url"id="yearImage"name="image"placeholder="https://...">
</div>
          
          <div class="form-actions">
            <button type="submit"  name="add_year"class="gold-btn">Create Era</button>
            <a class="ghost-btn" href="all-years.php">Cancel</a>
          </div>
<?php
if (isset($error)) {
    echo '<div class="field-error">' . $error . '</div>';
}
?>


        </form>
      </div>

      <script>
      document.getElementById('addYearForm').addEventListener('submit',function(e){
        var v=document.getElementById('yearLabel').value.trim();
        var err=document.getElementById('yearLabelError');
        err.textContent='';
        if(!v){e.preventDefault();err.textContent='Era is required';}
        else if(/[^0-9\-–\s]/.test(v)){e.preventDefault();err.textContent='Only numbers are allowed';}
      });
      document.getElementById('yearLabel').addEventListener('input',function(){
        var err=document.getElementById('yearLabelError');
        if(/[^0-9\-–\s]/.test(this.value)){err.textContent='Only numbers are allowed';}
        else{err.textContent='';}
      });
      </script>

<?php include_once 'includes/footer.php'; ?>
