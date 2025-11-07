<?php
include 'dbcon.php';

$stmt = $pdo->query("SELECT username, score FROM leaderboard ORDER BY score DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leaderboard</title>
  <link rel="stylesheet" href="leaderboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <section>
    <div class="login-box">
      <h2>TOP SIMON SAY-ERS!!</h2>
      <table>
        <tr><th>Username</th><th>Score</th></tr>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= $row['score'] ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </section>
</body>
</html>
