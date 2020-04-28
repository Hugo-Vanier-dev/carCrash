let map = L.map('map').setView([46.859688, 2.867432], 6);

L.tileLayer('//{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    maxZoom: 18,
}).addTo(map);
window.addEventListener("DOMContentLoaded", function () {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        console.log(this.status);
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(this.responseText);
            let infoCoorTab = JSON.parse(this.responseText);
            if (infoCoorTab.length !== 0) {
                for (let i = 0; i < infoCoorTab.length; i++) {
                    L.circle([infoCoorTab[i].latitude, infoCoorTab[i].longitude], {
                        color: 'red',
                        fillColor: '#f03',
                        fillOpacity: 0.5,
                        radius: 100
                    }).addTo(map);
                }
            }
        }
    }
    xhr.open('GET', '../../controllers/indexCtrl.php?getAccidents=true', true);
    xhr.send();

});


