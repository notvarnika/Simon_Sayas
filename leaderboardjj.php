<?php
session_start();
include 'dbcon.php';
$stmt = $pdo->prepare("SELECT username, score, timestamp 
                       FROM leaderboard 
                       WHERE game = 'jj'
                       ORDER BY score DESC");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JJ Leaderboard</title>
  <link rel="stylesheet" href="gameoverfp.css">
</head>
<body>
  <section>
    <div class="login-box">
      <h1>JJ Leaderboard</h1>
      <table style="width:100%; border-collapse: collapse; margin-top:20px;">
        <tr style="background:#ccc;">
          <th style="padding:10px; border:1px solid #999;">Rank</th>
          <th style="padding:10px; border:1px solid #999;">Username</th>
          <th style="padding:10px; border:1px solid #999;">Score</th>
        </tr>
        <?php 
        $rank = 1;
        foreach ($rows as $row): ?>
          <tr>
            <td style="padding:10px; border:1px solid #999;"><?php echo $rank++; ?></td>
            <td style="padding:10px; border:1px solid #999;"><?php echo htmlspecialchars($row['username']); ?></td>
            <td style="padding:10px; border:1px solid #999;"><?php echo $row['score']; ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
      <a href="jojoindex.html">Play Again</a>
      <a href="menu.php">Back to Menu</a>
    </div>
  </section>
</body>
</html>
