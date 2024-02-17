let response = document.getElementById("userAns");
response.addEventListener("blur", responseHandler);

let form = document.getElementById("response-form");
form.addEventListener("submit", validateDetail);