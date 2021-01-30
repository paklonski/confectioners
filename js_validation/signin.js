const email_signin = document.getElementById('email_signin')
const password_signin = document.getElementById('password_signin')

const error_signin = document.getElementById('error_signin')
const form_signin = document.getElementById('form_signin')

form_signin.addEventListener('submit', (e) => {
    let messages_signin = []
    if (email_signin.value === '' || email_signin.value == null) {
        messages_signin.push('Email cannot be blank.')
    }
    if (password_signin.value === '' || password_signin.value == null) {
        messages_signin.push('Password cannot be blank.')
    }
    if (password_signin.value.length < 8) {
        messages_signin.push('Password must be at least 8 characters.')
    }
    
    if (messages_signin.length > 0) {
        e.preventDefault()
        error_signin.innerText = messages_signin.join('\n ')
    }
})