let dropdown = document.getElementById("travel-type");
let payment = document.getElementById("payment");
let secondDisplay = document.querySelectorAll(".hide-travel-type");
let paymentDisplay = document.querySelectorAll(".payment-type");

secondDisplay.forEach(function (e) {
  e.style.display = "none";
});
paymentDisplay.forEach(function (e) {
  e.style.display = "none";
});

dropdown.addEventListener("change", function (event) {
  let selectedValue = event.target.value;

  secondDisplay.forEach(function (e) {
    e.style.display = "none";
  });
  paymentDisplay.forEach(function (e) {
    e.style.display = "none";
  });

  document.querySelector(`.${selectedValue.toLowerCase()}`).style.display =
    "grid";
});
payment.addEventListener("change", function (event) {
  let selectedValue = event.target.value;

  paymentDisplay.forEach(function (e) {
    e.style.display = "none";
  });

  document.querySelector(`.${selectedValue.toLowerCase()}`).style.display =
    "grid";
});
