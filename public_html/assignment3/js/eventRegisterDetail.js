let response = document.getElementById("text-area");
response.addEventListener("input", charCountHandler);

let form = document.getElementById("response-form");
form.addEventListener("submit", validateDetail);
