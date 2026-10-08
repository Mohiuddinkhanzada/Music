<?php
include_once '../config.php';

$pageTitle = 'Dashboard';
$adminPage = 'dashboard';
include_once 'includes/header.php';

$query = "SELECT COUNT(*) as count FROM `artists`";
$result = mysqli_query($conn,$query);
$all_artists = mysqli_fetch_assoc($result);


$query1 = "SELECT COUNT(*) as count FROM `albums`";
$result1 = mysqli_query($conn,$query1);
$all_alubms = mysqli_fetch_assoc($result1);


$query2 = "SELECT COUNT(*) as count FROM `music`";
$result2 = mysqli_query($conn,$query2);
$all_musics = mysqli_fetch_assoc($result2);

$query3 = "SELECT COUNT(*) as count FROM `videos`";
$result3 = mysqli_query($conn,$query3);
$all_videos = mysqli_fetch_assoc($result3);

$query4 = "SELECT COUNT(*) as count FROM `users`";
$result4 = mysqli_query($conn,$query4);
$all_user = mysqli_fetch_assoc($result4);


$query5 = "SELECT COUNT(*) as count FROM `genre`";
$result5 = mysqli_query($conn,$query5);
$all_genre = mysqli_fetch_assoc($result5);


$query6 = "SELECT COUNT(*) as count FROM `years`";
$result6 = mysqli_query($conn,$query6);
$all_year = mysqli_fetch_assoc($result6);

?>

      <div class="stat-grid">
        <div class="stat-card">
          <div class="stat-icon green">♫</div>
          <div class="stat-info">
            <div class="stat-value"><?= $all_musics['count'] ?></div>
            <div class="stat-label">Total Music</div>
            <div class="stat-change">+12 this week</div>
          </div>
        </div>

        <div class="stat-card">
      <div class="stat-icon blue">▶</div>
       <div class="stat-info">
      <div class="stat-value"><?= $all_videos['count']; ?></div>
      <div class="stat-label">Total Videos</div>
      <div class="stat-change">+8 this week</div>
       </div>
       </div>

        <div class="stat-card">
          <div class="stat-icon purple">▣</div>
          <div class="stat-info">
            <div class="stat-value"><?= $all_alubms['count'] ?></div>
            <div class="stat-label">All Albums</div>
            <div class="stat-change"> All Artist Albums</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon orange">●</div>
          <div class="stat-info">
           <div class="stat-value"><?= $all_user['count'] ?></div>
            <div class="stat-label">Total Users</div>
            <div class="stat-change">+4 this week</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon pink">♫</div>
          <div class="stat-info">
            <div class="stat-value"><?= $all_artists['count']; ?></div>
            <div class="stat-label">Total Artists</div>
            <div class="stat-change">+2 this week</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon purple">◈</div>
          <div class="stat-info">
            <div class="stat-value"><?= $all_genre['count']; ?></div>
            <div class="stat-label">Total Genres</div>
            <div class="stat-change">Pop, Rock, Folk, Sufi, Hip Hop, R&amp;B, Electronic</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon blue">◷</div>
          <div class="stat-info">
              <div class="stat-value"><?= $all_year['count']; ?></div>
            <div class="stat-label">Total Eras</div>
            <div class="stat-change">2000 – 2026</div>
          </div>
        </div>
      </div>

      <div class="panel-grid">
        <div class="panel">
          <div class="panel-header">
            <h2>Recent Activity</h2>
          </div>
          <div class="panel-body">
            <ul class="activity-list">
              <li class="activity-item">
                <span class="activity-dot"></span>
                <div>
                  <div class="activity-text"><strong>New user registered:</strong> Saad signed up</div>
                  <div class="activity-time">2 minutes ago</div>
                </div>
              </li>
              <li class="activity-item">
                <span class="activity-dot" style="background:#60a5fa"></span>
                <div>
                  <div class="activity-text"><strong>New artist added:</strong> Atif Aslam</div>
                  <div class="activity-time">15 minutes ago</div>
                </div>
              </li>
              <li class="activity-item">
                <span class="activity-dot" style="background:#a78bfa"></span>
                <div>
                  <div class="activity-text"><strong>Review posted:</strong> 5-star review on "Aadat"</div>
                  <div class="activity-time">1 hour ago</div>
                </div>
              </li>
              <li class="activity-item">
                <span class="activity-dot" style="background:#fb923c"></span>
                <div>
                  <div class="activity-text"><strong>Music uploaded:</strong> "Mahi Ve" by Malkoo</div>
                  <div class="activity-time">3 hours ago</div>
                </div>
              </li>
              <li class="activity-item">
                <span class="activity-dot" style="background:#f472b6"></span>
                <div>
                  <div class="activity-text"><strong>New user registered:</strong> Ali signed up</div>
                  <div class="activity-time">5 hours ago</div>
                </div>
              </li>
            </ul>
          </div>
        </div>

        <div class="panel">
          <div class="panel-header">
            <h2>Top Artists</h2>
            <a class="text-btn" href="all-artists.php">View all</a>
          </div>
          <div class="panel-body">
            <ul class="activity-list">
              <li class="activity-item">
                <span class="stat-icon green" style="width:36px;height:36px;font-size:14px;border-radius:50%">1</span>
                <div>
                  <div class="activity-text"><strong>Atif Aslam</strong> — Urdu</div>
                  <div class="activity-time">8.4M followers</div>
                </div>
              </li>
              <li class="activity-item">
                <span class="stat-icon blue" style="width:36px;height:36px;font-size:14px;border-radius:50%">2</span>
                <div>
                  <div class="activity-text"><strong>Nusrat Fateh Ali Khan</strong> — Punjabi</div>
                  <div class="activity-time">7.2M followers</div>
                </div>
              </li>
              <li class="activity-item">
                <span class="stat-icon purple" style="width:36px;height:36px;font-size:14px;border-radius:50%">3</span>
                <div>
                  <div class="activity-text"><strong>Ali Zafar</strong> — Urdu</div>
                  <div class="activity-time">6.1M followers</div>
                </div>
              </li>
              <li class="activity-item">
                <span class="stat-icon orange" style="width:36px;height:36px;font-size:14px;border-radius:50%">4</span>
                <div>
                  <div class="activity-text"><strong>Abrar-ul-Haq</strong> — Punjabi</div>
                  <div class="activity-time">2.6M followers</div>
                </div>
              </li>
              <li class="activity-item">
                <span class="stat-icon pink" style="width:36px;height:36px;font-size:14px;border-radius:50%">5</span>
                <div>
                  <div class="activity-text"><strong>Gul Panra</strong> — Pashto</div>
                  <div class="activity-time">1.7M followers</div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>

<?php include_once 'includes/footer.php'; ?>
