<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
include 'dbcon.php';

$score = isset($_GET['score']) ? intval($_GET['score']) : 0;
$username = $_SESSION['username'] ?? 'Guest';

if ($username !== 'Guest') {
    $stmt = $pdo->prepare("UPDATE logindata SET scoreboard = ? WHERE username = ?");
    $stmt->execute([$score, $username]);

    $stmt = $pdo->prepare("SELECT score FROM leaderboard WHERE username = ? AND game = ?");
    $stmt->execute([$username, 'wordguess']);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        if ($score > $existing['score']) {
            $update = $pdo->prepare("UPDATE leaderboard SET score = ?, timestamp = NOW() WHERE username = ? AND game = ?");
            $update->execute([$score, $username, 'wordguess']);
        }
    } else {
        $insert = $pdo->prepare("INSERT INTO leaderboard (username, score, game) VALUES (?, ?, ?)");
        $insert->execute([$username, $score, 'wordguess']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game Over - Word Guess</title>
  <link rel="stylesheet" href="gameoverfp.css">
</head>
<body>
  <section>
    <div class="login-box">
      <h1>Game Over!</h1>
      <p class="score">Username: <strong><?php echo htmlspecialchars($username); ?></strong></p>
      <p class="score">Your Score: <strong><?php echo $score; ?></strong></p>
      <p>Thanks for playing!</p>
      <a href="wgindex.html">Play Again</a>
      <a href="wgleaderboard.php">Check Leaderboard</a>
    </div>
  </section>
</body>
</html>
