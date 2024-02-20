let question = document.getElementById("text-area");
question.addEventListener("blur", questionHandler);

let text = document.getElementById("text-area");
text.addEventListener("input", charCountHandler);

let form = document.getElementById("creation-form");
form.addEventListener("submit", validateCreation);