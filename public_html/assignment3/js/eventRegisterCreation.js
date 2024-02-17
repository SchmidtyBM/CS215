let question = document.getElementById("question");
question.addEventListener("blur", questionHandler);

let form = document.getElementById("creation-form");
form.addEventListener("submit", validateCreation);