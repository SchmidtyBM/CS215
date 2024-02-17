//Validator functions

function validateName(name){
    let nameRegEx = /^[a-zA-Z]+$/;

    if(!nameRegEx.test(name)){
        return false;
    }
    return true;
}

function validateEmail(email){
    let emailRegEx = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

    if(!emailRegEx.test(email)){
        return false;
    }
    return true;
}

function validateAvatar(avatar){
    if(avatar.length === 0){
        return false;
    }
    return true;
}

function validatePassword(password){
    let passwordRegEx = /^(?=.*[^a-zA-Z]).{6,}$/; // /[^a-zA-Z]+{6,}/;

    if(!passwordRegEx.test(password)){
        return false;
    }
    return true;
}

function validateLogin(event){
    let username = document.getElementById("username");
    let password = document.getElementById("password");

    let formIsValid = true;

    const usernameSpan = document.createElement("span");    
    usernameSpan.classList.add("error-text"); 
    let usernameErrorMessage = username.parentNode;

	if(!validateName(username.value)) {
        username.classList.add("error-box");
        usernameSpan.innerHTML = "Invalid username";
        if(usernameErrorMessage.lastChild.innerHTML != usernameSpan.innerHTML){ //used to only print error message once
            usernameErrorMessage.appendChild(usernameSpan);
        }
        formIsValid = false;
    }
    else{
        username.classList.remove("error-box");
        if(usernameErrorMessage.lastChild.innerHTML === usernameSpan.innerHTML){
            usernameErrorMessage.removeChild(usernameErrorMessage.lastChild);
        }
                
	}

    const passwordSpan = document.createElement("span");    
    passwordSpan.classList.add("error-text"); 
    let passwordErrorMessage = password.parentNode;

	if(!validatePassword(password.value)){
        password.classList.add("error-box");
        passwordSpan.innerHTML = "Password must be at least 6 characters";
        if(passwordErrorMessage.lastChild.innerHTML != passwordSpan.innerHTML){ //used to only print error message once
            passwordErrorMessage.appendChild(passwordSpan);
        }
        formIsValid = false;
    }
    else{
        password.classList.remove("error-box");
        if(passwordErrorMessage.lastChild.innerHTML === passwordSpan.innerHTML){
            passwordErrorMessage.removeChild(passwordErrorMessage.lastChild);
        }
	}

    if (formIsValid === false){
		event.preventDefault();
	}
}

function validateSignup(event){
    let email = document.getElementById("email");
	let username = document.getElementById("username");
    let dob = document.getElementById("dateOfBirth");
	let avatar = document.getElementById("avatar");
	let password = document.getElementById("password");
	let confirmPassword = document.getElementById("confirmPassword");
	
	let formIsValid = true;


    const emailSpan = document.createElement("span");    
    emailSpan.classList.add("error-text"); 
    let emailErrorMessage = email.parentNode;

    if(!validateEmail(email.value)){
        email.classList.add("error-box");
        emailSpan.innerHTML = "Invalid email format";
        if(emailErrorMessage.lastChild.innerHTML != emailSpan.innerHTML){ //used to only print error message once
            emailErrorMessage.appendChild(emailSpan);  
        }
        formIsValid = false;
    }
    else{
        email.classList.remove("error-box");
        if(emailErrorMessage.lastChild.innerHTML === emailSpan.innerHTML){
            emailErrorMessage.removeChild(emailErrorMessage.lastChild);
        }
    }

    const usernameSpan = document.createElement("span");    
    usernameSpan.classList.add("error-text"); 
    let usernameErrorMessage = username.parentNode;

	if(!validateName(username.value)) {
        username.classList.add("error-box");
        usernameSpan.innerHTML = "Username must only contain letters";
        if(usernameErrorMessage.lastChild.innerHTML != usernameSpan.innerHTML){ //used to only print error message once
            usernameErrorMessage.appendChild(usernameSpan);
        }
        formIsValid = false;
    }
    else{
        username.classList.remove("error-box");
        if(usernameErrorMessage.lastChild.innerHTML === usernameSpan.innerHTML){
            usernameErrorMessage.removeChild(usernameErrorMessage.lastChild);
        }
                
	}

    const passwordSpan = document.createElement("span");    
    passwordSpan.classList.add("error-text"); 
    let passwordErrorMessage = password.parentNode;

	if(!validatePassword(password.value)){
        password.classList.add("error-box");
        passwordSpan.innerHTML = "Password must be at least 6 characters";
        if(passwordErrorMessage.lastChild.innerHTML != passwordSpan.innerHTML){ //used to only print error message once
            passwordErrorMessage.appendChild(passwordSpan);
        }
        formIsValid = false;
    }
    else{
        password.classList.remove("error-box");
        if(passwordErrorMessage.lastChild.innerHTML === passwordSpan.innerHTML){
            passwordErrorMessage.removeChild(passwordErrorMessage.lastChild);
        }
	}

    const confirmPasswordSpan = document.createElement("span");    
    confirmPasswordSpan.classList.add("error-text"); 
    let confirmPasswordErrorMessage = confirmPassword.parentNode;

	if(password.value != confirmPassword.value){
        confirmPassword.classList.add("error-box");
        confirmPasswordSpan.innerHTML = "Passwords do not match";
        if(confirmPasswordErrorMessage.lastChild.innerHTML != confirmPasswordSpan.innerHTML){ //used to only print error message once
            confirmPasswordErrorMessage.appendChild(confirmPasswordSpan);
        }
        formIsValid = false;
    }
    else{
        confirmPassword.classList.remove("error-box");
        if(confirmPasswordErrorMessage.lastChild.innerHTML === confirmPasswordSpan.innerHTML){
            confirmPasswordErrorMessage.removeChild(confirmPasswordErrorMessage.lastChild);
        }
	}

    const avatarSpan = document.createElement("span");    
    avatarSpan.classList.add("error-text"); 
    let avatarErrorMessage = avatar.parentNode;

	if(!validateAvatar(avatar.value)){
        avatar.classList.add("error-box");
        avatarSpan.innerHTML = "Please provide an avatar";
        if(avatarErrorMessage.lastChild.innerHTML != avatarSpan.innerHTML){ //used to only print error message once
            avatarErrorMessage.appendChild(avatarSpan);
        }
        formIsValid = false;
    }
    else{
        avatar.classList.remove("error-box");
        if(avatarErrorMessage.lastChild.innerHTML === avatarSpan.innerHTML){
            avatarErrorMessage.removeChild(avatarErrorMessage.lastChild);
        }
	}

	if (formIsValid === false){
		event.preventDefault();
	}
}

//Start handler functions

function emailHandler(event){
    let email = event.target;

    const span = document.createElement("span"); 
    span.innerHTML = "Invalid email format";   
    span.classList.add("error-text");            
    
    let errorMessage = email.parentNode;

    if(!validateEmail(email.value)){
        email.classList.add("error-box");
        if(errorMessage.lastChild.innerHTML != span.innerHTML){ //used to only print error message once
            errorMessage.appendChild(span);
        }
    }
    else{
        email.classList.remove("error-box");
        if(errorMessage.lastChild.innerHTML === span.innerHTML){
            errorMessage.removeChild(errorMessage.lastChild);
        }
    }
}

function usernameHandler(event){
    let username = event.target;

    const span = document.createElement("span"); 
    span.innerHTML = "Username must only contain letters";   
    span.classList.add("error-text");            
    
    let errorMessage = username.parentNode;

    if(!validateName(username.value)){
        username.classList.add("error-box");
        if(errorMessage.lastChild.innerHTML != span.innerHTML){ //used to only print error message once
            errorMessage.appendChild(span);
        }
    }
    else{
        username.classList.remove("error-box");
        if(errorMessage.lastChild.innerHTML === span.innerHTML){
            errorMessage.removeChild(errorMessage.lastChild);
        }
    }

}

function avatarHandler(event){
    let avatar = event.target;

    const span = document.createElement("span"); 
    span.innerHTML = "Please provide an avatar";   
    span.classList.add("error-text");           
    
    let errorMessage = avatar.parentNode;
    

    if(!validateAvatar(avatar.value)){
        avatar.classList.add("error-box");
        if(errorMessage.lastChild.innerHTML != span.innerHTML){ //used to only print error message once
            errorMessage.appendChild(span);
        }
    }
    else{
        avatar.classList.remove("error-box");
        if(errorMessage.lastChild.innerHTML === span.innerHTML){
            errorMessage.removeChild(errorMessage.lastChild);
        }
    }
    
}

function passwordHandler(event){
    let password = event.target;

    const span = document.createElement("span");    
    span.innerHTML = "Password must be at least 6 characters";
    span.classList.add("error-text");             
    
    let errorMessage = password.parentNode;

    if(!validatePassword(password.value)){
        password.classList.add("error-box");
        if(errorMessage.lastChild.innerHTML != span.innerHTML){ //used to only print error message once
            errorMessage.appendChild(span);
        }
    }
    else{
        password.classList.remove("error-box");
        if(errorMessage.lastChild.innerHTML === span.innerHTML){
            errorMessage.removeChild(errorMessage.lastChild);
        }
    }
}

function confirmPasswordHandler(event){
    let password = document.getElementById("password");
    let confirmPassword = event.target;

    const span = document.createElement("span"); 
    span.innerHTML = "Passwords do not match";   
    span.classList.add("error-text"); 

    let errorMessage = confirmPassword.parentNode;

	if(password.value != confirmPassword.value){
        confirmPassword.classList.add("error-box");
        if(errorMessage.lastChild.innerHTML != span.innerHTML){ //used to only print error message once
            errorMessage.appendChild(span);
        }
	}
    else{
        confirmPassword.classList.remove("error-box");
        if(errorMessage.lastChild.innerHTML === span.innerHTML){
            errorMessage.removeChild(errorMessage.lastChild);
        }
    }
}