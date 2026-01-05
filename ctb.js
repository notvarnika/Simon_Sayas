const paddle = document.getElementById("paddle");
const ball = document.getElementById("ball");
const scoreDisplay = document.getElementById("score");

let score = 0;
let ballSpeed = 2;
let ballY = 0;
let ballX = Math.random() * 380;
let paddleX = 160;

document.addEventListener("keydown", (e) => {
  if (e.key === "ArrowLeft" && paddleX > 0) {
    paddleX -= 20;
  } else if (e.key === "ArrowRight" && paddleX < 320) {
    paddleX += 20;
  }
  paddle.style.left = paddleX + "px";
});

function gameLoop() {
  ballY += ballSpeed;
  ball.style.top = ballY + "px";
  ball.style.left = ballX + "px";

  if (ballY >= 470 && ballX > paddleX && ballX < paddleX + 80) {
    score++;
    scoreDisplay.textContent = "Score: " + score;
    resetBall();
  }

  if (ballY > 500) {
    // Instead of alert, redirect to PHP page with score
    if (!window.redirected) {
      window.redirected = true;
      setTimeout(() => {
        window.location.href = "gameoverctb.php?score=" + score;
      }, 1000);
    }
    return; // stop loop after redirect trigger
  }

  requestAnimationFrame(gameLoop);
}

function resetBall() {
  ballY = 0;
  ballX = Math.random() * 380;
}

function createParticles() {
  const container = document.getElementById("particles");

  for (let i = 0; i < 40; i++) {
    const p = document.createElement("div");
    p.classList.add("particle");

    p.style.left = Math.random() * 100 + "vw";
    p.style.animationDuration = 5 + Math.random() * 5 + "s";
    p.style.animationDelay = Math.random() * 5 + "s";
    p.style.opacity = Math.random();

    container.appendChild(p);
  }
}

createParticles();
gameLoop();
