<?php
session_start();
include 'dbcon.php'; 

$score = isset($_GET['score']) ? intval($_GET['score']) : 0;
$username = $_SESSION['username'] ?? 'Guest';

if ($username !== 'Guest') {
    $stmt = $pdo->prepare("UPDATE logindata SET scoreboard = ? WHERE username = ?");
    $stmt->execute([$score, $username]);

    $stmt = $pdo->prepare("SELECT score FROM leaderboard WHERE username = ?");
    $stmt->execute([$username]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        if ($score > $existing['score']) {
            $update = $pdo->prepare("UPDATE leaderboard SET score = ?, timestamp = NOW() WHERE username = ?");
            $update->execute([$score, $username]);
        }
    } else {
        $insert = $pdo->prepare("INSERT INTO leaderboard (username, score) VALUES (?, ?)");
        $insert->execute([$username, $score]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game Over </title>
  <link rel="stylesheet" href="gameover.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <section>
    <div class="login-box">
      <h1>Game Over!</h1>
      <p class="score">Username: <strong><?php echo htmlspecialchars($username); ?></strong></p>
      <p class="score">Your Score: <strong><?php echo $score; ?></strong></p>
      <p>Better luck next time!</p>
      <a href="ss.php">Play Again</a>
      <a href="leaderboard.php">Check Leaderboard</a>
    </div>
  </section>
</body>
</html>
