let countdown;
const timerDisplay = document.querySelector(".display_time");
const button25 = document.querySelector("#pomodoro");
const shortBreak = document.querySelector("#shortBreak");
const longBreak = document.querySelector("#longBreak");
const reset = document.querySelector("#reset");
const audio = document.querySelector("audio");

function timer(seconds) {
  clearInterval(countdown); 
  const now = Date.now(); 
  const then = now + seconds * 1000;
  displayTimeLeft(seconds);

  countdown = setInterval(() => {
    const secondsLeft = Math.round((then - Date.now()) / 1000);
    if (secondsLeft == 0) {
      audio.play();
    } else if (secondsLeft < 0) {
      clearInterval(countdown);
      return;
    }
    displayTimeLeft(secondsLeft);
  }, 1000);
}

function displayTimeLeft(seconds) {
  const minutes = Math.floor(seconds / 60);
  const remainderSeconds = seconds % 60;
  const display = `${minutes}:${
    remainderSeconds < 10 ? "0" : ""
  }${remainderSeconds}`;
  timerDisplay.textContent = display;
}

button25.addEventListener("click", function() {
  timer(60 * 25);
});
shortBreak.addEventListener("click", function() {
  timer(5 * 60);
});
longBreak.addEventListener("click", function() {
  timer(10 * 60);
});
reset.addEventListener("click", function() {
  clearInterval(countdown);
  timerDisplay.textContent = "0:00";
});
