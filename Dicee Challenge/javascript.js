var randomNumber1 = Math.floor(Math.random() * 6) + 1;
var randomNumber2 = Math.floor(Math.random() * 6) + 1;

var imageSrc = "images/dice5.png";
var replacedSrc = imageSrc.replace("5", randomNumber1);

var replaced2Src = imageSrc.replace("5", randomNumber2);

var firstDice = document
  .querySelector(".img1")
  .setAttribute("src", replacedSrc);
var secondDice = document
  .querySelector(".img2")
  .setAttribute("src", replaced2Src);

if (randomNumber1 > randomNumber2) {
  document.querySelector("h1").innerText = "Player one won!";
} else if (randomNumber1 < randomNumber2) {
  document.querySelector("h1").innerText = "Player 2 won!";
} else {
  document.querySelector("h1").innerText = "Friendship won!";
}
