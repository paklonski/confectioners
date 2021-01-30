const image_offer = document.getElementById('image_offer')
const name_offer = document.getElementById('name_offer')
const description_offer = document.getElementById('description_offer')
const price_offer = document.getElementById('price_offer')
const phonenumber_offer = document.getElementById('phonenumber_offer')

const error_offer = document.getElementById('error_offer')
const form_offer = document.getElementById('form_offer')

form_offer.addEventListener('submit', (e) => {
    let messages_offer = []
    if (name_offer.value === '' || name_offer.value == null) {
        messages_offer.push('Name cannot be blank.')
    }
    if (description_offer.value === '' || description_offer.value == null) {
        messages_offer.push('Description cannot be blank.')
    }
    if (price_offer.value === '' || price_offer.value == null) {
        messages_offer.push('Price cannot be blank.')
    }
    if (phonenumber_offer.value.length != 9) {
        messages_offer.push('Phone number must contain 9 digits.')
    }
    if (image_offer.value === '' || image_offer.value == null) {
        messages_offer.push('Image cannot be null.')
    }
    if (messages_offer.length > 0) {
        e.preventDefault()
        error_offer.innerText = messages_offer.join('\n ')
    }
})