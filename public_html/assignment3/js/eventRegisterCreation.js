let question = document.getElementById("text-area");
question.addEventListener("input", charCountHandler);

let form = document.getElementById("creation-form");
form.addEventListener("submit", validateCreation);
