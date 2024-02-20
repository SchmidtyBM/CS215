let response = document.getElementById("text-area");
response.addEventListener("blur", responseHandler);

let text = document.getElementById("text-area");
text.addEventListener("input", charCountHandler);

let form = document.getElementById("response-form");
form.addEventListener("submit", validateDetail);