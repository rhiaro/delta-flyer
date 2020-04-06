document.getElementById("locationsinput").innerHTML = coordsform;

var startMap = L.map("startMap").setView([45.505, 20.14], 4);
var endMap = L.map("endMap").setView([45.505, 20.14], 4);

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; <a href='https://www.openstreetmap.org/copyright'>OpenStreetMap</a> contributors"
}).addTo(startMap);
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; <a href='https://www.openstreetmap.org/copyright'>OpenStreetMap</a> contributors"
}).addTo(endMap);

var startMarker = new L.marker(startMap.getCenter(), {clickable:false});
startMarker.addTo(startMap);
var endMarker = new L.marker(endMap.getCenter(), {clickable:false});
endMarker.addTo(endMap);

var startLatInput = document.getElementById("startlat");
var startLngInput = document.getElementById("startlng");
var endLatInput = document.getElementById("endlat");
var endLngInput = document.getElementById("endlng");

startMap.on("moveend", function(e){
    startMarker.setLatLng(startMap.getCenter());
    startLatInput.value = L.latLng(startMap.getCenter()).lat;
    startLngInput.value = L.latLng(startMap.getCenter()).lng;
});

endMap.on("moveend", function(e){
    endMarker.setLatLng(endMap.getCenter());
    endLatInput.value = L.latLng(endMap.getCenter()).lat;
    endLngInput.value = L.latLng(endMap.getCenter()).lng;
});

function fillNameBox(box, response){
    var responseJson = JSON.parse(response)
    var subdivision = responseJson.adminName1;
    var country = responseJson.countryName;
    box.value = subdivision + ", " + country;
}

var geonames_url_base = "http://api.geonames.org/countrySubdivisionJSON?";
var geonames_user = "&username=rhiaro";

startMap.on("mouseout", function(){
    var startBox = document.getElementById("startname");
    var startLat = L.latLng(startMap.getCenter()).lat;
    var startLng = L.latLng(startMap.getCenter()).lng;
    var geonames_url = geonames_url_base + "lat=" + startLat  + "&lng=" + startLng  + geonames_user;
    var request = new XMLHttpRequest();
    request.open("GET", geonames_url, true);
    request.onload = function(){
        var response = this.response;
        return fillNameBox(startBox, response);
    };
    request.send();
});

endMap.on("mouseout", function(){
    var endBox = document.getElementById("endname");
    var endLat = L.latLng(endMap.getCenter()).lat;
    var endLng = L.latLng(endMap.getCenter()).lng;
    var geonames_url = geonames_url_base + "lat=" + endLat  + "&lng=" + endLng  + geonames_user;
    var request = new XMLHttpRequest();
    request.open("GET", geonames_url, true);
    request.onload = function(){
        var response = this.response;
        return fillNameBox(endBox, response);
    };
    request.send();
});