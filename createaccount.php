<?php
session_start();
include 'dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username    = $_POST['username'] ?? '';
    $email       = $_POST['email'] ?? '';
    $password    = $_POST['password'] ?? '';
    $confirmpw   = $_POST['confirm_password'] ?? '';

    if ($password !== $confirmpw) {
        $error = "Passwords do not match.";
    } else {
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("SELECT * FROM logindata WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $error = "Account already exists! <a href='index.php'>Try logging in</a>";
        } else {
            $stmt = $pdo->prepare("INSERT INTO logindata (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashed_pw])) {
                $_SESSION['username'] = $username;
                header("Location: menu.php");
                exit();
            } else {
                $error = "Error creating account.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
  <link rel="stylesheet" href="login.css"> 

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <section>
    <div class="login-box">
      <form action="createaccount.php" method="POST">
        <h2>Create Your Account</h2>

        <div class="input-box">
          <span class="icon"><ion-icon name="person"></ion-icon></span>
          <input type="text" name="username" placeholder="Username" required>
          <label>Username</label>
        </div>

        <div class="input-box">
          <span class="icon"><ion-icon name="mail"></ion-icon></span>
          <input type="email" name="email" placeholder="Email" required>
          <label>Email</label>
        </div>

        <div class="input-box">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
          <input type="password" name="password" placeholder="Password" required>
          <label>Password</label>
        </div>

        <div class="input-box">
          <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
          <input type="password" name="confirm_password" placeholder="Confirm Password" required>
          <label>Confirm Password</label>
        </div>

        <button type="submit">Register</button>

        <div class="register-link">
          <p>Already have an account? <a href="index.php">Login</a></p>
        </div>

        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
      </form>
    </div>
  </section>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
