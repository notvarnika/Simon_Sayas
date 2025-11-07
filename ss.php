<?php
session_start();
$username = $_SESSION['username'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIMON SAY'S GAME</title>
  <link rel="stylesheet" href="simon.css">
</head>
<body>
  <h1>Simon Says Game</h1>
  <h2>Press any key to start the game</h2>

  <?php if ($username): ?>
    <p>Welcome, <strong><?php echo htmlspecialchars($username); ?></strong>!</p>
  <?php else: ?>
    <p><a href="index.php">Login to save your score</a></p>
  <?php endif; ?>

  <div class="btn-container">
    <div class="line-1">
      <div class="btn red" type="button" id="red">1</div>
      <div class="btn yellow" type="button" id="yellow">2</div>
    </div>
    <div class="line-2">
      <div class="btn green" type="button" id="green">3</div>
      <div class="btn purple" type="button" id="purple">4</div>
    </div>
  </div>

  <script src="simon.js"></script>
</body>
</html>
