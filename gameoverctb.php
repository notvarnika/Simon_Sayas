<?php
session_start();
include 'dbcon.php'; 

$score = isset($_GET['score']) ? intval($_GET['score']) : 0;
$username = $_SESSION['username'] ?? 'Guest';
$game = $_GET['game'] ?? 'CatchTheBall';

if ($username !== 'Guest') {
    try {
        // Update latest score in logindata
        $stmt = $pdo->prepare("UPDATE logindata SET scoreboard = ? WHERE username = ?");
        $stmt->execute([$score, $username]);

        // Check leaderboard
        $stmt = $pdo->prepare("SELECT score FROM leaderboard WHERE username = ? AND game = ?");
        $stmt->execute([$username, $game]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            if ($score > $existing['score']) {
                $update = $pdo->prepare("UPDATE leaderboard 
                                         SET score = ?, timestamp = NOW() 
                                         WHERE username = ? AND game = ?");
                $update->execute([$score, $username, $game]);
            }
        } else {
            $insert = $pdo->prepare("INSERT INTO leaderboard (username, score, game) VALUES (?, ?, ?)");
            $insert->execute([$username, $score, $game]);
        }
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game Over - <?php echo htmlspecialchars($game); ?></title>
  <link rel="stylesheet" href="gameoverfp.css">
</head>
<body>
  <section>
    <div class="login-box">
      <h1>Game Over!</h1>
      <p class="score">Username: <strong><?php echo htmlspecialchars($username); ?></strong></p>
      <p class="score">Your Score: <strong><?php echo $score; ?></strong></p>
      <p>Nice job!</p>
      <a href="ctb.html">Play Again</a>
      <a href="menu.php">Back to Menu</a>
      <a href="leaderboardctb.php">Leaderboard</a>
    </div>
  </section>
</body>
</html>
