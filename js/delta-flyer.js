
function makeMap(toggle, mapInput, mapInputHolder, mapHolderId, lat, lng, nameInput, latInput, lngInput){

    var noMapInput = fromInput.innerHTML;
    toggle.addEventListener('click', function(e){
        mapInputHolder.innerHTML = noMapInput;
    });

    mapInputHolder.innerHTML = mapInput;

    var map = L.map(mapHolderId).setView([lat, lng], 4);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; <a href='https://www.openstreetmap.org/copyright'>OpenStreetMap</a> contributors"
    }).addTo(map);
    var marker = new L.marker(map.getCenter(), {clickable:false});
    marker.addTo(map);

    var latInput = document.getElementById(latInput);
    var lngInput = document.getElementById(lngInput);
    var nameInput = document.getElementById(nameInput);

    map.on("moveend", function(e){
        marker.setLatLng(map.getCenter());
        latInput.value = L.latLng(map.getCenter()).lat;
        lngInput.value = L.latLng(map.getCenter()).lng;
    });

    var geonames_url_base = "https://secure.geonames.org/countrySubdivisionJSON?";
    var geonames_user = "&username=rhiaro";

    map.on("mouseout", function(){
        var lat = L.latLng(map.getCenter()).lat;
        var lng = L.latLng(map.getCenter()).lng;
        var geonames_url = geonames_url_base + "lat=" + lat  + "&lng=" + lng  + geonames_user;
        var request = new XMLHttpRequest();
        request.open("GET", geonames_url, true);
        request.onload = function(){
            var response = this.response;
            var responseJson = JSON.parse(response)
            var subdivision = responseJson.adminName1;
            var country = responseJson.countryName;
            nameInput.value = subdivision + ", " + country;
        };
        request.send();
    });

}

var fromInput = document.getElementById("fromInput");
document.getElementById("toggleFromMap").addEventListener('click', function(e){
    makeMap(e.target, fromMap, fromInput, "startMap", startLat, startLng, "startname", "startlat", "startlng");
});
if(fromMapOn){
    makeMap(document.getElementById("toggleFromMap"), fromMap, fromInput, "startMap", startLat, startLng, "startname", "startlat", "startlng");
}

var toInput = document.getElementById("toInput");
document.getElementById("toggleToMap").addEventListener('click', function(e){
    makeMap(e.target, toMap, toInput, "endMap", endLat, endLng, "endname", "endlat", "endlng");
});
if(toMapOn){
    makeMap(document.getElementById("toggleToMap"), toMap, toInput, "endMap", endLat, endLng, "endname", "endlat", "endlng");
}

