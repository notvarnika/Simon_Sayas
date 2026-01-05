<?php
session_start();
include 'dbcon.php';

$score = isset($_GET['score']) ? intval($_GET['score']) : 0;
$username = $_SESSION['username'] ?? 'Guest';

if ($username !== 'Guest') {
    $stmt = $pdo->prepare("UPDATE logindata SET scoreboard = ? WHERE username = ?");
    $stmt->execute([$score, $username]);

    $stmt = $pdo->prepare("SELECT score FROM leaderboard WHERE username = ? AND game = ?");
    $stmt->execute([$username, 'pacman']);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        if ($score > $existing['score']) {
            $update = $pdo->prepare("UPDATE leaderboard SET score = ?, timestamp = NOW() WHERE username = ? AND game = ?");
            $update->execute([$score, $username, 'pacman']);
        }
    } else {
        $insert = $pdo->prepare("INSERT INTO leaderboard (username, score, game) VALUES (?, ?, ?)");
        $insert->execute([$username, $score, 'pacman']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game Over - Pac-Man</title>
  <link rel="stylesheet" href="gameoverfp.css">
</head>
<body>
  <section>
    <div class="login-box">
      <h1>Game Over!</h1>
      <p class="score">Username: <strong><?php echo htmlspecialchars($username); ?></strong></p>
      <p class="score">Your Score: <strong><?php echo $score; ?></strong></p>
      <p>Chomped your way through!</p>
      <a href="pacmanindex.html">Play Again</a>
      <a href="leaderboardpc.php">Check Leaderboard</a>
    </div>
  </section>
</body>
</html>
