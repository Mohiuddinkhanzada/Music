<?php
include_once '../config.php';

$id = $_GET['id'];

$query = "SELECT * FROM years WHERE year_id='$id'";
$result = mysqli_query($conn, $query);

$year = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {

    $year_duration = $_POST['year_duration'];
    $image = $_POST['image'];
    $query = "UPDATE years SET
            year_duration='$year_duration',
            image='$image'
            WHERE year_id='$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('location:all-years.php');
        exit();
    }
}

$pageTitle = 'Edit Year';
$adminPage = 'all-years';
include_once 'includes/header.php';
?>

<div class="page-heading">
    <div>
        <div class="eyebrow">Years</div>
        <h1>Edit Year</h1>
        <p>Update year information.</p>
    </div>
</div>

<div class="admin-form-card">

    <h2>Year Details</h2>

    <form method="POST" action="">

        <div class="form-group">
            <label>Year Duration</label>

           <input type="text"
       id="yearDuration" name="year_duration"  value="<?php echo $year['year_duration']; ?>"  maxlength="10">

<div class="field-error" id="yearDurationError"></div>

        </div>

<div class="form-group">
    <label>Year Image URL</label>

    <input type="url"
           name="image"
           value="<?php echo $year['image']; ?>"
           placeholder="https://...">
</div>

        <div class="form-actions">

            <button type="submit"
                    name="update"
                    class="gold-btn">
                Update Year
            </button>

            <a class="ghost-btn"
               href="all-years.php">
                Cancel
            </a>

        </div>

    </form>
<script>
document.querySelector('form').addEventListener('submit', function(e){

    var year = document.getElementById('yearDuration').value.trim();
    var error = document.getElementById('yearDurationError');

    error.textContent = '';

    if(!year){
        e.preventDefault();
        error.textContent = 'Year is required';
        return;
    }

    if(!/^[0-9\-–\s]+$/.test(year)){
        e.preventDefault();
        error.textContent = 'Only numbers and year range symbols allowed';
        return;
    }

    if(year.length > 10){
        e.preventDefault();
        error.textContent = 'Max 10 characters';
        return;
    }

});

document.getElementById('yearDuration').addEventListener('input', function(){

    var error = document.getElementById('yearDurationError');
    var value = this.value;

    if(/[^0-9\-–\s]/.test(value)){
        error.textContent = 'Only numbers and year range symbols allowed';
    }
    else if(value.length >= 10){
        error.textContent = 'Max 10 characters';
    }
    else{
        error.textContent = '';
    }

});
</script>
</div>

<?php include_once 'includes/footer.php'; ?>
