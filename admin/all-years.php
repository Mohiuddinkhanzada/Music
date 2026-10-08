<?php
include_once '../config.php';
$query = "SELECT * FROM years";
$result = mysqli_query($conn, $query);

$pageTitle = 'All Years';
$adminPage = 'all-years';
include_once 'includes/header.php';
?>

      <div class="page-heading">
        <div>
          <div class="eyebrow">Years</div>
          <h1>All Years</h1>
          <p>Era-based browsing periods.</p>
        </div>
        <a class="gold-btn" href="add-year.php">＋ Add Year</a>
      </div>

      <div class="admin-table-wrap">
        <div class="admin-table-header">
          <h2>All Eras</h2>
        </div>
        <table class="admin-table">
          <thead>
            <tr>
              <th>Era</th>
              <th>Year Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
<?php
while ($year = mysqli_fetch_assoc($result)) {
?>
<tr>
  <td>
        <strong><?php echo $year['year_duration']; ?></strong>
  </td>
  
<td>
    <?php if (!empty($year['image'])) { ?>
        <div class="avatar">
            <img src="<?php echo $year['image']; ?>" alt="">
        </div>
    <?php } ?>
</td>


    <td>
      <a href="year edit.php?id=<?php echo $year['year_id']; ?>"
   class="text-btn">
    Edit
</a>

<a href="year delete.php?id=<?php echo $year['year_id']; ?>"
   class="text-btn danger"
   style="margin-left: 7px;"
    onclick="return confirm('Are you sure you want to delete this era?')">
    Delete
</a>
    </td>

</tr>

<?php
}
?>
          </tbody>
        </table>
      </div>

<?php include_once 'includes/footer.php'; ?>
