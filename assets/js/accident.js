let map = L.map('map').setView([46.859688, 2.867432], 6);

L.tileLayer('//{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    maxZoom: 18,
}).addTo(map);

let popup = L.popup();
let inputLat = document.querySelector('#latitude');
let inputLng = document.querySelector('#longitude');
let inputCity = document.querySelector('#city');
let inputAdressOrRoadName = document.querySelector('#adressOrRoadName');

map.addEventListener('click', function (click) {
    popup.setLatLng(click.latlng);
    popup.className = 'popup';
    popup.openOn(map);
    latLng = click.latlng.toString();
    const regexLatLng = /-?\d+.\d+/g;
    let latLngTab = latLng.match(regexLatLng);
    let lat = latLngTab[0];
    let lng = latLngTab[1];
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let infoCoor = JSON.parse(this.responseText);
            console.log(this.responseText);
            console.log(infoCoor);
            if (infoCoor.features.length !== 0) {
                let city = infoCoor.features[0].properties.city;
                let adressOrRoadName = infoCoor.features[0].properties.label;
                inputLat.value = lat;
                inputLng.value = lng;
                inputCity.value = city;
                inputAdressOrRoadName.value = adressOrRoadName;
            }else{
                inputLat.value = lat;
                inputLng.value = lng;
            }
        }
    }
    xhr.open('GET', 'https://api-adresse.data.gouv.fr/reverse/?lon=' + lng + '&lat=' + lat, true);
    xhr.send();
});
