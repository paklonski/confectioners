const name_signup = document.getElementById('name_signup')
const email_signiup = document.getElementById('email_signup')
const password_signup = document.getElementById('password_signup')
const password2_signup = document.getElementById('password2_signup')

const error_signup = document.getElementById('error_signup')
const form_signup = document.getElementById('form_signup')

form_signup.addEventListener('submit', (e) => {
    let messages_signup = []
    if (name_signup.value === '' || name_signup.value == null) {
        messages_signup.push('Name cannot be blank.')
    }
    if (name_signup.value.length < 2) {
        messages_signup.push('Name must be at least 2 characters.'); 
    }
    if (email_signiup.value === '' || email_signiup.value == null) {
        messages_signup.push('Email cannot be blank.')
    }
    if (password_signup.value.length < 8) {
        messages_signup.push('Password must be at least 8 characters.')
    }
    if (password_signup.value.length > 30) {
        messages_signup.push('Password must be maximum 30 characters.')
    }
    if (messages_signup.length > 0) {
        e.preventDefault()
        error_signup.innerText = messages_signup.join('\n ')
    }
})

var password_signup = document.getElementById("password_signup"),
password2_signup = document.getElementById("password2_signup");
function validatePassword() {
    if (password_signup.value != password2_signup.value) {
        password2_signup.setCustomValidity("Passwords do not match.");
    } else {
        password2_signup.setCustomValidity('');
    }
}

password_signup.onchange = validatePassword;
password2_signup.onkeyup = validatePassword;