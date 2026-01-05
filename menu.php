<?php
session_start();
include 'dbcon.php';

$username = $_SESSION['username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Game Menu</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Orbitron', sans-serif;
    }

    body, html {
      height: 100%;
      width: 100%;
      background: linear-gradient(270deg, #d3d3d3, #f0f0f0, #c0c0c0);
      background-size: 600% 600%;
      animation: bgAnimation 12s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    @keyframes bgAnimation {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .menu-box {
      width: 90%;
      max-width: 700px;
      background: rgba(255, 255, 255, 0.9);
      border: 2px solid #ccc;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(128, 128, 128, 0.3);
      padding: 30px;
      text-align: center;
    }

    h1 {
      font-size: 2em;
      margin-bottom: 20px;
      color: #333;
    }

    ul {
      list-style: none;
      padding: 0;
      margin: 20px 0;
    }

    ul li {
      margin: 12px 0;
    }

    ul li a {
      display: inline-block;
      width: 100%;
      padding: 12px;
      background: #333;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    ul li a:hover {
      background: #555;
      transform: translateX(5px);
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 1.5em;
      }
      ul li a {
        font-size: 0.9em;
        padding: 10px;
      }
    }
  </style>
</head>
<body>
  <section>
    <div class="menu-box">
      <h1>Welcome Back, <strong><?= htmlspecialchars($username) ?></strong>!</h1>
      <p><strong>Choose a game to play:</strong></p>
      <ul>
        <li><a href="fpindex.html">Flappy Bird</a></li>
        <li><a href="jojoindex.html">Memory Match</a></li>
        <li><a href="pcindex.html">Pac-Man</a></li>
        <li><a href="wgindex.html">Guess The Word</a></li>
        <li><a href="ss.php">Simon Says</a></li>
        <li><a href="ctb.html">Catch The Ball!</a></li>

      </ul>
    </div>
  </section>
</body>
</html>
