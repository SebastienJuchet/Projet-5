import '../scss/app.scss';
import '../js/picture.js';
import FormValidate from '../js/formValidate.js'

let btnFormVehicle = document.querySelector('#btn-form-vehicle')
if (btnFormVehicle) {
    btnFormVehicle.addEventListener('click', (e) => {
        let inputTitle = new FormValidate('vehicle_title').checkText()
        let inputMark = new FormValidate('vehicle_mark').checkText()
        let inputModel = new FormValidate('vehicle_model').checkText()
        let inputDescription = new FormValidate('vehicle_description').checkTextarea()
        let inputCity = new FormValidate('vehicle_city').checkCity()
        
        let inputPrice = new FormValidate('vehicle_price').checkPrice()
        let inputKms = new FormValidate('vehicle_kms').checkKms()
         if (!inputTitle || !inputMark || !inputModel || !inputDescription || !inputCity || !inputPrice || !inputKms) {
             e.preventDefault()
         }
    })
}

let url = window.location.pathname 

if (url.includes('/vehicule/edit') || url.includes('/vehicule/create')) {
    let geocoder = new MapboxGeocoder({
            accessToken: 'pk.eyJ1IjoiYnJvd2x5NDAiLCJhIjoiY2s2OTQ1b3AwMGIxcjNrcWo0MXdtZTRseCJ9.goBmMVra4yIQgexoPzL3fw',
            countries: 'fr',
            types: 'country,region,place,locality',
            placeholder: 'Entrez votre ville'
        })
    
    geocoder.addTo('#geocoder');

    geocoder.on('result', (e) => {
        let city = e.result.place_name
        let long = e.result.center[0]
        let lat = e.result.center[1]

        document.querySelector('#vehicle_city').value = city
        document.querySelector('#vehicle_longitude').value = long
        document.querySelector('#vehicle_latitude').value = lat
    })
}

if (document.querySelector('#map')) {
    let longitude = document.querySelector('#longitude').value
    let latitude = document.querySelector('#latitude').value
    mapboxgl.accessToken = 'pk.eyJ1IjoiYnJvd2x5NDAiLCJhIjoiY2s2OTQ1b3AwMGIxcjNrcWo0MXdtZTRseCJ9.goBmMVra4yIQgexoPzL3fw'
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
        center: [longitude, latitude], // starting position [lng, lat]
        zoom: 10 // starting zoom
    })

    let marker = new mapboxgl.Marker()
        .setLngLat([longitude, latitude])
        .addTo(map)
}

let picture = document.querySelector('.picture-profil')
let modal = document.querySelector('.identity')
if (picture) {
    picture.addEventListener('click', (e) => {
        modal.classList.toggle('identity-display')
    })
}
