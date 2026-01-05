
const emojis = [
  "🐱","🐱","🦝","🦝","🦊","🦊","🐶","🐶",
  "🐵","🐵","🦁","🦁","🐯","🐯","🐮","🐮"
];

let openCards = [];
let lockBoard = false; // prevents clicks during check

// Fisher–Yates shuffle
function shuffle(array) {
  const a = array.slice();
  for (let i = a.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [a[i], a[j]] = [a[j], a[i]];
  }
  return a;
}

const gameEl = document.querySelector(".game");
if (!gameEl) {
  console.error("Missing .game container in HTML.");
}

const shuffled = shuffle(emojis);

// Build board
shuffled.forEach((emoji) => {
  const box = document.createElement("div");
  box.className = "item";
  box.innerHTML = emoji;
  box.addEventListener("click", handleClick);
  gameEl.appendChild(box);
});

function handleClick(e) {
  if (lockBoard) return;

  const box = e.currentTarget;

  // Ignore if already matched or already open
  if (box.classList.contains("boxOpen") || box.classList.contains("boxMatch")) {
    return;
  }

  box.classList.add("boxOpen");
  openCards.push(box);

  if (openCards.length === 2) {
    lockBoard = true;
    setTimeout(checkMatch, 400);
  }
}

function checkMatch() {
  const [first, second] = openCards;

  if (first && second && first.innerHTML === second.innerHTML) {
    first.classList.add("boxMatch");
    second.classList.add("boxMatch");
  } else {
    if (first) first.classList.remove("boxOpen");
    if (second) second.classList.remove("boxOpen");
  }

  openCards = [];
  lockBoard = false;

  // Redirect with score when all matches found
  const matchedCount = document.querySelectorAll(".boxMatch").length;
  if (matchedCount === emojis.length) {
    const score = emojis.length / 2; // 8
    console.log("Redirecting to: gameoverjj.php?score=" + score);
    window.location.assign("gameoverjj.php?score=" + score);
  }
}

