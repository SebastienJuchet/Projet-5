/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../scss/app.scss';

let picture = document.querySelector('.picture-profil')
let modal = document.querySelector('.identity')
picture.addEventListener('click', (e) => {
    modal.classList.toggle('identity-display')
})
